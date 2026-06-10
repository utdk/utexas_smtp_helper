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
    if (isset($form['onoff']['smtp_on'])) {
      $form['onoff']['smtp_on']['#disabled'] = TRUE;
    }
    $fields = [
      'smtp_autotls' => 1,
      'smtp_host' => function_exists('pantheon_get_secret') ? pantheon_get_secret('utexas_smtp_host') ?? '' : '',
      'smtp_port' => function_exists('pantheon_get_secret') ? pantheon_get_secret('utexas_smtp_port') ?? '' : '',
      'smtp_protocol' => function_exists('pantheon_get_secret') ? pantheon_get_secret('utexas_smtp_protocol') ?? '' : '',
    ];
    foreach ($fields as $key => $value) {
      if (isset($form['server'][$key])) {
        $form['server'][$key]['#default_value'] = $value;
      }
    }
  }

}
