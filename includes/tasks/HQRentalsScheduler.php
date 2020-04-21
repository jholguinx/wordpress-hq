<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use Exception;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsCacheHandler;

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
    protected $siteURL = '';

    public function __construct()
    {
        $this->brandsTask = new HQRentalsBrandsTask();
        $this->locationsTask = new HQRentalsLocationsTask();
        $this->vehicleClassesTask = new HQRentalsVehicleClassesTask();
        $this->additionalChargesTask = new HQRentalsAdditionalChargesTask();
        $this->settingsTask = new HQRentalsSettingsTask();
        $this->workspot = new HQRentalsLocationsWorkspotTask();
        $this->cache = new HQRentalsCacheHandler();
        $this->siteURL = get_site_url();
    }

    public function refreshHQData()
    {
        $this->cache->addVehiclesClassesToCache();
        try{
            $this->settingsTask->tryToRefreshSettingsData();
            $this->brandsTask->tryToRefreshSettingsData();
            /*Validalte all response and proceed to set data on D*/
            if($this->allResponseAreOK()){
                $this->deleteHQData();
                $this->refreshAllDataOnDatabase();
            }else{
                $error = $this->getErrorOnSync();
            }


            //$brands = $this->brandsTask->refreshBrandsData();
            $locations = $this->locationsTask->refreshLocationsData();
            $addCharges = $this->additionalChargesTask->refreshAdditionalChargesData();
            $vehicleClasses = $this->vehicleClassesTask->refreshVehicleClassesData();
            if($this->isWorkspotWebsite()){
                $workspot = $this->workspot->refreshLocationsData();
            }
            return true;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
    public function deleteHQData()
    {
        global $wpdb;
        $dbPrefix = $wpdb->prefix;
        $wpdb->get_results("delete from " . $dbPrefix . "posts where post_type like 'hqwp%';");
        $wpdb->get_results("delete from " . $dbPrefix . "postmeta where meta_key like 'hq_wordpress%';");
    }

    public function isWorkspotWebsite()
    {
        return $this->siteURL == 'http://workspot.test' or $this->siteURL == 'https://workspot.nu';
    }
    public function allResponseAreOK()
    {
        /*Add alls*/
        return $this->settingsTask->dataWasRetrieved() and
            $this->brandsTask->dataWasRetrieved();
    }

    public function refreshAllDataOnDatabase()
    {
        $this->settingsTask->setDataOnWP();
        $this->brandsTask->setDataOnWP();
    }
    public function getErrorOnSync(){
        return "rerer";
    }

}