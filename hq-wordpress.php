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


/*
 * Requires Files
 */
require_once('includes/models/HQRentalsBootstrap.php');
require_once('includes/models/HQRentalsSettings.php');
use HQRentalWordpressModels\HQRentalsBootstrap;

/*
 * Activation Routine
 * @return void
 */
function hq_rentals_wordpress_activation()
{
    $boot = new HQRentalsBootstrap();
    $boot->onPluginActivation();
}
register_activation_hook(__FILE__,'hq_rentals_wordpress_activation');