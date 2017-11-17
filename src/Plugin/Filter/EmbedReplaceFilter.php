<?php

/**
 * @file
 * Contains \Drupal\embed_replace\Plugin\Filter\EmbedReplaceFilter.
 */

namespace Drupal\embed_replace\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\embed\DomHelperTrait;
use Drupal\Component\Utility\Html;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\embed_replace\ServicePluginManager;
use Drupal\embed_replace\Plugin\EmbedReplaceService;
use Drupal\url_embed\UrlEmbedHelperTrait;
use Drupal\url_embed\UrlEmbedInterface;
use Drupal\Core\Controller\ControllerBase;



/**
 * @Filter(
 *   id = "embed_replace",
 *   title = @Translation("Embed Replace"),
 *   description = @Translation("No more inline js. Tokens to the rescue."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class EmbedReplaceFilter extends FilterBase {
//  use DomHelperTrait;

  // Provide an admin form for selecting which plugins to enable
  // Process function reads from the config object created / managed by the admin form
  // This config object refers to services which provide replacement logic and point to proper libraries
  // Making these services will allow developers to override them if they don't like them
  // How can I easily allow other modules to add to my config form?

//  public function __construct($entity_query, $entity_manager) {
//    $this->entity_query = $entity_query;
//    $this->entity_manager = $entity_manager;
//  }
//
//  public static function create(ContainerInterface $container) {
//    return new static(
//      $container->get('entity.query'),
//      $container->get('entity.manager')
//    );
//  }




  /**
   * Constructs a FilterEmbedReplace object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, $plugin_manager, $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->services = $plugin_manager->get('embed_replace.service');
    $this->config = $config_factory->get('services');
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager'),
      $container->get('config.factory')
    );
  }

  /**
   * @inheritdoc
   */
  public function process($text, $langcode) {
    $services = $this->getEnabledServices();

    $libraries = [];
    foreach ($services as $service) {
      $this->doReplace($service, $text, $libraries);
    }

    $result = new FilterProcessResult($text);
    $result->setAttachments(
      array(
      'library' => $libraries,
    ));

    return $result;
  }

  /**
   * Get enabled services.
   *
   * @return array
   */
  protected function getEnabledServices() {
    $instances = [];
    foreach($this->services as $id => $title) {
      $instances[] = $this->plugin_manager->createInstance($id);
    }

    return $instances;
  }

  /**
   *
   *
   * @param $service
   * @param $text
   */
  protected function doReplace($service, $text, $libraries) {
    if (strpos($text, $service->getToken()) !== FALSE) {
      // Only continue if token was found.
      // @todo we need a way to pass arbitrary strings from the token into the js file. Consider emulating entity embed.
      $text = str_replace($service->getToken(), $service->getReplacement(), $text);
      $libraries = array_merge($libraries, $service->getLibraries());
    }
  }
}
