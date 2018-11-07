<?php
/*
Plugin Name: HQ Rental Plugin
Plugin URI: https://hqrentalsoftware.com
Description: HQ Rental Software Plugin
Version: 1.0.0
Author: Miguel Faggioni
Author URI: https://hqrentalsoftware.com
Text Domain: hq-wordpress
*/
namespace HQRentalsPlugin;
require_once('includes/autoloader.php');
// If this file is accessed directory, then abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
use HQRentalsPlugin\HQRentalsSettings\HQRentalsBootstrap;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsAdminSettings;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;
$set = new HQRentalsAdminSettings();
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector;
use HQRentalsPlugin\HQRentalsCustomPosts\HQRentalsCustomPostsHandler;
$as = new HQRentalsCustomPostsHandler();

/*
function hqtest(){
    $api = new HQRentalsApiConnector();
    $hqBrands = $api->getHQRentalsBrands()->data;
    foreach ($hqBrands as $brand){
        $newBrand = new HQRentalsModelsBrand();
        $newBrand->setBrandFromApi($brand);
        $newBrand->create();
    }
}
add_action('template_redirect', __NAMESPACE__ . '\hqtest');*/
/*
 * Activation Routine
 * @return void
 */
function hq_rentals_wordpress_activation()
{
    $boot = new HQRentalsBootstrap();
    $boot->onPluginActivation();
}
register_activation_hook(__FILE__,__NAMESPACE__ . '\hq_rentals_wordpress_activation');