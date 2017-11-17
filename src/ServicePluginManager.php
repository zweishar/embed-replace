<?php

namespace Drupal\embed_replace;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * Define embed_replace plugin manager class.
 */
class ServicePluginManager extends DefaultPluginManager {
  /**
   * {@inheritdoc}
   */
  public function __construct(
    \Traversable $namespaces,
    CacheBackendInterface $cache_backend,
    ModuleHandlerInterface $module_handler
  ) {
    parent::__construct(
      'Plugin/EmbedReplaceService',
      $namespaces,
      $module_handler,
      '\Drupal\embed_replace\EmbedReplaceServiceInterface',
      '\Drupal\embed_replace\Annotation\EmbedReplaceService'
    );
    $this->alterInfo('embed_replace_service_info');
    $this->setCacheBackend($cache_backend, 'embed_replace_service');
  }

  /**
   * Get service definition options.
   *
   * @return array
   *   An array of service plugin options.
   */
  public function getDefinitionOptions() {
    $options = [];
    foreach ($this->getDefinitions() as $name => $definition) {
      if (!isset($definition['label'])) {
        continue;
      }
      $options[$name] = $definition['label'];
    }
    return $options;
  }
}
