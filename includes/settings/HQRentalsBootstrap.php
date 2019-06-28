<?php
namespace HQRentalsPlugin\HQRentalsSettings;



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
    public $support_minified_response_default_value = "false";
    public $hq_new_auth_scheme_default_value = 'false';
    public $hq_integration_on_home_default_value = 'false';
    public $hq_cronjob_disable_option_default_value = 'false';
    public $hq_tenant_date_time_format = "Y-m-d H:i";

    public function __construct()
    {
        $this->settings = new HQRentalsSettings();
    }
    public function onPluginActivation()
    {
        if($this->settings->thereAreSomeSettingMissing()){
            $this->settings->saveApiTenantToken($this->api_tenant_token_default_value);
            $this->settings->saveApiUserToken( $this->api_user_token_default_value);
            $this->settings->saveHQDatetimeFormat( $this->hq_datetime_format_default_value );
            $this->settings->saveFrontEndDateTimeFormat($this->front_end_datetime_format_default_value);
            $this->settings->saveApiBaseUrl($this->api_base_url_default_value);
            $this->settings->saveMinifiedResponse($this->support_minified_response_default_value);
        }
        if($this->settings->noMinifiedResponseOption()){
            $this->settings->saveMinifiedResponse($this->support_minified_response_default_value);
        }
        if($this->settings->noNewAuthSchemeOption()){
            //Encrypt on existing websites
            $this->settings->saveNewAuthScheme($this->hq_new_auth_scheme_default_value);
        }
        if($this->settings->noHomeIntegrationOption()){
            $this->settings->saveHomeIntegration($this->hq_integration_on_home_default_value);
        }
        if($this->settings->noDisabledCronjobOption()){
            $this->settings->saveDisableCronjobOption($this->hq_cronjob_disable_option_default_value);
        }
        if($this->settings->noTenantDatetimeFormat()){
            $this->settings->saveTenantDatetimeOption($this->hq_tenant_date_time_format);
        }
    }
}