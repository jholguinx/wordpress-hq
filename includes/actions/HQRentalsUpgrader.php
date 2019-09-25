<?php

namespace HQRentalsPlugin\HQRentalsActions;


require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
require_once ABSPATH . 'wp-admin/includes/misc.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader-skin.php';
require_once ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php';

class HQRentalsUpgrader{

    public function __construct()
    {

        $this->upgrader = new \Plugin_Upgrader();
    }
    public function upgradePlugin()
    {
        $this->upgrader->upgrade('hq-wordpress');
    }
}