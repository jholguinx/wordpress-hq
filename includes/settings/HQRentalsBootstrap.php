<?php
namespace HQRentalsPlugin\HQRentalsSettings;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings as Settings;


class HQRentalsBootstrap
{

    /*
     * Plugin Option to be configured by users
     * The names of this option are on the Settings
     */
    public $api_user_token_default_value = "";
    public $api_tenant_token_default_value = "";
    public $woocommerce_hq_sync_default_value = false;
    public $hq_datetime_format_default_value = "Y-m-d H:i";
    public $front_end_datetime_format_default_value = "Y-m-d H:i";
    public $api_base_url_default_value  = "https://api.caagcrm.com/api/";

    public function __construct()
    {
        $this->settings = new Settings();
    }
    public function onPluginActivation()
    {
        if($this->settings->thereAreSomeSettingMissing()){
            $this->settings->saveApiTenantToken($this->api_tenant_token_default_value);
            $this->settings->saveApiUserToken( $this->api_user_token_default_value);
            $this->settings->saveWoocommerSyncOption( $this->woocommerce_hq_sync_default_value );
            $this->settings->saveHQDatetimeFormat( $this->hq_datetime_format_default_value );
            $this->settings->saveFrontEndDateTimeFormat($this->front_end_datetime_format_default_value);
            $this->settings->saveApiBaseUrl($this->api_base_url_default_value);
        }
    }
}