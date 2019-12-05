<?php

namespace HQRentalsPlugin\HQRentalsSettings;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;

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
    public $api_base_url_default_value = "https://api.caagcrm.com/api/";
    public $hq_new_auth_scheme_default_value = 'false';
    public $hq_integration_on_home_default_value = 'false';
    public $hq_cronjob_disable_option_default_value = 'false';
    public $hq_tenant_date_time_format = "Y-m-d H:i";
    public $hq_disable_safari_option_default_value = 'false';
    public $hq_location_coordinate_default_value = '';
    public $hq_location_image_default_value = '';
    public $hq_location_description_default_value = '';
    public $hq_location_default_field_value = '';

    public function __construct()
    {
        $this->settings = new HQRentalsSettings();
    }

    public function onPluginActivation()
    {
        if ($this->settings->thereAreSomeSettingMissing()) {
            $this->settings->saveApiTenantToken($this->api_tenant_token_default_value);
            $this->settings->saveApiUserToken($this->api_user_token_default_value);
            $this->settings->saveHQDatetimeFormat($this->hq_datetime_format_default_value);
            $this->settings->saveFrontEndDateTimeFormat($this->front_end_datetime_format_default_value);
            $this->settings->saveApiBaseUrl($this->api_base_url_default_value);
        }
        if ($this->settings->noNewAuthSchemeOption()) {
            //Encrypt on existing websites
            $this->settings->saveNewAuthScheme($this->hq_new_auth_scheme_default_value);
        }
        if ($this->settings->noHomeIntegrationOption()) {
            $this->settings->saveHomeIntegration($this->hq_integration_on_home_default_value);
        }
        if ($this->settings->noDisabledCronjobOption()) {
            $this->settings->saveDisableCronjobOption($this->hq_cronjob_disable_option_default_value);
        }
        if ($this->settings->noTenantDatetimeFormat()) {
            $this->settings->saveTenantDatetimeOption($this->hq_tenant_date_time_format);
        }
        if ($this->settings->noDisableSafariFunctionality()) {
            $this->settings->saveDisableSafariOption($this->hq_disable_safari_option_default_value);
        }
        if ($this->settings->noLocationCoordinateSetting()) {
            $this->settings->saveLocationCoordinateSetting($this->hq_location_coordinate_default_value);
        }
        if ($this->settings->noLocationImageSetting()) {
            $this->settings->saveLocationImageSetting($this->hq_location_image_default_value);
        }
        if ($this->settings->noLocationDescriptionSetting()) {
            $this->settings->saveLocationDescriptionSetting($this->hq_location_description_default_value);
        }
        if ($this->settings->noAddressLabelSetting()) {
            $this->settings->saveAddressLabelSetting($this->hq_location_default_field_value);
        }
        if ($this->settings->noBrandsSetting()) {
            $this->settings->saveBrandsSetting($this->hq_location_description_default_value);
        }
        if ($this->settings->noOfficeHoursSetting()) {
            $this->settings->saveOfficeHoursSetting($this->hq_location_description_default_value);
        }
        if($this->settings->noBrandURLToReplaceSetting()){
            $this->settings->saveBrandURLToReplaceSetting($this->hq_location_default_field_value);
        }
        if($this->settings->noReplaceBaseURLOnBrandsSetting()){
            $this->settings->saveReplaceBaseURLOnBrandsSetting($this->hq_integration_on_home_default_value);
        }
        $this->resolveDefaultPages();
        $this->notifyToSystemOnActivation();
    }

    public function resolveDefaultPages()
    {
        $page = get_page_by_title('Quotes');
        $payments = get_page_by_title('Payments');
        if (empty($page)) {
            $this->resolvePageOnCreation('Quotes');
        }
        if(empty($payments)){
            $this->resolvePageOnCreation('Payments');
        }
    }
    public function resolvePageOnCreation($pageTitle)
    {
        $args = array(
            'post_title' => $pageTitle,
            'post_type' => 'page',
            'post_status' => 'publish'
        );
        $post_id = wp_insert_post($args);
        if (is_wp_error($post_id)) {
            $this->resolvePageOnCreation($pageTitle);
        } else {
            update_post_meta($post_id, 'hq_wordpress_is_wordpress_page', '1' );
        }
    }
    public function notifyToSystemOnActivation()
    {
        $api = new HQRentalsApiConnector();
        $response = $api->notifyOnActivation();
    }


}