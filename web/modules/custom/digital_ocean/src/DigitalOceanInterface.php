<?php

namespace Drupal\digital_ocean;

/**
 * Provides the interface for Digital Ocean.
 */
interface DigitalOceanInterface {

  /**
   * Gets a digital ocean object.
   *
   * @return \DigitalOceanV2\DigitalOceanV2
   *   The digital ocean object
   */
  public function getHandler();

}
