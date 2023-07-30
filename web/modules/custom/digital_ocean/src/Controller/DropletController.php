<?php

namespace Drupal\digital_ocean\Controller;

use DigitalOceanV2\ResultPager;
use Drupal\Core\Controller\ControllerBase;
use Drupal\digital_ocean\DigitalOcean;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines DropletController class.
 */
class DropletController extends ControllerBase {

  /**
   * Digital Ocean Client.
   *
   * @var \Drupal\digital_ocean\DigitalOcean
   */
  protected $client;

  /**
   * DropletController constructor.
   *
   * @param \Drupal\digital_ocean\DigitalOcean $client
   *   The Digital Ocean API Client.
  */
  public function __construct(DigitalOcean $client) {
    $this->client = $client;
  }

  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The Drupal service container.
   *
   * @return static
   */  
  public static function create(ContainerInterface $container) {
    return new static(
        $container->get('digital_ocean.client')
    );
  }

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {
    $client = $this->client->getHandler();
    $pager = new ResultPager($client, 200);
    $build['simple'] = [
        '#type' => '#markup',
    ];  
    if (!is_null($client)) {        
      $droplets = $pager->fetchAll($client->droplet(), 'getAll');
      $number = count($droplets);
      $no = $number < 2 ? 'Droplet' : 'Droplets';
      $build['simple']['#markup'] = '<h2>' . $number . ' ' . $no . '</h2><hr/>';
      foreach ($droplets as $droplet) {
        $build['simple']['#markup'] .= '<h3>Name:  ' . $droplet->name . '</h3>';
        $build['simple']['#markup'] .= '<div>ID:  ' . $droplet->id . '</div>';
        $build['simple']['#markup'] .= '<div>UUID:  ' . $droplet->vpcUuid . '</div>';
        $build['simple']['#markup'] .= '<div>Memory:  ' . $droplet->memory . ' MB</div>';
        $build['simple']['#markup'] .= '<div>vCPUs:  ' . $droplet->vcpus . '</div>';
        $build['simple']['#markup'] .= '<div>Disk:  ' . $droplet->disk . ' GB</div>';
        $build['simple']['#markup'] .= '<div>Region:  ' . $droplet->region->name . ' (' . $droplet->region->slug . ')</div>';
        $avail = $droplet->region->available == TRUE ? "yes" : "no";
        $build['simple']['#markup'] .= '<div>Available:  ' . $avail . '</div>';
        $build['simple']['#markup'] .= '<div>Image:  ' . $droplet->image->description . '</div>';
        $build['simple']['#markup'] .= '<div>Status:  ' . $droplet->status . '</div>';
        $build['simple']['#markup'] .= '<div>Public IP:  ' . $droplet->networks[0]->ipAddress . '</div>';
        $backups = $droplet->backupsEnabled == TRUE ? "yes" : "no";
        $build['simple']['#markup'] .= '<div>Backups Enabled:  ' . $backups . '</div>';
      }
      //var_dump($droplets); die;
    }
    else {
        $build['simple']['#markup'] = '<div>Droplet Information cannot be retrieved without a valid Digital Ocean API Access Key.</div>';
    }
    
    return $build['simple'];
  }

}