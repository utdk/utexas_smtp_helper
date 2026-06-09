<?php

namespace Drupal\utexas_smtp_helper\Hook;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Hook\Attribute\Hook;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Hook implementations.
 */
class Hooks {

  use StringTranslationTrait;

  /**
   * Implements hook_page_top().
   */
  #[Hook('page_top')]
  public function pageTop(array &$page_top): void {
    if (isset($_ENV['PANTHEON_ENVIRONMENT']) && !function_exists('pantheon_get_secret')) {
      \Drupal::logger('utexas_smtp_helper')->error("Can't override SMTP credentials: Pantheon secrets function not available.");
    }
  }

  /**
   * Implements hook_form_FORM_ID_alter().
   */
  #[Hook('form_smtp_admin_settings_alter')]
  public function formSmtpAdminSettingsAlter(array &$form, FormStateInterface $form_state, string $form_id): void {
    if (function_exists('pantheon_get_secret')) {
      \Drupal::messenger()->addMessage($this->t("This module's configuration is being set by the UTexas SMTP Helper module."));
    }
  }

}
