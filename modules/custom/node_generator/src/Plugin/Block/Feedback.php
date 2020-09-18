<?php

namespace Drupal\node_generator\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormInterface;

/**
 * Provides a 'Feedback Form' block.
 *
 * @Block(
 *   id = "feedback_block",
 *   admin_label = @Translation("Feedback Form"),
 *   category = @Translation("Block for feedback")
 * )
 */
class Feedback extends BlockBase {
  /**
     * {@inheritdoc}
     */
    public function build() {
      $form = \Drupal::formBuilder()->getForm('Drupal\node_generator\Form\FeedbackForm');
      return $form;
    }
}

?>
