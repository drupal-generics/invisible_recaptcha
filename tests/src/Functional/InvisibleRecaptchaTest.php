<?php

namespace Drupal\Tests\invisible_recaptcha\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Class InvisibleRecaptchaTest.
 *
 * @group invisible_recaptcha
 */
class InvisibleRecaptchaTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'system',
    'user',
    'config',
    'invisible_recaptcha',
    'invisible_recaptcha_test',
  ];

  /**
   * User that can access popups.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user;

  /**
   * The Drupal configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    // Load the config system.
    $this->configFactory = $this->container->get('config.factory');

    // Create user that can access the popup test page.
    $this->user = $this->drupalCreateUser([
      'administer site configuration',
      'configure invisible recaptcha settings',
    ]);
    $this->drupalLogin($this->user);
  }

  /**
   * Tests the configuration form.
   */
  public function testConfigurationForm() {
    $this->drupalGet('admin/config/invisible-recaptcha/configurations');
    $session_assert = $this->assertSession();
    $page = $this->getSession()->getPage();
    $session_assert->statusCodeEquals(200);

    // Checks if the form was rendered.
    $submit_btn = $page->find('css', 'input#edit-submit');
    $this->assertNotEmpty($submit_btn, t('The submit button is not rendered correctly.'));
    $this->assertEquals($submit_btn->getValue(), t('Save configurations'));
  }

  /**
   * Tests the check form.
   */
  public function testCheckForm() {
    $this->drupalGet('admin/config/invisible-recaptcha/checks');
    $session_assert = $this->assertSession();
    $session_assert->statusCodeEquals(200);
    $page = $this->getSession()->getPage();

    // Checks if the form was rendered.
    $session_assert->pageTextContains(t('Add more'));
    $session_assert->pageTextContains(t('Save'));

    // Add the test form id to the config set.
    $input = $page->find('css', 'input#form-id-0');
    $this->assertNotEmpty($input, t('The text input is not rendered.'));
    $input->setValue('invisible_recaptcha_test_form');
    // Click 'Add more' and add a new form id.
    $this->click('#edit-form-ids-add-more');
    $input = $page->find('css', 'input#form-id-1');
    $this->assertNotEmpty($input, t('The second text input is not rendered.'));
    $input->setValue('invisible_recaptcha_test_form_2');

    // Save the form and check if the values were saved correctly.
    $this->drupalPostForm(NULL, [], t('Save'));
    $config_value = $this->configFactory->get('invisible_recaptcha.recaptcha_points')->getRawData();
    $this->assertEquals([
      'forms_ids' => [
        'invisible_recaptcha_test_form',
        'invisible_recaptcha_test_form_2',
      ],
    ], $config_value);
  }

  /**
   * Tests the invisible recaptcha on forms.
   */
  public function testInvisibleRecaptcha() {
    // Set up the invisible recaptcha configurations.
    $this->configFactory->getEditable('invisible_recaptcha.recaptcha_points')->set('forms_ids', ['invisible_recaptcha_test_form'])->save();

    $this->drupalGet('tests/invisible_recaptcha_test_form');
    $session_assert = $this->assertSession();
    $session_assert->statusCodeEquals(200);
    $page = $this->getSession()->getPage();

    // Checks if the form was rendered.
    $submit_btn = $page->find('css', 'input#invisible-recaptcha-submit-btn');
    $this->assertNotEmpty($submit_btn, t('The submit button is not rendered correctly.'));
    $this->assertEquals($submit_btn->getValue(), t('Submit'));
    // Checks if the hidden recaptcha elements are rendered in the form.
    $recaptcha_container = $page->find('css', '#edit-recaptcha-container');
    $this->assertNotEmpty($recaptcha_container, t('The recaptcha container is missing'));
    $this->drupalPostForm(NULL, [], t('Submit'));
  }

}
