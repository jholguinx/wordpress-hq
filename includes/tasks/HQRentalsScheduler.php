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
    protected $siteURL;

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
            if($this->isWorkspotWebsite()){
                $workspot = $this->workspot->refreshLocationsData();
            }
            $this->settingsTask->tryToRefreshSettingsData();
            $this->brandsTask->tryToRefreshSettingsData();
            $this->locationsTask->tryToRefreshSettingsData();
            $this->additionalChargesTask->tryToRefreshSettingsData();
            $this->vehicleClassesTask->tryToRefreshSettingsData();

            if($this->allResponseAreOK()){
                $this->deleteHQData();
                $this->refreshAllDataOnDatabase();
                $_POST['success'] = 'success';
            }else{
                $error = $this->getErrorOnSync();
                $this->setErrorMessage($error);
            }
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
        return $this->settingsTask->dataWasRetrieved() and
            $this->brandsTask->dataWasRetrieved() and
            $this->locationsTask->dataWasRetrieved() and
            $this->additionalChargesTask->dataWasRetrieved() and
            $this->vehicleClassesTask->dataWasRetrieved();
    }

    public function refreshAllDataOnDatabase()
    {
        $this->settingsTask->setDataOnWP();
        $this->brandsTask->setDataOnWP();
        $this->locationsTask->setDataOnWP();
        $this->additionalChargesTask->setDataOnWP();
        $this->vehicleClassesTask->setDataOnWP();
    }
    public function getErrorOnSync()
    {
        if($this->settingsTask->getError()){
            return $this->settingsTask->getError();
        }
        if($this->brandsTask->getError()){
            return $this->brandsTask->getError();
        }
        if($this->locationsTask->getError()){
            return $this->locationsTask->getError();
        }
        if($this->additionalChargesTask->getError()){
            return $this->additionalChargesTask->getError();
        }
        if($this->vehicleClassesTask->getError()){
            return $this->vehicleClassesTask->getError();
        }
        return "";
    }
    public function setErrorMessage($error)
    {
        $_POST['success'] = 'error';
        $_POST['error_message'] = $error;
    }
}