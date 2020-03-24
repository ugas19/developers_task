<?php

namespace Drupal\cdp_tasks\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a user password reset form.
 */
class TaskChangeTimeForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'change_field_form';
  }

  /**
   * {@inheritdoc}
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form['account'] = [
      '#type'   => 'container',
      '#weight' => -10,
    ];
    $form['account']['new'] = [
      '#type' => 'string',
      '#title' => $this->t('Current password'),
      '#size' => 25,
      '#access' => TRUE,
      '#weight' => -5,
      // Do not let web browsers remember this password, since we are
      // trying to confirm that the person submitting the form actually
      // knows the current one.
      '#attributes' => ['autocomplete' => 'off'],
      '#required' => TRUE,
    ];

    return parent::form($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {

    $account = $this->entity;
    $account->save();
    if (in_array('developer', \Drupal::currentUser()->getRoles())) {
      $form_state->setRedirect('view.developer_tasks.page_1');
    }
    if (in_array('techlead', \Drupal::currentUser()->getRoles())) {
      $form_state->setRedirect('view.techlead_tasks.page_1');
    }

  }

}
