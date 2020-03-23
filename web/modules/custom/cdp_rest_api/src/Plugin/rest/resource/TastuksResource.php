<?php

namespace Drupal\cdp_rest_api\Plugin\rest\resource;

use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;

/**
 * @RestResource(
 *   id = "rest_endpoint_getuks",
 *   label = @Translation("Endpoint GET"),
 *   uri_paths = {
 *     "canonical" = "/api/tests"
 *   }
 * )
 */
class TastuksResource extends ResourceBase {

  /**
   * K.
   *
   * @return \Drupal\rest\ResourceResponse
   *   K.
   */
  public function get() {
    $response = ['message' => 'Hello, this is a rest service'];
    return new ResourceResponse($response);
  }
}