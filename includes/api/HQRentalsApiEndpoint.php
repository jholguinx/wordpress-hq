<?php
namespace HQRentalsPlugin\HQRentalsApi;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsApiEndpoint{

    public function __construct()
    {
        $this->settings = new HQRentalsSettings();
    }

    /*
     * Get Brand Api Endpoint
     */
    public function getBrandsApiEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'fleets/brands';
    }

    public function getVehicleClassesApiEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'fleets/vehicle-classes?only_available_on_website=1';
    }

    public function getLocationsApiEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'fleets/locations';
    }
    public function getAdditionalChargesEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'fleets/additional-charges';
    }
    public function getHQAssetsEndpoint()
    {
        return 'https://api.caagcrm.com/api/assets/files';
    }
    public function getVehicleClassCustomFields()
    {
        return $this->settings->getApiBaseUrl() . 'fields/?item_type=fleets.vehicle_classes';
    }
}