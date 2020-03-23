<?php

namespace Drupal\cdp_rest_api\Plugin\rest\resource;

use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Session\AccountInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\Plugin\rest\resource\EntityResourceAccessTrait;
use Drupal\rest\Plugin\rest\resource\EntityResourceValidationTrait;
use Drupal\rest\ResourceResponse;
use Drupal\user\Controller\UserAuthenticationController;
use Drupal\user\UserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @RestResource(
 *   id = "login_rest_api",
 *   label = @Translation("Endpoint login"),
 *   serialization_class = "Drupal\user\Entity\User",
 *   uri_paths = {
 *     "canonical" = "/api/loginas",
 *     "https://www.drupal.org/link-relations/create" = "/api/loginas/create"
 *   }
 * )
 */
class LoginResource extends ResourceBase {

  use EntityResourceValidationTrait;

  /**
   * K.
   *
   * @return \Drupal\rest\ResourceResponse
   *   K.
   */
  public function get() {
    die(\Drupal::currentUser()->id());
    $response = ['message' => 'Hello, this is a rest service'];
//    setcookie()
    return new ResourceResponse($response);
  }
  public function post(UserInterface $account = NULL) {
    $response = new RedirectResponse("/user/login");
    $response->send();
    die($account->getPassword());
    $response = ['message' => 'Hello, this is a rest service'];
    //    setcookie()
    return new ResourceResponse($response);
  }



}