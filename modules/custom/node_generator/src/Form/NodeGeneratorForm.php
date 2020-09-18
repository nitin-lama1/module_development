<?php

namespace Drupal\node_generator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class NodeGeneratorForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'generate_nodes';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $node_types = \Drupal\node\Entity\NodeType::loadMultiple();
    $options = [];
    foreach ($node_types as $node_type) {
      $options[$node_type->id()] = $node_type->label();
    }

    $form['type'] = [
      '#title' => 'Content Type',
      '#type' => 'select',
      '#options' => $options,
    ];

    $form['count'] = [
      '#title' => 'Number of Nodes',
      '#type' => 'number',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Generate Node',
      '#button_type' => 'primary',
    ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    $validate = $form_state->getValue('count');
    if ($validate < 2 || $validate > 10) {
      $form_state->setErrorByName('count', 'Minimum 2 & Maximimum 10 nodes to be generated.');
    }
  }

  /**
  * {@inheritdoc}
  */
 public function submitForm(array &$form, FormStateInterface $form_state) {
   $content_type = $form_state->getValues()['type'];
   $node_count = $form_state->getValues()['count'];
   $form_id = $form['form_id']['#value'];
   $batch = [
    'title' => 'Generating Nodes.',
    'operations' => [
    [
      '\Drupal\node_generator\NodeGenerateBatch::Generate',
      [$content_type, $node_count, $title = NULL, $body = NULL, $form_id],
      ],
    ],
    'finished' => '\Drupal\node_generator\NodeGenerateBatch::NodeGenerateCallback',
  ];
  batch_set($batch);
  }
}
