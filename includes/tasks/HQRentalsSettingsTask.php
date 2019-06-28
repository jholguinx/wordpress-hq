<?php
namespace HQRentalsPlugin\HQRentalsTasks;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsSettingsTask{
    public function __construct()
    {
        $this->connector = new Connector();
        $this->settings = new HQRentalsSettings();
    }
    public function refreshSettingsData()
    {
        $this->syncSettingsData();
    }
    public function syncSettingsData()
    {
        $settings = $this->connector->getHQRentalsTenantsSettings();
        if($settings->success){
            $this->settings->saveTenantDatetimeOption($settings->date_format);
        }
    }
}