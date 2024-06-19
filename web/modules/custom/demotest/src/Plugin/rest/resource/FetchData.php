<?php
namespace Drupal\demotest\Plugin\rest\resource;

use Drupal\node\Entity\Node;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * @RestResource(
 *   id = "fetch_cutom_data",
 *   label =  "Fetch Custom Data",
 *   uri_paths = {
 *     "canonical" = "/fetchdata/v1"
 *   }
 * )
 */

class FetchData extends ResourceBase {

  public function get() {
     $event_node_ids = [];
     $node_ids = \Drupal::entityQuery('node')->condition('type', 'events')->accessCheck(FALSE)->execute();
     foreach ($node_ids as $node_id) {
       $event_node = Node::load($node_id);
       $event_node_ids['id'][] = $event_node->id();
       $event_node_ids['title'][] = $event_node->getTitle();
     }

//     $conn = \Drupal::database();
//     $query = $conn->select('node', 'n');
//     $query->fields('n', ['nid']);
//     $query->join('users', 'u', 'n.uid = u.uid');
//     $query->fields('u', ['uuid']);
//    $result = $query->execute();

     return new ResourceResponse($event_node_ids);
  }
}
