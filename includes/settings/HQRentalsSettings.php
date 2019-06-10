<?php

namespace HQRentalsPlugin\HQRentalsSettings;

use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsScheduler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsEncryptionHandler;

class HQRentalsSettings
{

    /*
     * Options Names
     */
    public $api_user_token = 'hq_wordpress_api_user_token_key_option';
    public $api_tenant_token = 'hq_wordpress_api_tenant_token_key_option';
    public $api_encoded_token = 'hq_wordpress_api_encoded_token_option';
    public $woocommerce_hq_sync = 'hq_wordpress_woocommerce_hq_rentals_sync_option';
    public $hq_datetime_format = 'hq_wordpress_system_datetime_format_option';
    public $front_end_datetime_format = 'hq_wordpress_front_end_datetime_format_option';
    public $api_base_url = 'hq_wordpress_api_base_url_option';
    public $api_user_token_workspot_gebouw_location = 'hq_wordpress_api_user_token_key_workspot_gebouw_location_option';
    public $api_tenant_token_workspot_gebouw_location = 'hq_wordpress_api_tenant_token_key_workspot_gebouw_location_option';
    public $api_encoded_token_workspot_gebouw_location = 'hq_wordpress_api_encoded_token_workspot_gebouw_location_option';
    public $support_for_minified_response_on_vehicle_classes = 'hq_wordpress_support_for_minified_response_on_vehicle_classes';
    public $new_auth_scheme = 'hq_wordpress_new_auth_scheme_enabled';

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
        if($this->newAuthSchemeEnabled()){
            return HQRentalsEncryptionHandler::decrypt(get_option($this->api_user_token, true));
        }else{
            return get_option($this->api_user_token, true);
        }
    }

    /**
     * Retrieve Api Tenant Token from DB
     * @return mixed|void
     */
    public function getApiTenantToken()
    {
        if($this->newAuthSchemeEnabled()){
            return HQRentalsEncryptionHandler::decrypt(get_option($this->api_tenant_token, true));
        }else{
            return get_option($this->api_tenant_token, true);
        }
    }

    /**
     * Retrieve Api Decoded Token
     * @return mixed|void
     */
    public function getApiDecodedToken()
    {
        if($this->newAuthSchemeEnabled()){
            return HQRentalsEncryptionHandler::decrypt(get_option($this->api_encoded_token, true));
        }else{
            return get_option($this->api_encoded_token, true);
        }

    }

    /**
     * Retrieve Api User Token for Worspot Module
     * @return mixed|void
     */
    public function getApiUserTokenForWorkspotLocation()
    {
        if($this->newAuthSchemeEnabled()){
            return HQRentalsEncryptionHandler::decrypt(get_option($this->api_user_token_workspot_gebouw_location, true));
        }else{
            return get_option($this->api_user_token_workspot_gebouw_location, true);
        }
    }

    /**
     * Retrieve Api Tenant Token for the Workspot Module
     * @return mixed|void
     */
    public function getApiTenantTokenForWorkspotLocation()
    {
        if($this->newAuthSchemeEnabled()){
            return HQRentalsEncryptionHandler::decrypt(get_option($this->api_tenant_token_workspot_gebouw_location, true));
        }else{
            return get_option($this->api_tenant_token_workspot_gebouw_location, true);
        }
    }

    /**
     * Retrieve encoded api token
     * @return mixed|void
     */
    public function getApiEncodedToken()
    {
        if($this->newAuthSchemeEnabled()){
            return HQRentalsEncryptionHandler::decrypt(get_option($this->api_encoded_token, true));
        }else{
            return get_option($this->api_encoded_token, true);
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
    /***
     * Retrieve Woocommerce Option - This should be erased
     * @return mixed|void
     */
    public function getWoocommerceSyncOption()
    {
        return get_option($this->woocommerce_hq_sync, true);
    }

    /**
     * Retrieve System Datetime format
     * @return mixed|void
     */
    public function getHQDatetimeFormat()
    {
        return get_option($this->hq_datetime_format, true);
    }

    /***
     * Retrieve front-end datetime format
     * @return mixed|void
     */
    public function getFrontEndDatetimeFormat()
    {
        return get_option($this->front_end_datetime_format, true);
    }

    /**
     * Retrieve support for minified response option
     * @return mixed|void
     */
    public function getSupportForMinifiedResponse()
    {
        return get_option($this->support_for_minified_response_on_vehicle_classes, 'false');
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
        return update_option($this->api_user_token, HQRentalsEncryptionHandler::encrypt(sanitize_text_field($token)));
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
        return update_option($this->api_tenant_token, HQRentalsEncryptionHandler::encrypt(sanitize_text_field($token)));
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
     * Save woocommence option - this should be deleted
     * @param bool $value
     * @return bool
     */
    public function saveWoocommerSyncOption($value = false)
    {
        return update_option($this->woocommerce_hq_sync, sanitize_text_field($value));
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
        return update_option($this->api_encoded_token_workspot_gebouw_location, HQRentalsEncryptionHandler::encrypt(sanitize_text_field(base64_encode($tenantKey . ':' . $userKey))) );
    }


    /***
     *  Save Minified Option on DB
     * @param $value
     * @return bool
     */
    public function saveMinifiedResponse($value)
    {
        return update_option($this->support_for_minified_response_on_vehicle_classes, sanitize_text_field($value));
    }

    public function saveNewAuthScheme($data)
    {
        return update_option($this->new_auth_scheme, sanitize_text_field($data));
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
                if($key == $this->api_tenant_token){
                    $this->saveApiTenantToken($postDataFromSettings[$this->api_tenant_token]);
                }elseif($key == $this->api_user_token){
                    $this->saveApiUserToken($postDataFromSettings[$this->api_user_token]);
                }elseif($key == $this->api_tenant_token_workspot_gebouw_location){
                    $this->saveApiTenantTokenForWorkspot($postDataFromSettings[$this->api_tenant_token_workspot_gebouw_location]);
                }elseif($key == $this->api_user_token_workspot_gebouw_location){
                    $this->saveApiUserTokenForWorkspotModule($postDataFromSettings[$this->api_user_token_workspot_gebouw_location]);
                }else{
                    update_option($key, sanitize_text_field($data));
                }
            }
        }
        if (empty($postDataFromSettings[$this->support_for_minified_response_on_vehicle_classes])) {
            update_option($this->support_for_minified_response_on_vehicle_classes, "false");
        }
        $_POST['success'] = 'success';
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
            $this->woocommerce_hq_sync => $this->getWoocommerceSyncOption(),
            $this->hq_datetime_format => $this->getHQDatetimeFormat(),
            $this->front_end_datetime_format => $this->getFrontEndDatetimeFormat(),
            $this->api_base_url => $this->getApiBaseUrl(),
            $this->support_for_minified_response_on_vehicle_classes => $this->getSupportForMinifiedResponse()
        );
    }


    /***
     *
     * There is something missing on the plugin Configuration?
     * @return bool
     */
    public function thereAreSomeSettingMissing()
    {
        return empty ($this->getApiTenantToken()) or
            empty ($this->getApiUserToken()) or
            empty ($this->getWoocommerceSyncOption()) or
            empty ($this->getHQDatetimeFormat()) or
            empty ($this->getFrontEndDatetimeFormat()) or
            empty ($this->getSupportForMinifiedResponse());
    }

    public function noNewAuthSchemeOption()
    {
        return empty(get_option($this->new_auth_scheme));
    }
    public function newAuthSchemeEnabled()
    {
        return get_option($this->new_auth_scheme, true) == 'true';
    }

    public function forceSyncOnHQData()
    {
        $schedule = new HQRentalsScheduler();
        $schedule->refreshHQData();
        $_POST['forcing_update'] = 'success';
    }
}
