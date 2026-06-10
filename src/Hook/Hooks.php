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
   * Implements hook_form_FORM_ID_alter().
   */
  #[Hook('form_smtp_admin_settings_alter')]
  public function formSmtpAdminSettingsAlter(array &$form, FormStateInterface $form_state, string $form_id): void {
    \Drupal::messenger()->addMessage($this->t("This module's configuration is being set by the UTexas SMTP Helper module."));
    $fields = ['smtp_on', 'smtp_autotls', 'smtp_host', 'smtp_port', 'smtp_protocol'];
    foreach ($fields as $field) {
      if (isset($form[$field])) {
        $form[$field]['#disabled'] = TRUE;
      }
    }
  }

}
