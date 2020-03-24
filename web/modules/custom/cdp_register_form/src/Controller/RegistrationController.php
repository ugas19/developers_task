<?php

namespace Drupal\cdp_register_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\user\UserStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class RegistrationController.
 *
 * @package Drupal\cdp_register_form\Controller
 */
class RegistrationController extends ControllerBase {

  /**
   * Entity form builder.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilderInterface
   */
  protected $entityFormBuilder;

  /**
   * User storage interface.
   *
   * @var \Drupal\user\UserStorageInterface
   */
  protected $userStorage;

  /**
   * RegistrationController constructor.
   *
   * @param \Drupal\Core\Entity\EntityFormBuilderInterface $entity_form_builder
   *   Entity form builder.
   * @param \Drupal\user\UserStorageInterface $user_storage
   *   User storage interface.
   */
  public function __construct(EntityFormBuilderInterface $entity_form_builder, UserStorageInterface $user_storage) {
    $this->entityFormBuilder = $entity_form_builder;
    $this->userStorage = $user_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.form_builder'),
      $container->get('entity_type.manager')->getStorage('user')
    );
  }

  /**
   * Create and return custom user registration form.
   *
   * @return array
   *   mixed
   */
  public function registerTechleadForm() {
    $developer = $this->userStorage->create();
    $content['registration_techlead_form'] = $this->entityFormBuilder->getForm($developer, 'registration_techlead', ['role' => 'techlead']);

    return $content;
  }

  /**
   * Create and return custom user registration form.
   *
   * @return array
   *   mixed
   */
  public function registerDeveloperForm() {
    $developer = $this->userStorage->create();
    $content['registration_developers_form'] = $this->entityFormBuilder->getForm($developer, 'registration_developers', ['role' => 'developer']);
    return $content;
  }

}
