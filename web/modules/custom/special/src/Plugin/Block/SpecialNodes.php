<?php

namespace Drupal\special\Plugin\Block;

use Drupal\Core\Block\BlockBase;

class SpecialNodes extends BlockBase {
  public function build() {
    return [
      '#markup' => t('There are no special content available.'),
    ];
  }
}
