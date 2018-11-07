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
}