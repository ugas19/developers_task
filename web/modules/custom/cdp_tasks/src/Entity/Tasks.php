<?php

namespace Drupal\cdp_tasks\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\cdp_tasks\TasksInterface;
use Drupal\user\UserInterface;
use Drupal\user\Entity\User;

/**
 * Defines the developer tasks entity class.
 *
 * @ContentEntityType(
 *   id = "tasks",
 *   label = @Translation("Developer tasks"),
 *   label_collection = @Translation("Developer taskses"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\cdp_tasks\TasksListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "add" = "Drupal\cdp_tasks\Form\TasksForm",
 *       "edit" = "Drupal\cdp_tasks\Form\TasksForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "tasks",
 *   data_table = "tasks_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer developer tasks",
 *   entity_keys = {
 *     "id" = "id",
 *     "langcode" = "langcode",
 *     "label" = "title",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/content/tasks/add",
 *     "canonical" = "/tasks/{tasks}",
 *     "edit-form" = "/admin/content/tasks/{tasks}/edit",
 *     "delete-form" = "/admin/content/tasks/{tasks}/delete",
 *     "collection" = "/admin/content/tasks"
 *   },
 *   field_ui_base_route = "entity.tasks.settings"
 * )
 */
class Tasks extends ContentEntityBase implements TasksInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   *
   * When a new developer tasks entity is created, set the uid entity reference to
   * the current user as the creator of the entity.
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += ['uid' => \Drupal::currentUser()->id()];
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->get('title')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTitle($title) {
    $this->set('title', $title);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isEnabled() {
    return (bool) $this->get('status')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setStatus($status) {
    $this->set('status', $status);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('uid')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('uid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('uid', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('uid', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->get('task_description')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setDescription($description) {
    $this->set('task_description', $description);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getTaskStatus() {
    return $this->get('task_status')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTaskStatus($task_status) {
    $this->set('task_status', $task_status);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getUrlTitle() {
    if (!empty($this->get('url')->getValue())) {
      $task_url = $this->get('url')->getValue();
      $task_url = $task_url[0]['title'];
      return $task_url;
    }
    return '';
  }

  /**
   * {@inheritdoc}
   */
  public function setUrlTitle($task_url_title) {
    $task_url = $this->get('url')->getValue();
    $task_url->set($task_url[0]['title'], $task_url);
    return $task_url;
  }

  /**
   * {@inheritdoc}
   */
  public function getUrlUri() {
    if (!empty($this->get('url')->getValue())) {
      $task_url = $this->get('url')->getValue();
      $task_url = $task_url[0]['uri'];
      return $task_url;
    }
    return '';
  }

  /**
   * {@inheritdoc}
   */
  public function setUrlUri($task_url_uri) {
    $task_url = $this->get('url')->getValue();
    $task_url->set($task_url[0]['uri'], $task_url_uri);
    return $task_url;
  }

  /**
   * {@inheritdoc}
   */
  public function getDeveloperName() {
    $developer = $this->get('developer')->getValue();
    $developer = $developer[0]['target_id'];
    $developer = User::load($developer)->getUsername();
    return $developer;
  }

  /**
   * {@inheritdoc}
   */
  public function setDeveloperName($task_developer) {
    $developer = $this->get('developer')->getValue();
    $developer = $developer[0]['target_id'];
    $developer = User::load($developer)->setUsername($task_developer);
    return $developer;
  }

  /**
   * {@inheritdoc}
   */
  public function getTechleadName() {
    $lead = $this->get('techlead')->getValue();
    $lead = $lead[0]['target_id'];
    $lead = User::load($lead)->getUsername();
    return $lead;
  }

  /**
   * {@inheritdoc}
   */
  public function setTechleadName($task_techlead) {
    $lead = $this->get('techlead')->getValue();
    $lead = $lead[0]['target_id'];
    $lead = User::load($lead)->setUsername($task_techlead);
    return $lead;
  }

  /**
   * {@inheritdoc}
   */
  public function getDeadline() {
    return $this->get('deadline')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setDeadline($task_deadline) {
    $this->set('deadline', $task_deadline);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPlannedTime() {
    return $this->get('planned_time')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setPlannedTime($task_time) {
    $this->set('planned_time', $task_time);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getRealTime() {
    return $this->get('actual_time')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setRealTime($task_time) {
    $this->set('actual_time', $task_time);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['title'] = BaseFieldDefinition::create('string')
      ->setTranslatable(TRUE)
      ->setLabel(t('Title'))
      ->setDescription(t('The title of the developer tasks entity.'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Status'))
      ->setDescription(t('A boolean indicating whether the developer tasks is enabled.'))
      ->setDefaultValue(TRUE)
      ->setSetting('on_label', 'Enabled')
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'settings' => [
          'display_label' => FALSE,
        ],
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'boolean',
        'label' => 'above',
        'weight' => 0,
        'settings' => [
          'format' => 'enabled-disabled',
        ],
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['description'] = BaseFieldDefinition::create('text_long')
      ->setTranslatable(TRUE)
      ->setLabel(t('Description'))
      ->setDescription(t('A description of the developer tasks.'))
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'type' => 'text_default',
        'label' => 'above',
        'weight' => 10,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setTranslatable(TRUE)
      ->setLabel(t('Author'))
      ->setDescription(t('The user ID of the developer tasks author.'))
      ->setSetting('target_type', 'user')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => 15,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => 15,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Authored on'))
      ->setTranslatable(TRUE)
      ->setDescription(t('The time that the developer tasks was created.'))
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'datetime_timestamp',
        'weight' => 20,
      ])
      ->setDisplayConfigurable('view', TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setTranslatable(TRUE)
      ->setDescription(t('The time that the developer tasks was last edited.'));


    $fields['task_status'] = BaseFieldDefinition::create('list_string')
      ->setLabel(t('Task_status'))
      ->setDescription(t('Status of task'))
      ->setSettings([
        'allowed_values' => [
          'To do' => 'To do',
          'In progress' => 'In progress',
          'Done' => 'Done',
        ],
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'textarea',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['url'] = BaseFieldDefinition::create('link')
      ->setLabel(t('Task_url'))
      ->setDescription(t('Url of task'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'url',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(FALSE);


    $fields['developer'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Developer_name'))
      ->setDescription(t('Name of developer'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default:user')
      ->setSetting('handler_settings', [
        'include_anonymous' => true,
        'filter' => [
          'type' => 'role',
          'role' => [
            'developer' => 'developer',
            'techlead' => '0',
          ],
        ],
        'target_bundles' => NULL,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['techlead'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Techlead_name'))
      ->setDescription(t('Techlead name'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default:user')
      ->setSetting('handler_settings', [
        'include_anonymous' => true,
        'filter' => [
          'type' => 'role',
          'role' => [
            'developer' => '0',
            'techlead' => 'techlead',
          ],
        ],
        'target_bundles' => NULL,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'author',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => 60,
          'placeholder' => '',
        ],
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['deadline'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Task_deadline'))
      ->setDescription(t('Deadline of task'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'integer',
        'weight' => -1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'integer',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['planned_time'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Planned_time'))
      ->setDescription(t('Planned time to finish task'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'integer',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'integer',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(FALSE);

    $fields['actual_time'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Actual_time'))
      ->setDescription(t('Actual time task took.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'integer',
        'weight' => 1,
      ])
      ->setDisplayOptions('form', [
        'type' => 'integer',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(FALSE);

    return $fields;
  }

}
