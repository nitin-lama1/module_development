<?php

namespace Drupal\node_generator;

use Drupal\node\Entity\Node;

/**
 *  Batch Process to generate node
 */
class NodeGenerateBatch {

  /**
   * @param $content_type,
   * @param $node_count
   * @param $title
   * @param $body
   */
  public static function Generate($content_type, $node_count, $title, $body, $form_id, &$context) {
    $message = 'Generating Nodes...';
    if ($form_id == 'generate_nodes') {
      // Creating an instance.
      $random = new \Drupal\Component\Utility\Random();
      // Node Create with new values.
      for ($i=1; $i <= $node_count; $i++) {
      $node = Node::create(
        [
          'type' => $content_type,
          'title' => $random->name(5),
          'body' => [
            'summary' => '',
            'value' => $random->name(100),
            'format' => 'full_html',
          ],
        ]
      );

      $results[] = $node->save();
      }
    }

   elseif ($form_id == 'node_generate') {
      for ($i=1; $i <= $node_count; $i++) {
      $node = Node::create(
        [
          'type' => $content_type,
          'title' => $title,
          'body' => [
            'summary' => '',
            'value' => $body,
            'format' => 'full_html',
          ],
        ]
      );

      $results[] = $node->save();
      }
    }

    $context['message'] = $message;
    $context['results'] = $results;
  }

  /**
   * @param $success
   * @param $results
   * @param $operations
   */
  public static function NodeGenerateCallback($success, $results, $operations) {
    // The 'success' parameter means no fatal PHP errors were detected. All
    // other error management should be handled using 'results'.
    if ($success) {
      $message = \Drupal::translation()->formatPlural(count($results),'One Node generated.', '@count node generated.');
    }
    else {
      $message = 'Finished with an error.';
    }
    \Drupal::messenger()->addmessage($message);
  }

}
