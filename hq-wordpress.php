<?php
/*
Plugin Name: HQ Rental Software
Plugin URI: https://hqrentalsoftware.com/knowledgebase/wordpress-plugin/
Description: This plugin is to easily integrate HQ Rental Software with your website which will allow your rental business to receive reservations directly from your site.
Version: 1.0.7
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