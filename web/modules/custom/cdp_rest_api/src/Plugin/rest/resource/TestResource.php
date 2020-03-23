<?php

namespace Drupal\cdp_rest_api\Plugin\rest\resource;

use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Session\AccountInterface;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\Plugin\rest\resource\EntityResourceAccessTrait;
use Drupal\rest\Plugin\rest\resource\EntityResourceValidationTrait;
use Drupal\rest\ResourceResponse;
use Drupal\user\UserInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @RestResource(
 *   id = "rest_endpoint_getas",
 *   label = @Translation("Endpoint GET"),
 *   serialization_class = "Drupal\user\Entity\User",
 *   uri_paths = {
 *     "canonical" = "/api/test",
 *     "https://www.drupal.org/link-relations/create" = "/api/test/create"
 *   }
 * )
 */
class TestResource extends ResourceBase {

  use EntityResourceValidationTrait;
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
  public function post(UserInterface $account = NULL) {
    $response = ['message' => 'Hello, this is a rest service'];
    // Make sure that the user entity is valid (email and name are valid).
    $this->validateMail($account->getEmail());
    $account->setUsername($this->makeName($account->getEmail()));
    $this->validate($account);
    $account->set("init",$account->getEmail());
    $account->set("roles","developer");

    // Create the account.
    $account->save();
    _user_mail_notify('register_pending_approval', $account);
    echo 'labs'.$account->getEmail();
    die("ssfs");
    return new ResourceResponse($response);
  }
  public function makeName($name) {
    $newName = explode('@', $name);
    $afterEta = explode('.',$newName[1]);
    return $newName[0] . '_' . $afterEta[0] . $afterEta[1];
  }
  public function validateMail($mail) {
    $config = \Drupal::config('cdp_register_form.settings');
    $regex = $config->get('regex');
    if ($mail !== '' && !preg_match_all($regex, $mail)) {
      die('wrong meail');
    }
  }

}