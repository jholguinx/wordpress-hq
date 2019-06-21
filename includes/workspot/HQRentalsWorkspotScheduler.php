<?php

namespace HQRentalsPlugin\HQRentalsWorkspot;

use HQRentalsPlugin\HQRentalsTasks\HQRentalsLocationsWorkspotTask;

class HQRentalsWorkspotScheduler
{
    /**
     * @var HQRentalsBrandsTask
     */
    protected $locationsTasks;


    public function __construct()
    {
        $this->locationsTask = new HQRentalsLocationsWorkspotTask();
    }

    public function refreshHQData()
    {
        global $wpdb;
        $dbPrefix = $wpdb->prefix;
        $wpdb->get_results("delete from " . $dbPrefix . "posts where post_type like 'hqwp%';");
        $wpdb->get_results("delete from " . $dbPrefix . "postmeta where meta_key like 'hq_wordpress%';");
        $this->locationsTask->refreshLocationsData();
    }
}


