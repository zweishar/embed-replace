<?php

/**
 * @file
 * Contains \Drupal\url_embed\Plugin\EmbedType\Url.
 */

namespace Drupal\embed_replace\Plugin\EmbedType;

use Drupal\embed\EmbedType\EmbedTypeBase;

/**
 * URL embed type.
 *
 * @EmbedType(
 *   id = "embed_replace",
 *   label = @Translation("Embed Replace")
 * )
 */
class EmbedReplace extends EmbedTypeBase {

  /**
   * {@inheritdoc}
   */
  public function getDefaultIconUrl() {
    return file_create_url(drupal_get_path('module', 'embed_replace') . 'path-to-image.png');
  }
}
