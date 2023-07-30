<?php

namespace Drupal\digital_ocean;

use DigitalOceanV2\Client;
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
    $this->config = $config_factory->get('digital_ocean.admin_settings');
  }

  /**
   * {@inheritdoc}
   */
  public function getHandler() {
    $key = $this->getAccessKey();
    if (empty($key)) {
      // THROW ERROR HERE.
      return NULL;
    }
    $client = new Client();
    $client->authenticate($key);
    return $client;
  }

  /**
   * Returns access key.
   *
   * return string;
   */
  public function getAccessKey() {
    return $this->config->get('access_key');
  }
}
