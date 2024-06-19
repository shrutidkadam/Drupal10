<?php
namespace Drupal\ashburn_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Cache\Cache;

class AshburnController extends ControllerBase {
  function renderContent(){

    $event_nodes = \Drupal::entityQuery('node')->condition('type', 'events')->accessCheck(FALSE)->execute();
    $title =[];
    foreach ($event_nodes as $event_nid) {

      $cid = 'markdown:' . $event_nid;
      if ($item = \Drupal::cache()->get($cid)) {
        return $item->data;
      }
      $ev =  \Drupal\node\Entity\Node::load($event_nid);

      // Look for the item in cache so we don't have to do the work if we don't need to.


      $title[] = $ev->get('title')->value;
      \Drupal::cache()->set($cid, $title, Cache::PERMANENT, $ev->getCacheTags());
    }
    return [
      '#theme' => 'ashburn_module_theme',
      '#color_value' => $title,

    ];
  }
  /**
   * {@inheritdoc}
   */
  public function getCacheTags() {
    return Cache::mergeTags(parent::getCacheTags(), ["node_list"]);
  }


}
