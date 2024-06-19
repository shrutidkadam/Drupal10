<?php
namespace Drupal\custom_exports\Plugin\rest\resource;

use Drupal\Component\DependencyInjection\ContainerInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Drupal\Node\Entity\Node;

/**
 * @RestResource(
 *   id = "get_node_title",
 *   label = "Get all node title",
 *   uri_paths = {
 *      "canonical" = "/nodes-title",
 *    }
 * )
 */
class GetTitleResource extends ResourceBase {

  public function get() {
    $node_results = [];
    $node_ids = \Drupal::entityQuery('node')->condition('type', 'events')->accessCheck(FALSE)->execute();
    foreach ($node_ids as $node_id){
      $eventval = Node::load($node_id);
      $node_results[] = [
        'title' => $eventval->getTitle(),
      ];
    }
    $response = new ResourceResponse($node_results);
    return $response;
  }

  public function post($data) {
    $response = new ResourceResponse('200');
    return $response;
  }


}
