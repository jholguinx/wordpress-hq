<?php
namespace HQRentalsPlugin\HQRentalsModels;
use HQRentalsPlugin\HQRentalsModels\HQRentalsSettings as Settings;


class HQRentalsBootstrap
{

    protected $api_user_token_default_value = '';
    protected $api_tenant_token_default_value = '';
    protected $woocommerce_hq_sync_default_value = false;
    protected $hq_datetime_format_default_value = 'Y-m-d H:i';
    protected $front_end_datetime_format_default_value = 'Y-m-d H:i';

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
        }
    }
}