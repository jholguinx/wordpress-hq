<?php
namespace HQRentalsPlugin\HQRentalsApi;

use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsApiConfiguration
{
    public function __construct()
    {
        $this->settings = new HQRentalsSettings();
        $this->endpoints = new HQRentalsApiEndpoint();
        $this->normalTimeout = 20;
    }

    public function getBasicApiConfiguration( $data = null )
    {
        if($data){
            return array(
                'headers'   =>  array(
                    'Authorization' => 'Basic ' . $this->settings->getApiEncodedToken()
                ),
                'body'      =>  $data,
                'timeout'   =>  10
            );
        }
        return array(
            'headers'   =>  array(
                'Authorization' => 'Basic ' . $this->settings->getApiEncodedToken()
            ),
            'timeout'   =>  $this->normalTimeout
        );
    }
    public function getBasicApiConfigurationForGebouwWorkspotLocation()
    {
        return array(
            'headers'   =>  array(
                'Authorization' => 'Basic ' . $this->settings->getEncodedApiKeyForWorkspotLocation()
            ),
            'timeout'   =>  $this->normalTimeout
        );
    }
}