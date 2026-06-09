<?php

namespace Drupal\utexas_smtp_helper\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure UTDK SMTP Helper settings.
 */
class SmtpConfigurationForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'utexas_smtp_helper_config';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // We allow static calls to services.
    // phpcs:ignore
    $opt_in_smtp = \Drupal::state()->get('utexas_smtp', 0);
    $form['intro']['#markup'] = $this->t('<p>Use this form to enable using the UTexas SMTP credentials. When enabled, SMTP credentials (host, port, protocol, username, and password) are sourced from the UTexas Pantheon organization secrets instead of being stored in site configuration. These credentials will override the settings in <a href="../system/smtp">SMTP Authentication Support</a>.</p>');

    $form['utexas_smtp'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use the UTexas SMTP service'),
      '#description' => $this->t('Uncheck this if the site uses its own SMTP connection.'),
      '#default_value' => $opt_in_smtp,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // We allow static calls to services.
    // phpcs:ignore
    if (!function_exists('pantheon_get_secret')) {
      \Drupal::messenger()->addError($this->t("Can't enable UTexas SMTP helper: Pantheon secrets are not available."));
      \Drupal::logger('utexas_smtp_helper')->error("Can't enable UTexas SMTP helper: Pantheon secrets function not available.");
      return;
    }
    \Drupal::state()->set('utexas_smtp', $form_state->getValue('utexas_smtp'));
    parent::submitForm($form, $form_state);
  }

}
