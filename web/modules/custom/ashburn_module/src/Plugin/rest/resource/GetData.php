<?php

namespace Drupal\ashburn_module\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;


/**
 * @RestResource(
 *   id = "get_data_all",
 *   label = "Get node data",
 *   uri_paths = {
 *      "canonical" = "/get-data/v1",
 *    }
 * )
 */
class GetData extends ResourceBase {

  function get() {
    return 'Data';
  }



}
