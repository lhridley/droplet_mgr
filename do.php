<?php
require_once 'vendor/autoload.php';

$client = new DigitalOceanV2\Client();
$client->authenticate('dop_v1_ffdab8caed87fbe97e413cb5e5f3c495bd533db616d23c6e8ca96b3f12daba44');

$pager = new DigitalOceanV2\ResultPager($client, 200);
//$account = $pager->fetchAll($client->account(), 'getUserInformation');
//var_dump($account); die;


$droplet = $pager->fetchAll($client->droplet(), 'getAll');
var_dump($droplet[0]); die;

//$sizes = $pager->fetchAll($client->size(), 'getAll');
//var_dump(count($sizes));
//var_dump($sizes[0]); die;
