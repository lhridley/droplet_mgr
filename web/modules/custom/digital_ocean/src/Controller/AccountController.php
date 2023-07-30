<?php

namespace Drupal\digital_ocean\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\digital_ocean\DigitalOcean;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines AccountController class.
 */
class AccountController extends ControllerBase {

  /**
   * Digital Ocean Client.
   *
   * @var \Drupal\digital_ocean\DigitalOcean
   */
  protected $client;

  /**
   * AccountController constructor.
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
    $build['simple'] = [
        '#type' => '#markup',
        '#markup' => '<h2>Account</h2><h3>Provides information about your current account.</h3>',
    ];  
    if (!is_null($client)) {
        $accountInfo = $client->account()->getUserInformation();
        $build['simple']['#markup'] .= '<div class="account-info team-info"><span>Team: ' . $accountInfo->team->name . '</span></div>';
        $build['simple']['#markup'] .= '<div class="account-info email"><span> Email: ' . $accountInfo->email . '</span></div>';
        $email_verified = $accountInfo->emailVerified == 1 ? "Yes" : "No";
        $build['simple']['#markup'] .= '<div class="account-info email-verified"><span> Verified Email: ' . $email_verified . '</span></div>';
        $build['simple']['#markup'] .= '<div class="account-info status"><span> Status: ' . $accountInfo->status . '</span></div>';
        if(strlen($accountInfo->statusMessage) > 0) {
            $build['simple']['#markup'] .= '<div class="account-info status-msg"><span> Status Message: ' . $accountInfo->statusMessage . '</span></div>';
        }
        $build['simple']['#markup'] .= '<div class="account-info droplet-limit"><span> Droplet Limit: ' . $accountInfo->dropletLimit . '</span></div>';
        $build['simple']['#markup'] .= '<div class="account-info floatingip-limit"><span> Floating IP Limit: ' . $accountInfo->floatingIpLimit . '</span></div>';
    }
    else {
        $build['simple']['#markup'] = '<div>Account Information cannot be retrieved without a valid Digital Ocean API Access Key.</div>';
    }
    
    return $build['simple'];
  }

}