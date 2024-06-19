<?php
namespace Drupal\dac_module\Plugin\rest\resource;

use Drupal\node\Entity\Node;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * @RestResource (
 *   id = "dac_fetch",
 *   label = "dac get rest resource",
 *   uri_paths = {
 *     "canonical" = "dacfetch/v1",
 *     "create" = "dacfetch/v1",
 *   }
 *
 * )
 */
class DacFetch extends ResourceBase {

  public function get() {
    $events_title = [];
    $event_nids = \Drupal::entityQuery('node')->condition('type', 'events')->accessCheck(FALSE)->execute();
    foreach ($event_nids as $event_nid) {
      $event_obj = Node::load($event_nid);
      $events_title[] = $event_obj->getTitle();
    }
    return new ResourceResponse($events_title);

  }

  public function post($data) {

    $node = Node::create([
      'type' => 'events',
      'title' => $data['title'],
      'status' => 1,
    ]);
    $node->save();
    return new ResourceResponse($node);
  }

}
