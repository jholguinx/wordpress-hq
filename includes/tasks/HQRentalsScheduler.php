<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use Exception;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsCacheHandler;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;
use HQRentalsPlugin\HQRentalsVendor\Carbon;

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
     * @var HQRentalsVehicleTypesTask
     */
    protected $vehicleTypesTask;
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
        $this->vehicleTypesTask = new HQRentalsVehicleTypesTask();
        $this->additionalChargesTask = new HQRentalsAdditionalChargesTask();
        $this->settingsTask = new HQRentalsSettingsTask();
        $this->carRentalSettingTask = new HQRentalsCarRentalSettingsTask();
        $this->workspot = new HQRentalsLocationsWorkspotTask();
        $this->cache = new HQRentalsCacheHandler();
        $this->siteURL = get_site_url();
    }

    public function refreshHQData()
    {
        try {
            $settings = new HQRentalsSettings();
            if ($this->isWorkspotWebsite()) {
                $workspot = $this->workspot->refreshLocationsData();
            }
            if($settings->getWebhookSyncOption() === 'true'){
                $option = $settings->getLastSyncOption();
                $lastUpdated = Carbon::createFromFormat('Y-m-d H:i:s', $option);
                $now = Carbon::now();
                if($now->diffInMinutes($lastUpdated) > 5){
                    $settings->setLastSyncOption();
                    $this->settingsTask->tryToRefreshSettingsData();
                    $this->carRentalSettingTask->tryToRefreshSettingsData();
                    $this->brandsTask->tryToRefreshSettingsData();
                    $this->locationsTask->tryToRefreshSettingsData();
                    // additional charges -> not update
                    $this->additionalChargesTask->tryToRefreshSettingsData();
                    $this->vehicleClassesTask->tryToRefreshSettingsData();
                    $this->vehicleTypesTask->tryToRefreshSettingsData();
                    if ($this->allResponseAreOK()) {
                        $this->deleteHQData();
                        $this->refreshAllDataOnDatabase();
                        $_POST['success'] = 'success';
                    } else {
                        $error = $this->getErrorOnSync();
                        $error = "There was an issue with your request. Please verify tokens and installation region.";
                        $this->setErrorMessage($error);
                    }
                }
            }else{
                $settings->setLastSyncOption();
                $this->settingsTask->tryToRefreshSettingsData();
                $this->carRentalSettingTask->tryToRefreshSettingsData();
                $this->brandsTask->tryToRefreshSettingsData();
                $this->locationsTask->tryToRefreshSettingsData();
                // additional charges -> not update
                $this->additionalChargesTask->tryToRefreshSettingsData();
                $this->vehicleClassesTask->tryToRefreshSettingsData();
                $this->vehicleTypesTask->tryToRefreshSettingsData();
                if ($this->allResponseAreOK()) {
                    $this->deleteHQData();
                    $this->refreshAllDataOnDatabase();
                    $_POST['success'] = 'success';
                } else {
                    $error = $this->getErrorOnSync();
                    $error = "There was an issue with your request. Please verify tokens and installation region.";
                    $this->setErrorMessage($error);
                }
            }

        } catch (Exception $e) {
            $this->setErrorMessage($e->getMessage());
        }
    }

    public function deleteHQData()
    {
        global $wpdb;
        $dbPrefix = $wpdb->prefix;
        $wpdb->get_results("delete from " . $dbPrefix . "posts where post_type like 'hqwp%';");
        $wpdb->get_results("delete from " . $dbPrefix . "postmeta where meta_key like 'hq_wordpress%';");
    }
    public function deleteHQSelectedData($postLike, $metaLike)
    {
        global $wpdb;
        $dbPrefix = $wpdb->prefix;
        $wpdb->get_results("delete from " . $dbPrefix . "posts where post_type like '" . $postLike ."%';");
        $wpdb->get_results("delete from " . $dbPrefix . "postmeta where meta_key like '" . $metaLike ."%';");
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
            $this->vehicleTypesTask->dataWasRetrieved() and
            $this->vehicleClassesTask->dataWasRetrieved();
    }

    public function refreshAllDataOnDatabase()
    {
        $this->settingsTask->setDataOnWP();
        $this->carRentalSettingTask->setDataOnWP();
        $this->brandsTask->setDataOnWP();
        $this->locationsTask->setDataOnWP();
        $this->additionalChargesTask->setDataOnWP();
        $this->vehicleTypesTask->setDataOnWP();
        $this->vehicleClassesTask->setDataOnWP();
    }

    public function getErrorOnSync()
    {
        if ($this->settingsTask->getError()) {
            return $this->settingsTask->getError();
        }
        if ($this->brandsTask->getError()) {
            return $this->brandsTask->getError();
        }
        if ($this->locationsTask->getError()) {
            return $this->locationsTask->getError();
        }
        if ($this->additionalChargesTask->getError()) {
            return $this->additionalChargesTask->getError();
        }
        if ($this->vehicleClassesTask->getError()) {
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