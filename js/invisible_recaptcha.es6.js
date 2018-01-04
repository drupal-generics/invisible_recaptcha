/**
 * @file
 * Contains implementation for invisible recaptcha.
 */

/* global grecaptcha */

// The id of the current form.
let submittedFormId = '';

// Calls the form submit after recaptcha validation.
function recaptchaCallback() {
  document.getElementById(submittedFormId).submit();
}

(($, Drupal) => {
  /**
   * Handles the submission of the form with the invisible reCaptcha.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the behavior for the invisible reCaptcha.
   */
  Drupal.behaviors.invisibleRecaptcha = {
    attach: (context) => {
      /**
       * Triggers the reCaptcha to validate the form.
       *
       * @param {jQuery} $form
       *   The form object to be validated.
       */
      function validateInvisibleCaptcha($form) {
        submittedFormId = $form.attr('id');
        grecaptcha.execute();
      }
      $('form', context).each(() => {
        const $form = $(this);

        if ($form.find('.g-recaptcha[data-size="invisible"]').length) {
          $form.find('input[type="submit"]').click((e) => {
            e.preventDefault();
            validateInvisibleCaptcha($form);
          });
        }
      });
    },
  };
})(jQuery, Drupal);
