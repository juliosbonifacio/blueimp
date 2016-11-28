<?php

/**
 * @file
 * Contains \Drupal\blueimp\Form\BlueimpSettings.
 */

namespace Drupal\blueimp\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;

class BlueimpSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'blueimp_settings';
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('blueimp.settings');

    foreach (Element::children($form) as $variable) {
      $config->set($variable, $form_state->getValue($form[$variable]['#parents']));
    }
    $config->save();

    if (method_exists($this, '_submitForm')) {
      $this->_submitForm($form, $form_state);
    }

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['blueimp.settings'];
  }

  public function buildForm(array $form, \Drupal\Core\Form\FormStateInterface $form_state) {
    $settings = \Drupal::config('blueimp.settings')->get('blueimp_settings');

    $options['trigger'] = [
      '#type' => 'textarea',
      '#title' => t('Valid jQuery Classes/IDs to trigger Blueimp Gallery (One per line)'),
      '#default_value' => $settings['trigger'],
      '#description' => t('Specify the class/ID of a container of links to load destination images in a Blueimp Gallery, one per line. For example by providing ".field-name-field-image" will open any image link inside class="field-name-field-image" container in a gallery'),
    ];

    // Navigation
    $options['navigation'] = [
      '#type' => 'fieldset',
      '#title' => t('Navigation'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
    ];
    $options['navigation']['startControls'] = [
      '#type' => 'checkbox',
      '#title' => t('Start with visible controls'),
      '#default_value' => $settings['navigation']['startControls'],
      '#description' => t('When enable, controls will be visible on load.'),
    ];
    $options['navigation']['hidePageScrollbars'] = [
      '#type' => 'checkbox',
      '#title' => t('Hide the page scrollbars'),
      '#default_value' => $settings['navigation']['hidePageScrollbars'],
      '#description' => t('When enable, click outside image will close galley.'),
    ];
    $options['navigation']['carousel'] = [
      '#type' => 'checkbox',
      '#title' => t('Carousel'),
      '#default_value' => $settings['navigation']['carousel'],
      '#description' => t('Shortcut to carousel options.'),
    ];
    $options['navigation']['startSlideshow'] = [
      '#type' => 'checkbox',
      '#title' => t('Slideshow'),
      '#default_value' => $settings['navigation']['startSlideshow'],
      '#description' => t('Starts automatically a Slideshow.'),
    ];
    $options['navigation']['continuous'] = [
      '#type' => 'checkbox',
      '#title' => t('Cycle continuously'),
      '#description' => t('If this option in checked, the corousel will continue on first carousel after reaching last and viceversa.'),
      '#default_value' => $settings['navigation']['continuous'],
    ];
    $options['navigation']['slideshowInterval'] = [
      '#type' => 'textfield',
      '#title' => t('Slideshow interval'),
      '#maxlength' => 6,
      '#size' => 6,
      '#default_value' => $settings['navigation']['slideshowInterval'],
      '#description' => t('Enter a time in milliseconds. The pause time determines how long each carousel is displayed before transitioning to the next carousel.'),
      '#field_suffix' => t('ms'),
    ];
    $options['navigation']['transitionSpeed'] = [
      '#type' => 'textfield',
      '#title' => t('Transition Speed'),
      '#maxlength' => 6,
      '#size' => 6,
      '#default_value' => $settings['navigation']['transitionSpeed'],
      '#description' => t('Enter a time in milliseconds. The transition speed determines how long each carousel takes to transtion.'),
      '#field_suffix' => t('ms'),
    ];
    // Per-path visibility.
    $options['visibility'] = [
      '#type' => 'fieldset',
      '#title' => t('Pages'),
      '#collapsible' => TRUE,
      '#collapsed' => FALSE,
    ];
    $options['visibility']['visibility'] = [
      '#type' => 'radios',
      '#title' => t('Activate on specific pages'),
      '#options' => [
        0 => t('All pages except those listed'),
        1 => t('Only the listed pages'),
      ],
      '#default_value' => $settings['visibility']['visibility'],
    ];
    $options['visibility']['pages'] = [
      '#type' => 'textarea',
      '#title' => 'List of pages to activate',
      '#default_value' => $settings['visibility']['pages'],
      '#description' => t("Specify pages by using their paths. Enter one path per line. The '*' character is a wildcard. Example paths are %blog for the blog page and %blog-wildcard for every personal blog. %front is the front page.", [
        '%blog' => 'blog',
        '%blog-wildcard' => 'blog/*',
        '%front' => '<front>',
      ]),
    ];

    $options['#tree'] = TRUE;
    $form['blueimp_settings'] = $options;

    // Disable automatic defaults, which don't work with nested values.
    //return parent::buildForm($form, FALSE, $form_state);
    $form['submit'] = [
        '#type' => 'submit',
        '#value' => t('Save'),
        '#attributes' => array('class' => array('form-actions', 'button', 'button--primary')),
    ];
    return $form;

  }

}
