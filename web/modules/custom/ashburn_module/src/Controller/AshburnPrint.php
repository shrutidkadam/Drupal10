<?php
namespace Drupal\ashburn_module\Controller;

use Drupal\Core\Controller\ControllerBase;


class AshburnPrint extends ControllerBase {
  public function printContent($var1) {
    return [
      '#markup' => 'ashburnPrint'.$var1,
    ];
  }
}
