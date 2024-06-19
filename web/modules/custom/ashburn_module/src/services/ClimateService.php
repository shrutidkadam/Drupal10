<?php

namespace Drupal\ashburn_module\services;

use Drupal\Component\Serialization\Json;

class ClimateService {

  protected array $climate;

  public function __construct() {
    $this->climate = [];
  }

  public function getClimate($city = '') {
    if($city){
      $client = \Drupal::httpClient();
      $result = $client->request('GET', 'https://dog.ceo/api/breeds/list/all');

      return $climate = Json::decode($result->getBody());

    }
  }
}
