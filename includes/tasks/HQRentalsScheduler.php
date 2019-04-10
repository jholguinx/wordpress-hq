<?php

namespace HQRentalsPlugin\HQRentalsTasks;


class HQRentalsScheduler
{
    /**
     * @var HQRentalsBrandsTask
     */
    protected $brandsTask;
    /**
     * @var HQRentalsLocationsTask
     */
    protected $locationsTask;
    /**
     * @var HQRentalsVehicleClassesTask
     */
    protected $vehicleClassesTask;
    /**
     * @var HQRentalsAdditionalChargesTask
     */
    protected $additionalChargesTask;

    public function __construct()
    {
        $this->brandsTask = new HQRentalsBrandsTask();
        $this->locationsTask = new HQRentalsLocationsTask();
        $this->vehicleClassesTask = new HQRentalsVehicleClassesTask();
        $this->additionalChargesTask = new HQRentalsAdditionalChargesTask();
        $this->workspot = new HQRentalsLocationsWorkspotTask();
    }

    public function refreshHQData()
    {
        //Should be some sort of validation -> return true is ok!!!
        global $wpdb;
        $site = get_site_url();
        $dbPrefix = $wpdb->prefix;
        $wpdb->get_results("delete from " . $dbPrefix . "posts where post_type like 'hqwp%';");
        $wpdb->get_results("delete from " . $dbPrefix . "postmeta where meta_key like 'hq_wordpress%';");

        $this->brandsTask->refreshBrandsData();
        $this->locationsTask->refreshLocationsData();
        $this->additionalChargesTask->refreshAdditionalChargesData();
        $this->vehicleClassesTask->refreshVehicleClassesData();
        if($site == 'http://workspot.test' or $site == 'https://workspot.nu'){
            $this->workspot->refreshLocationsData();
        }
    }
}