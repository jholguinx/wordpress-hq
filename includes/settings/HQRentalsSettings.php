<?php

namespace HQRentalsPlugin\HQRentalsSettings;

use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsScheduler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsEncryptionHandler;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsCronJob;

class HQRentalsSettings
{

    /*
     * Options Names
     */
    public $api_user_token = 'hq_wordpress_api_user_token_key_option';
    public $api_tenant_token = 'hq_wordpress_api_tenant_token_key_option';
    public $api_encoded_token = 'hq_wordpress_api_encoded_token_option';
    public $hq_datetime_format = 'hq_wordpress_system_datetime_format_option';
    public $front_end_datetime_format = 'hq_wordpress_front_end_datetime_format_option';
    public $api_base_url = 'hq_wordpress_api_base_url_option';
    public $api_user_token_workspot_gebouw_location = 'hq_wordpress_api_user_token_key_workspot_gebouw_location_option';
    public $api_tenant_token_workspot_gebouw_location = 'hq_wordpress_api_tenant_token_key_workspot_gebouw_location_option';
    public $api_encoded_token_workspot_gebouw_location = 'hq_wordpress_api_encoded_token_workspot_gebouw_location_option';
    public $new_auth_scheme = 'hq_wordpress_new_auth_scheme_enabled';
    public $hq_integration_on_home = 'hq_wordpress_home_integration_enabled';
    public $hq_disable_cronjob_option = 'hq_wordpress_disable_cronjob_option';
    public $hq_enable_decreasing_rate_order_on_vehicles_query = 'hq_enable_decreasing_rate_order_on_vehicles_query';
    public $hq_tenant_datetime_format = 'hq_wordpress_tenant_datetime_format';
    public $hq_tenant_link = 'hq_wordpress_tenant_link';
    public $hq_disable_safari_functionality = 'hq_disable_safari_functionality';
    public $hq_location_coordinate_field = 'hq_location_coordinate_field';
    public $hq_location_image_field = 'hq_location_image_field';
    public $hq_location_description_field = 'hq_location_description_field';
    public $hq_location_address_label_field = 'hq_location_address_label_field';
    public $hq_location_brands_field = 'hq_location_brands_field';
    public $hq_location_phone_field = 'hq_location_phone_field';
    public $hq_location_address_field = 'hq_location_address_field';
    public $hq_location_office_hours_field = 'hq_location_office_hours_field';
    public $hq_replace_url_on_brand_option = 'hq_replace_url_on_brand_option';
    public $hq_url_to_replace_on_brands_option = 'hq_url_to_replace_on_brands_option';
    public $hq_default_latitude_for_map_shortcode = 'hq_default_latitude_for_map_shortcode';
    public $hq_default_longitude_for_map_shortcode = 'hq_default_longitude_for_map_shortcode';

    public function __construct()
    {
        $this->helper = new HQRentalsFrontHelper();
    }

    /**
     * Retrieve Api User Token from DB
     * @return mixed|void
     */
    public function getApiUserToken()
    {
        $option = get_option($this->api_user_token, "");
        if ($this->newAuthSchemeEnabled()) {
            if(!empty($option)){
                return HQRentalsEncryptionHandler::decrypt(get_option($this->api_user_token));
            }else{
                return '';
            }
        } else {
            if(!empty($option)){
                return get_option($this->api_user_token);
            }else{
                return '';
            }

        }
    }

    /**
     * Retrieve Api Tenant Token from DB
     * @return mixed|void
     */
    public function getApiTenantToken()
    {
        if ($this->newAuthSchemeEnabled()) {
            return HQRentalsEncryptionHandler::decrypt(get_option($this->api_tenant_token));
        } else {
            return get_option($this->api_tenant_token);
        }
    }

    /**
     * Retrieve Api User Token for Worspot Module
     * @return mixed|void
     */
    public function getApiUserTokenForWorkspotLocation()
    {
        if ($this->newAuthSchemeEnabled()) {
            return HQRentalsEncryptionHandler::decrypt(get_option($this->api_user_token_workspot_gebouw_location));
        } else {
            return get_option($this->api_user_token_workspot_gebouw_location);
        }
    }

    /**
     * Retrieve Api Tenant Token for the Workspot Module
     * @return mixed|void
     */
    public function getApiTenantTokenForWorkspotLocation()
    {
        if ($this->newAuthSchemeEnabled()) {
            return HQRentalsEncryptionHandler::decrypt(get_option($this->api_tenant_token_workspot_gebouw_location));
        } else {
            return get_option($this->api_tenant_token_workspot_gebouw_location);
        }
    }

    /**
     * Retrieve encoded api token
     * @return mixed|void
     */
    public function getApiEncodedToken()
    {
        if ($this->newAuthSchemeEnabled()) {
            return HQRentalsEncryptionHandler::decrypt(get_option($this->api_encoded_token));
        } else {
            return get_option($this->api_encoded_token);
        }
    }

    /**
     * Retrieve Encoded Api Token from Workspot Module
     * @return mixed|void
     */
    public function getEncodedApiKeyForWorkspotLocation()
    {
        if ($this->newAuthSchemeEnabled()) {
            return HQRentalsEncryptionHandler::decrypt(get_option($this->api_encoded_token_workspot_gebouw_location));
        } else {
            return get_option($this->api_encoded_token_workspot_gebouw_location);
        }
    }

    /**
     * Retrieve System Datetime format
     * @return mixed|void
     */
    public function getHQDatetimeFormat()
    {
        return get_option($this->hq_datetime_format);
    }

    /***
     * Retrieve front-end datetime format
     * @return mixed|void
     */
    public function getFrontEndDatetimeFormat()
    {
        return get_option($this->front_end_datetime_format);
    }

    public function getSupportForHomeIntegration()
    {
        return get_option($this->hq_integration_on_home, 'false');
    }
    public function getDisableCronjobOption()
    {
        return get_option($this->hq_disable_cronjob_option, 'false');
    }
    public function getTenantDatetimeFormat()
    {
        return get_option($this->hq_tenant_datetime_format, '');
    }
    public function getDisableSafari()
    {
        return get_option($this->hq_disable_safari_functionality, 'false');
    }
    public function getDisableSafariValue()
    {
        return $this->getDisableSafari() == 'true';
    }

    /**
     * Retrieve Base Api Option
     * @return mixed|void
     */
    public function getApiBaseUrl()
    {
        return get_option($this->api_base_url, true);
    }

    /**
     * Save api base url
     * @param $newApiUrl
     * @return bool
     */
    public function saveApiBaseUrl($newApiUrl)
    {
        return update_option($this->api_base_url, sanitize_text_field($newApiUrl));
    }

    /**
     * Save api user token
     * @param $token
     * @return bool
     */
    public function saveApiUserToken($token)
    {
        if(empty($token)){
            return update_option($this->api_user_token, "");
        }else{
            return update_option($this->api_user_token, HQRentalsEncryptionHandler::encrypt(sanitize_text_field($token)));
        }

    }

    /**
     * Save api user token
     * @param $token
     * @return bool
     */
    public function saveApiUserTokenForWorkspotModule($token)
    {
        return update_option($this->api_user_token_workspot_gebouw_location, HQRentalsEncryptionHandler::encrypt(sanitize_text_field($token)));
    }

    /**
     * Save api tenant token
     * @param $token
     * @return bool
     */
    public function saveApiTenantToken($token)
    {
        if(empty($token)){
            return update_option($this->api_tenant_token, "");
        }else{
            return update_option($this->api_tenant_token, HQRentalsEncryptionHandler::encrypt(sanitize_text_field($token)));
        }

    }

    /**
     * Save api tenant token for workspot module
     * @param $token
     * @return bool
     */
    public function saveApiTenantTokenForWorkspot($token)
    {
        return update_option($this->api_tenant_token_workspot_gebouw_location, HQRentalsEncryptionHandler::encrypt(sanitize_text_field($token)));
    }

    /**
     * Save system datetime format
     * @param $datetime_format
     * @return bool
     */
    public function saveHQDatetimeFormat($datetime_format)
    {
        return update_option($this->hq_datetime_format, sanitize_text_field($datetime_format));
    }

    /**
     * Save front end datetime format
     * @param $datetime_format
     * @return bool
     */
    public function saveFrontEndDateTimeFormat($datetime_format)
    {
        return update_option($this->front_end_datetime_format, sanitize_text_field($datetime_format));
    }

    /**
     * Save encoded api token
     * @param $tenantKey
     * @param $userKey
     * @return bool
     */
    public function saveEncodedApiKey($tenantKey, $userKey)
    {
        return update_option($this->api_encoded_token, HQRentalsEncryptionHandler::encrypt(sanitize_text_field(base64_encode($tenantKey . ':' . $userKey))));
    }

    /**
     * Save Encoded api token for workspot module
     * @param $tenantKey
     * @param $userKey
     * @return bool
     */
    public function saveEncodedApiKeyForWorkspotLocation($tenantKey, $userKey)
    {
        return update_option($this->api_encoded_token_workspot_gebouw_location, HQRentalsEncryptionHandler::encrypt(sanitize_text_field(base64_encode($tenantKey . ':' . $userKey))));
    }

    public function saveNewAuthScheme($data)
    {
        return update_option($this->new_auth_scheme, sanitize_text_field($data));
    }

    public function saveHomeIntegration($data)
    {
        return update_option($this->hq_integration_on_home, sanitize_text_field($data));
    }
    public function saveDisableCronjobOption($data)
    {
        return update_option($this->hq_disable_cronjob_option, sanitize_text_field($data));
    }
    public function saveTenantDatetimeOption($data)
    {
        return update_option($this->hq_tenant_datetime_format, sanitize_text_field($data));
    }
    public function saveTenantLink($data){
        return update_option($this->hq_tenant_link, sanitize_text_field($data));
    }
    public function getTenantLink(){
        return get_option($this->hq_tenant_link, '');
    }
    public function saveDisableSafariOption($data)
    {
        return update_option($this->hq_disable_safari_functionality, sanitize_text_field($data));
    }


    public function noLocationCoordinateSetting()
    {
        return empty(get_option($this->hq_location_coordinate_field));
    }

    public function saveLocationCoordinateSetting($data)
    {
        return update_option($this->hq_location_coordinate_field, sanitize_text_field($data));
    }
    public function getLocationCoordinateField()
    {
        return get_option($this->hq_location_coordinate_field, '');
    }

    public function noLocationImageSetting(){
        return empty(get_option($this->hq_location_image_field));
    }
    public function saveLocationImageSetting($data)
    {
        return update_option($this->hq_location_image_field, $data);
    }
    public function getLocationImageField()
    {
        return get_option($this->hq_location_image_field, '');
    }

    public function noLocationDescriptionSetting(){
        return empty(get_option($this->hq_location_description_field));
    }
    public function saveLocationDescriptionSetting($data)
    {
        return update_option($this->hq_location_description_field, $data);
    }
    public function getLocationDescriptionField()
    {
        return get_option($this->hq_location_description_field, '');
    }

    public function noAddressLabelSetting(){
        return empty(get_option($this->hq_location_address_label_field));
    }
    public function saveAddressLabelSetting($data)
    {
        return update_option($this->hq_location_address_label_field, $data);
    }
    public function getAddressLabelField()
    {
        return get_option($this->hq_location_address_label_field, '');
    }

    public function noOfficeHoursSetting(){
        return empty(get_option($this->hq_location_office_hours_field));
    }
    public function saveOfficeHoursSetting($data)
    {
        return update_option($this->hq_location_office_hours_field, $data);
    }
    public function getOfficeHoursSetting()
    {
        return get_option($this->hq_location_office_hours_field, '');
    }

    public function noBrandsSetting(){
        return empty(get_option($this->hq_location_brands_field));
    }
    public function saveBrandsSetting($data)
    {
        return update_option($this->hq_location_brands_field, $data);
    }
    public function getBrandsSetting()
    {
        return get_option($this->hq_location_brands_field, '');
    }


    public function noPhoneSetting(){
        return empty(get_option($this->hq_location_phone_field));
    }
    public function savePhoneSetting($data)
    {
        return update_option($this->hq_location_phone_field, $data);
    }
    public function getPhoneSetting()
    {
        return get_option($this->hq_location_phone_field, '');
    }
    public function noAddressSetting(){
        return empty(get_option($this->hq_location_address_field));
    }
    public function saveAddressSetting($data)
    {
        return update_option($this->hq_location_address_field, $data);
    }
    public function getAddressSetting()
    {
        return get_option($this->hq_location_address_field, '');
    }

    public function noDecreasingRateOrder(){
        return empty(get_option($this->hq_enable_decreasing_rate_order_on_vehicles_query));
    }
    public function saveDecreasingRateOrder($data)
    {
        return update_option($this->hq_enable_decreasing_rate_order_on_vehicles_query, $data);
    }
    public function getDecreasingRateOrder()
    {
        return get_option($this->hq_enable_decreasing_rate_order_on_vehicles_query, 'false');
    }
    public function isDescreasingRateOrderActive()
    {
        return $this->getDecreasingRateOrder() === 'true';
    }

    public function noReplaceBaseURLOnBrandsSetting(){
        return empty(get_option($this->hq_replace_url_on_brand_option));
    }
    public function saveReplaceBaseURLOnBrandsSetting($data)
    {
        return update_option($this->hq_replace_url_on_brand_option, $data);
    }
    public function getReplaceBaseURLOnBrandsSetting()
    {
        return get_option($this->hq_replace_url_on_brand_option, '');
    }
    public function noBrandURLToReplaceSetting(){
        return empty(get_option($this->hq_url_to_replace_on_brands_option));
    }
    public function saveBrandURLToReplaceSetting($data)
    {
        return update_option($this->hq_url_to_replace_on_brands_option, $data);
    }
    public function getBrandURLToReplaceSetting()
    {
        return get_option($this->hq_url_to_replace_on_brands_option, '');
    }

    /*
     * Latitude setting
     * */
    public function noDefaultLatitudeSetting()
    {
        return empty(get_option($this->hq_default_latitude_for_map_shortcode));
    }
    public function getDefaultLatitudeSetting()
    {
        return get_option($this->hq_default_latitude_for_map_shortcode, "");
    }
    public function setDefaultLatitudeSetting($data)
    {
        return update_option($this->hq_default_latitude_for_map_shortcode, $data);
    }

    /*
     * Longitude setting
     * */
    public function noDefaultLongitudeSetting()
    {
        return empty(get_option($this->hq_default_longitude_for_map_shortcode));
    }
    public function getDefaultLongitudeSetting()
    {
        return get_option($this->hq_default_longitude_for_map_shortcode, "");
    }
    public function setDefaultLongitudeSetting($data)
    {
        return update_option($this->hq_default_longitude_for_map_shortcode, $data);
    }





    /***
     * Save Settings on Database
     * @param $postDataFromSettings
     */
    public function updateSettings($postDataFromSettings)
    {
        $postDataFromSettings = $this->helper->sanitizeTextInputs($postDataFromSettings);
        $this->saveEncodedApiKey($postDataFromSettings[$this->api_tenant_token], $postDataFromSettings[$this->api_user_token]);
        $this->saveEncodedApiKeyForWorkspotLocation($postDataFromSettings[$this->api_tenant_token_workspot_gebouw_location], $postDataFromSettings[$this->api_user_token_workspot_gebouw_location]);
        $this->saveNewAuthScheme('true');
        foreach ($postDataFromSettings as $key => $data) {
            if ($key != 'save') {
                if ($key == $this->api_tenant_token) {
                    $this->saveApiTenantToken($postDataFromSettings[$this->api_tenant_token]);
                } elseif ($key == $this->api_user_token) {
                    $this->saveApiUserToken($postDataFromSettings[$this->api_user_token]);
                } elseif ($key == $this->api_tenant_token_workspot_gebouw_location) {
                    $this->saveApiTenantTokenForWorkspot($postDataFromSettings[$this->api_tenant_token_workspot_gebouw_location]);
                } elseif ($key == $this->api_user_token_workspot_gebouw_location) {
                    $this->saveApiUserTokenForWorkspotModule($postDataFromSettings[$this->api_user_token_workspot_gebouw_location]);
                } else {
                    update_option($key, sanitize_text_field($data));
                }
            }
        }
        if (empty($postDataFromSettings[$this->hq_integration_on_home])) {
            update_option($this->hq_integration_on_home, "false");
        }
        if (empty($postDataFromSettings[$this->hq_disable_cronjob_option])) {
            update_option($this->hq_disable_cronjob_option, "false");
        }
        if (empty($postDataFromSettings[$this->hq_disable_safari_functionality])) {
            update_option($this->hq_disable_safari_functionality, "false");
        }
        if (empty($postDataFromSettings[$this->hq_replace_url_on_brand_option])) {
            update_option($this->hq_replace_url_on_brand_option, "false");
        }
        if(empty($postDataFromSettings[$this->hq_enable_decreasing_rate_order_on_vehicles_query])){
            update_option($this->hq_enable_decreasing_rate_order_on_vehicles_query, "false");
        }
        /*Refresh data on save */
        $worker = new HQRentalsCronJob();
        $worker->refreshAllData();
    }

    /***
     * Retrieve all Settings as an array
     * @return array
     */
    public function getSettings()
    {
        return array(
            $this->api_user_token => $this->getApiUserToken(),
            $this->api_tenant_token => $this->getApiTenantToken(),
            $this->api_encoded_token => $this->getApiEncodedToken(),
            $this->hq_datetime_format => $this->getHQDatetimeFormat(),
            $this->front_end_datetime_format => $this->getFrontEndDatetimeFormat(),
            $this->api_base_url => $this->getApiBaseUrl()
        );
    }


    /***
     *
     * There is something missing on the plugin Configuration?
     * @return bool
     */
    public function thereAreSomeSettingMissing()
    {
        /*
         * Options missing on DB
         * */
        return empty (get_option($this->api_tenant_token)) or
            empty (get_option($this->api_user_token)) or
            empty (get_option($this->front_end_datetime_format)) or
            empty (get_option($this->hq_datetime_format));
    }

    /**
     * Checks if new auth scheme exits
     * @return bool
     */
    public function noNewAuthSchemeOption()
    {
        return empty(get_option($this->new_auth_scheme));
    }
    public function noDisableSafariFunctionality()
    {
        return empty(get_option($this->hq_disable_safari_functionality));
    }

    /**
     * Check if new Auth Scheme is enabled
     * @return bool
     */
    public function newAuthSchemeEnabled()
    {
        return get_option($this->new_auth_scheme) == 'true';
    }
    public function noTenantDatetimeFormat()
    {
        return empty(get_option($this->hq_tenant_datetime_format));
    }

    public function noHomeIntegrationOption()
    {
        return empty(get_option($this->hq_integration_on_home));
    }
    public function noDisabledCronjobOption()
    {
        return empty(get_option($this->hq_disable_cronjob_option));
    }

    public function homeIntegration()
    {
        return get_option($this->hq_integration_on_home) == 'true';
    }

    public function forceSyncOnHQData()
    {
        $schedule = new HQRentalsScheduler();
        $res = $schedule->refreshHQData();
        if($res === true){
            $_POST['forcing_update'] = 'success';
        }else{
            $_POST['forcing_update'] = $res;
        }
    }
}
