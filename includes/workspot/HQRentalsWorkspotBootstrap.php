<?php

namespace HQRentalsPlugin\HQRentalsWorkspot;


class HQRentalsWorkspotBootstrap
{
    public function __construct()
    {
        add_action('init', array($this, 'lightsOn'));
        $this->scheduler = new HQRentalsWorkspotScheduler();
        add_action('refreshWorkspotData', array($this, 'refreshAllData'));
        if (!wp_next_scheduled('refreshWorkspotData')) {
            wp_schedule_event(time(), 'daily', 'refreshWorkspotData');
        }
    }

    public function refreshAllData()
    {
        global $wpdb;
        $dbPrefix = $wpdb->prefix;
        $wpdb->get_results("delete from " . $dbPrefix . "posts where post_type like 'hqwp%';");
        $wpdb->get_results("delete from " . $dbPrefix . "postmeta where meta_key like 'hq_wordpress%';");
        $this->brandsTask->refreshBrandsData();
        $this->locationsTask->refreshLocationsData();
        $this->additionalChargesTask->refreshAdditionalChargesData();
        $this->vehicleClassesTask->refreshVehicleClassesData();
    }

    public function lightsOn()
    {

    }
}