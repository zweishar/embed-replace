<?php

namespace Drupal\embed_replace\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure settings for embed_replace module.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'embed_replace.settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'embed_replace.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('embed_replace.settings');

    // @todo this should be injected by service container
    $type = \Drupal::service('plugin.manager.embed_replace.service');
    $plugin_definitions = $type->getDefinitions();
    $options = [];

    foreach ($plugin_definitions as $definition) {
      $id = $definition['id'];
      $title = $definition['title']->__toString();
      $options[$id] = $title;
    }

    $form['services'] = [
      '#type' => 'checkboxes',
      '#title' => 'Enabled Services',
      '#options' => $options,
      '#default_value' => $config->get('services'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('embed_replace.settings');
    $config->set('services',  $form_state->getValue('services'));
    $config->save();

    parent::submitForm($form, $form_state);
  }
}
