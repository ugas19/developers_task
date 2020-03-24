<?php

namespace Drupal\cdp_register_form\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\user\RegisterForm;

/**
 * Class MainRegisterForm.
 *
 * @package Drupal\cdp_register_form
 */
class MainRegisterForm extends RegisterForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);
    $form['account']['mail']['#description'] = '';
    $form['account']['name']['#access'] = FALSE;
    $form['account']['name']['#value'] = 'name' . user_password();
    $form['#validate'][] = [$this, 'validateMail'];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $form_state->setValue('name', $this->makeName($form_state->getValue('mail')));

    parent::submitForm($form, $form_state);
  }

  /**
   * Validates email with given regex.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function validateMail(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::config('cdp_register_form.settings');
    $regex = $config->get('regex');
    $mail = $form_state->getValue('mail');
    if ($mail !== '' && !preg_match_all($regex, $mail)) {
      $form_state->setError($form['account']['mail'], $this->t('Wrong email...'));
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function actions(array $form, FormStateInterface $form_state) {
    $element = parent::actions($form, $form_state);
    $element['submit']['#value'] = $this->t('Register account');
    return $element;
  }

  /**
   * Create User name from email.
   *
   * @param string $email
   *   Users email.
   *
   * @return string
   *   mixed
   */
  public function makeName($email) {
    $newName = explode('@', $email);
    $afterEta = explode('.', $newName[1]);
    return $newName[0] . '_' . $afterEta[0] . $afterEta[1];
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $storage = $form_state->getStorage();
    if ($storage['role']) {
      $role_id = $storage['role'];
      $this->entity->set('roles', $role_id);
    }
    parent::save($form, $form_state);
  }

}

