<?php
/*
Plugin Name: HQ Rental Software Plugin
Plugin URI: https://hqrentalsoftware.com
Description: HQ Rental Software Plugin
Version: 0.5.2
Author: HQ Rental Software
Author URI: https://hqrentalsoftware.com
Text Domain: hq-wordpress
*/

namespace HQRentalsPlugin;

require_once( 'includes/autoloader.php' );
// If this file is accessed directory, then abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

use HQRentalsPlugin\HQRentalsSettings\HQRentalsBootstrap;
use HQRentalsPlugin\HQRentalsBootstrap\HQRentalsBootstrapPlugin;

$bootstraper = new HQRentalsBootstrapPlugin();
/*
 * Activation Routine
 * @return void
 */
function hq_rentals_wordpress_activation() {
	$boot = new HQRentalsBootstrap();
	$boot->onPluginActivation();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\hq_rentals_wordpress_activation' );