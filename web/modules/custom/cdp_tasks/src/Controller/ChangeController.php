<?php

namespace Drupal\cdp_tasks\Controller;

use Drupal\cdp_tasks\TasksInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Entity\EntityFormBuilderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ProfilePageController.
 *
 * @package Drupal\cdp_profile\Controller
 */
class ChangeController extends ControllerBase {

  /**
   * Entity form builder interface.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilderInterface
   */
  protected $entityFormBuilder;

  /**
   * User storage interface.
   *
   * @var \Drupal\user\UserStorageInterface
   */
  protected $tasksStorage;

  /**
   * MainController constructor.
   *
   * @param  \Drupal\Core\Entity\EntityFormBuilderInterface  $entity_form_builder
   *   Entity form builder interface.
   * @param  \Drupal\Core\Entity\ContentEntityStorageInterface  $task_storage
   */
  public function __construct(EntityFormBuilderInterface $entity_form_builder, ContentEntityStorageInterface $task_storage) {
    $this->entityFormBuilder = $entity_form_builder;
    $this->tasksStorage       = $task_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.form_builder'),
      $container->get('entity_type.manager')->getStorage('tasks')
    );
  }

  /**
   * Profile frontpage.
   *
   * @param  \Drupal\cdp_tasks\TasksInterface  $tasks
   *
   * @return array
   *   Return Profile page.
   *
   */
  public function changedev(TasksInterface $tasks) {
//    $developer   = $this->tasksStorage->create();
    $detailsform = $this->entityFormBuilder->getForm($tasks, 'changedev');
    return [
      $detailsform,
    ];

  }
  /**
   * Profile frontpage.
   *
   * @param  \Drupal\cdp_tasks\TasksInterface  $tasks
   *
   * @return array
   *   Return Profile page.
   *
   */
  public function changetech(TasksInterface $tasks) {
//    $developer   = $this->tasksStorage->create();
    $detailsform = $this->entityFormBuilder->getForm($tasks,'changetech');
    return [
      $detailsform,
    ];

  }

}