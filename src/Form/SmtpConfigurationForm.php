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
    $form['smtp_settings'] = [
      '#title' => 'UTexas SMTP',
      '#type' => 'fieldset',
    ];
    $form['smtp_settings']['utexas_smtp'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Use the UTexas SMTP service'),
      '#description' => $this->t('When enabled, SMTP credentials (host, port, protocol, username, and password) are sourced from the UTexas Pantheon organization secrets instead of being stored in site configuration. Uncheck this if the site uses its own SMTP connection.'),
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
    \Drupal::state()->set('utexas_smtp', $form_state->getValue('utexas_smtp'));
    parent::submitForm($form, $form_state);
  }

}
