Digital Ocean
=============

Creates a Drupal service that wraps the Digital Ocean PHP SDK.

Documentation for SDK can be found here: https://github.com/toin0u/DigitalOceanV2

Fill out the config form at /admin/config/development/digital-ocean

You will need an Access Key from Digital Ocean.

Sample code usage:

```
$do = Drupal::service('digital_ocean.manager')->getHandler();
$droplets = $do->droplets()->getAll();
```
