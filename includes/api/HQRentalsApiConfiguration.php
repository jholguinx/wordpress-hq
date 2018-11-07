<?php
namespace HQRentalsPlugin\HQRentalsApi;

use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsApiConfiguration
{
    public function __construct()
    {
        $this->settings = new HQRentalsSettings();
        $this->endpoints = new HQRentalsApiEndpoint();
    }

    public function getBasicApiConfiguration()
    {
        return array(
            'headers'   =>  array(
                'Authorization' => 'Basic ' . $this->settings->getApiEncodedToken()
            )
        );
    }

}