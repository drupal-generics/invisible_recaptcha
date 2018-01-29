<?php

namespace Drupal\invisible_recaptcha_test\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class InvisibleRecaptchaTestForm.
 *
 * @package Drupal\invisible_recaptcha_test\Form
 */
class InvisibleRecaptchaTestForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'invisible_recaptcha_test_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['actions']['submit'] = [
      '#id' => 'invisible-recaptcha-submit-btn',
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement submitForm() method.
  }

}
