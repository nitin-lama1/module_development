<?php

namespace Drupal\node_generator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class FeedbackForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'feedback_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $uid= $user->get('uid')->value;

    $form['name'] = [
      '#title' => 'Name',
      '#type' => 'textfield',
      '#placeholder' => 'Enter Name'
    ];

    $options = [
      'value_1' => 'Value 1',
      'value_2' => 'Value 2',
      'value_3' => 'Value 3',
      'value_4' => 'Value 4',
      'value_5' => 'Value 5'
    ];

    $form['feedback'] = [
      '#type' => 'radios',
      '#title' => 'Feedback',
      '#options' => $options,
      '#description' => 'Select one of the option.',
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
      '#button_type' => 'primary',
    ];


    return $form;
  }

  /**
  * {@inheritdoc}
  */
 public function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValues()['name'];
    $feedback = $form_state->getValues()['feedback'];
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    $uid= $user->get('uid')->value;
    $field_arr = [
    'uid' => $uid,
    'name' => $name,
    'feedback' => $feedback,
    'created_date' => date('d-m-y h:i:s'),
    ];
    $query = \Drupal::database();
    $query->insert('feedback')
        ->fields($field_arr)
        ->execute();
    \Drupal::messenger()->addMessage("Feedback submitted");
 }
}
