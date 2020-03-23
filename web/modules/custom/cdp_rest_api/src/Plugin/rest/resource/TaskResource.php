<?php

namespace Drupal\cdp_rest_api\Plugin\rest\resource;

use Drupal\cdp_tasks\Entity\Tasks;
use Drupal\cdp_tasks\TasksInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\Core\Session\AccountInterface;
use Drupal\rest\ModifiedResourceResponse;
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
 *   id = "task_rest_api",
 *   label = @Translation("Endpoint tasks"),
 *   serialization_class = "Drupal\cdp_tasks\Entity\Tasks",
 *   uri_paths = {
 *     "canonical" = "/api/task/{tasks}",
 *     "https://www.drupal.org/link-relations/create" = "/api/task/create"
 *   }
 * )
 */
class TaskResource extends ResourceBase {

  use EntityResourceValidationTrait;

  /**
   * K.
   *
   * @return \Drupal\rest\ResourceResponse
   *
   *   K.
   */
  public function get($task_id) {
    if($task_id) {
      // Load node
      $task = Tasks::load($task_id);
      if(is_object($task)){
        $response[$task->id()] = $task->id();
      }
    }


//    die($task_id);

//    $response = ['message' => 'Hello, this is a rest service'];
    //    setcookie()
    return new ResourceResponse($response);
  }
  public function post(UserInterface $account = NULL) {
    $account->save();
    $response = ['message' => 'Hello, this is a rest service'];
    //    setcookie()
    return new ResourceResponse($response);
  }

  /**
   * Responds to entity DELETE requests.
   *
   * @param  \Drupal\Core\Entity\EntityInterface  $entity
   *   The entity object.
   *
   * @return \Drupal\cdp_rest_api\Plugin\rest\resource\ModifiedResourceResponse
   *   The HTTP response object.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  public function delete($task_id) {
    if($task_id) {
      // Load node
      $task = Tasks::load($task_id);
      if(is_object($task)){
        $response[$task->id()] = $task->id();
        $task->delete();
        return new ModifiedResourceResponse(NULL, 204);
      }else{
        return new ModifiedResourceResponse('Something went wrong', 204);
      }
    }
//    try {
//      $entity->delete();
//      $this->logger->notice('Deleted entity %type with ID %id.', ['%type' => $entity->getEntityTypeId(), '%id' => $entity->id()]);
//
//      // DELETE responses have an empty body.
//      return new ModifiedResourceResponse(NULL, 204);
//    }
//    catch (EntityStorageException $e) {
//      throw new HttpException(500, 'Internal Server Error', $e);
//    }
  }

  /**
   * @param $task_id
   * @param  \Drupal\cdp_tasks\TasksInterface|NULL  $tasks
   */
  public function patch(TasksInterface $task_id, TasksInterface $tasks = NULL) {
//    $tasks->set("id",$task_id);
    var_dump($task_id->id());
    if($task_id) {
      // Load node
      $task = Tasks::load($task_id);
      if (is_object($task)) {
//        $task->
        die('works');
        $task->save();
      }
    }

  }




}