<?php

namespace Drupal\digital_ocean;

use DigitalOceanV2\Adapter\BuzzAdapter;
use DigitalOceanV2\DigitalOceanV2;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides the Digital Ocean service.
 */
class DigitalOcean implements DigitalOceanInterface {

  /**
   * The config for digital ocean.
   *
   * @var \Drupal\Core\Config\ImmutableConfig
   */
  protected $config;

  /**
   * Constructs a new Digital Ocean service instance.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory->get('digital_ocean.settings');
  }

  /**
   * {@inheritdoc}
   */
  public function getHandler() {
    $key = $this->config->get('access_key');
    if (empty($key)) {
      // THROW ERROR HERE.
      return NULL;
    }
    $adapter = new BuzzAdapter($key);
    $digitalocean = new DigitalOceanV2($adapter);
    return $digitalocean;
  }
}