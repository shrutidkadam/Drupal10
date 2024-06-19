<?php
namespace Drupal\demotest\Plugin\rest\resource;

use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * @RestResource(
 *   id = "post_cutom_data",
 *   label =  "Post Custom Data",
 *   uri_paths = {
 *     "canonical" = "/postchdata/v1",
 *     "create" = "/postchdata/v1",
 *   }
 * )
 */
class UpdateData extends ResourceBase {

  public function post($data) {
    $nid = $data['id'] ?: NULL;
    if($nid ) {
      $event_node = Node::load($nid);
      $event_node->set('title', $data['title']);
      $event_node->save();
      return new ResourceResponse($event_node);
    }
    else return new ResourceResponse(['node id is invalid'], 404);
  }
}
