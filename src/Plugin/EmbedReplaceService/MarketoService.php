<?php

namespace Drupal\embed_replace\Plugin\EmbedReplaceService;

use Drupal\embed_replace\EmbedReplaceServiceInterface;

/**
 * @EmbedReplaceService(
 *   id = "marketo",
 *   title = @Translation("Marketo"),
 *   description = @Translation("Marketo"),
 * )
 */
class MarketoService implements EmbedReplaceServiceInterface {

  /**
   * @inheritdoc
   */
  public function getLibraries() {
    $libraries = [
      'embed_replace/embed_replace',
    ];

    return $libraries;
  }

  /**
   * @inheritdoc
   */
  public function getToken() {
    return '[marketo]';
  }

  /**
   * @inheritdoc
   */
  public function getReplacement() {
    return '<h1>Fuck yah!</h1>';
  }

}
