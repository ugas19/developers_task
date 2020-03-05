<?php

namespace Drupal\cdp_tasks\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the developer tasks entity edit forms.
 */
class TasksForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $entity = $this->getEntity();
    $result = $entity->save();
    $link = $entity->toLink($this->t('View'))->toRenderable();

    $message_arguments = ['%label' => $this->entity->label()];
    $logger_arguments = $message_arguments + ['link' => render($link)];

    if ($result == SAVED_NEW) {
      $this->messenger()->addStatus($this->t('New developer tasks %label has been created.', $message_arguments));
      $this->logger('cdp_tasks')->notice('Created new developer tasks %label', $logger_arguments);
    }
    else {
      $this->messenger()->addStatus($this->t('The developer tasks %label has been updated.', $message_arguments));
      $this->logger('cdp_tasks')->notice('Updated new developer tasks %label.', $logger_arguments);
    }

    $form_state->setRedirect('entity.tasks.canonical', ['tasks' => $entity->id()]);
  }

}
