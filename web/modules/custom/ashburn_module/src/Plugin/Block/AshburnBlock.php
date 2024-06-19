<?php

namespace Drupal\ashburn_module\Plugin\Block;
use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

///**
// * @block
// */
#[block(
  id: 'ashburn_block_id',
  admin_label: new TranslatableMarkup('Ashburn Block'),
  category: new TranslatableMarkup('Ashburn Block')
)]
class AshburnBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $event_list = \Drupal::entityTypeManager('node')->getStorage('event');
    var_dump($event_list);
    return [
      '#markup' => $this->t('Hello, World!'),
    ];
  }

}
