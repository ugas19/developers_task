<?php

namespace Drupal\cdp_tasks;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\user\EntityOwnerInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining a developer tasks entity type.
 */
interface TasksInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

  /**
   * Gets the developer tasks title.
   *
   * @return string
   *   Title of the developer tasks.
   */
  public function getTitle();

  /**
   * Sets the developer tasks title.
   *
   * @param string $title
   *   The developer tasks title.
   *
   * @return \Drupal\cdp_tasks\TasksInterface
   *   The called developer tasks entity.
   */
  public function setTitle($title);

  /**
   * Gets the developer tasks creation timestamp.
   *
   * @return int
   *   Creation timestamp of the developer tasks.
   */
  public function getCreatedTime();

  /**
   * Sets the developer tasks creation timestamp.
   *
   * @param int $timestamp
   *   The developer tasks creation timestamp.
   *
   * @return \Drupal\cdp_tasks\TasksInterface
   *   The called developer tasks entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the developer tasks status.
   *
   * @return bool
   *   TRUE if the developer tasks is enabled, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Sets the developer tasks status.
   *
   * @param bool $status
   *   TRUE to enable this developer tasks, FALSE to disable.
   *
   * @return \Drupal\cdp_tasks\TasksInterface
   *   The called developer tasks entity.
   */
  public function setStatus($status);

}
