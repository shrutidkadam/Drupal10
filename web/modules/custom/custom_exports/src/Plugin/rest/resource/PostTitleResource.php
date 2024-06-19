<?php
namespace Drupal\custom_exports\Plugin\rest\resource;

use Drupal\rest\Annotation\RestResource;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * @RestResource(
 *  id = "post_title_id",
 *  label = "Post title",
 *  uri_paths = {
 *   "canonical" = "/post-title",
 *   "create" = "/post-title"
 *  }
 * )
 */

class PostTitleResource extends ResourceBase {


  public function post($data) {
    $response = new ResourceResponse('200');

    $node = Node::create([
      'type'        => 'article',
      'title'       => 'Druplicon test',
      'field_image' => [
        'target_id' => '',
        'alt' => 'Hello world',
        'title' => 'Goodbye world'
      ],
    ]);
    $node->save();
    return $response;
  }


}
