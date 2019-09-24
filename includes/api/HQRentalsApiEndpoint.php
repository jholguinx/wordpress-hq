<?php
namespace HQRentalsPlugin\HQRentalsApi;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsApiEndpoint{

    public function __construct()
    {
        $this->settings = new HQRentalsSettings();
    }

    public function getAvailabilityEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'car-rental/availability';
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
        return $this->settings->getApiBaseUrl() . 'fleets/vehicle-classes?only_available_on_website=1&minified_response=true';
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
    public function getWorkspotLocationsEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'sheets/10/items?limit=100';
    }
    public function getWorkspotLocationDetailEndpoint( $location )
    {
        return $this->settings->getApiBaseUrl() . 'workspot/locations/' . $location->id;
    }
    public function getGebouwFloorDetailEndpoint(){
        return $this->settings->getApiBaseUrl() . 'sheets/37/items/?limit=100';
    }
    public function getGebouwUnitsEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'sheets/11/items/?limit=100';
    }
    public function getWorkspotRegionsEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'sheets/49/items/?limit=100';
    }
    public function getTenantsSettingsEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'tenants/current';
    }
}