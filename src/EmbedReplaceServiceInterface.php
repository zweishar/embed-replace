<?php

namespace Drupal\embed_replace;

/**
 * Define the embed replace service interface.
 */
interface EmbedReplaceServiceInterface {

  /**
   * Get libraries to attach for replacement.
   *
   * @return array
   *   Libraries to attach
   */
  public function getLibraries();

  /**
   * Get the token used for replacement
   *
   * @return string
   *   Token for replacement
   */
  public function getToken();

  /**
   * Get replacement
   *
   * @return string
   *   Value to replace with token
   */
  public function getReplacement();

}
