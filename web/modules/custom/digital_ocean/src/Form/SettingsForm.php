<?php

namespace Drupal\digital_ocean\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure digital ocean settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'digital_ocean_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'digital_ocean.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('digital_ocean.settings');

    $form['access_key'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Access Key'),
      '#default_value' => $config->get('access_key'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable('digital_ocean.settings')
      ->set('access_key', $form_state->getValue('access_key'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}