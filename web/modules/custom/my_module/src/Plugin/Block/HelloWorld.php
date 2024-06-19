<?php

namespace Drupal\my_module\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

#[Block(
  id: 'my_world_block',
  admin_label: new TranslatableMarkup('My World Block'),
  category: new TranslatableMarkup('My Category'),

)]
class HelloWorld extends BlockBase {

  function build() {
//    $event_list = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'events']);



//    $nids = \Drupal::entityQuery('node')->condition('type','events')->accessCheck(FALSE)->execute();
    $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);

//    foreach ($nodes as $key => $event) {
//      $title[$key]= $event->get('title');
//    }

//    print_r($nodes);

//    exit;
    return[
    '#markup' => 'Hello World!',
    ];
  }
}
