<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use Exception;

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
        $this->settingsTask = new HQRentalsSettingsTask();
        $this->workspot = new HQRentalsLocationsWorkspotTask();
    }

    public function refreshHQData()
    {
        try{
            global $wpdb;
            $site = get_site_url();
            $dbPrefix = $wpdb->prefix;
            $wpdb->get_results("delete from " . $dbPrefix . "posts where post_type like 'hqwp%';");
            $wpdb->get_results("delete from " . $dbPrefix . "postmeta where meta_key like 'hq_wordpress%';");
            /*
             * Load data into WP
             * */
            $message = "There was an error, please check the settings of your HQ Rental Software account. Error message: \n";
            $settings = $this->settingsTask->refreshSettingsData();
            $brands = $this->brandsTask->refreshBrandsData();
            $locations = $this->locationsTask->refreshLocationsData();
            $addCharges = $this->additionalChargesTask->refreshAdditionalChargesData();
            $vehClasses = $this->vehicleClassesTask->refreshVehicleClassesData();
            if($site == 'http://workspot.test' or $site == 'https://workspot.nu'){
               $workspot = $this->workspot->refreshLocationsData();
            }
            
            if(!$settings->success){
                $message .=  $settings->errors. " \n";
                throw new Exception($message); 
            }
            if(!$brands->success){
                $message .=  $brands->errors. " \n";
                throw new Exception($message); 
            }
            if(!$locations->success){
                $message .=  $locations->errors. " \n";
                throw new Exception($message); 
            }
            if(!$addCharges->success){
                $message .=  $addCharges->errors. " \n";
                throw new Exception($message); 
            }
            if(!$vehClasses->success){
                $message .=  $vehClasses->errors. " \n";
                throw new Exception($message); 
            }
            if($site == 'http://workspot.test' or $site == 'https://workspot.nu'){
                if($workspot[0]->success == false || $workspot[1]->success == false){
                    $message .=  $workspot->errors. " \n";
                    throw new Exception($message); 
                }
            }
            return true;
        }catch(Exception $e){
            return $e->getMessage();
        }

    }
}