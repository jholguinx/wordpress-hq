<?php

namespace HQRentalsPlugin\HQRentalsSettings;

use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsScheduler;

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

    public function __construct()
    {
        $this->helper = new HQRentalsFrontHelper();
    }

    public function getApiUserToken()
    {
        return get_option($this->api_user_token, true);
    }

    public function getApiTenantToken()
    {
        return get_option($this->api_tenant_token, true);
    }
    public function getApiUserTokenForWorkspotLocation()
    {
        return get_option($this->api_user_token_workspot_gebouw_location, true);
    }

    public function getApiTenantTokenForWorkspotLocation()
    {
        return get_option($this->api_tenant_token_workspot_gebouw_location, true);
    }

    public function getApiDecodedToken()
    {
        return get_option($this->api_encoded_token, true);
    }
    public function getEncodedApiKeyForWorkspotLocation(){
        return get_option($this->api_encoded_token_workspot_gebouw_location);
    }
    public function getWoocommerceSyncOption()
    {
        return get_option($this->woocommerce_hq_sync, true);
    }

    public function getHQDatetimeFormat()
    {
        return get_option($this->hq_datetime_format, true);
    }

    public function getFrontEndDatetimeFormat()
    {
        return get_option($this->front_end_datetime_format, true);
    }
    public function getSupportForMinifiedResponse()
    {
        return get_option($this->support_for_minified_response_on_vehicle_classes, 'false');
    }

    public function getApiBaseUrl()
    {
        return get_option($this->api_base_url, true);
    }

    public function getApiEncodedToken()
    {
        return get_option($this->api_encoded_token, true);
    }

    public function saveApiBaseUrl($newApiUrl)
    {
        return update_option($this->api_base_url, sanitize_text_field($newApiUrl));
    }

    public function saveApiUserToken($token)
    {
        return update_option($this->api_user_token, sanitize_text_field($token));
    }

    public function saveApiTenantToken($token)
    {
        return update_option($this->api_tenant_token, sanitize_text_field($token));
    }

    public function saveWoocommerSyncOption($value = false)
    {
        return update_option($this->woocommerce_hq_sync, sanitize_text_field($value));
    }

    public function saveHQDatetimeFormat($datetime_format)
    {
        return update_option($this->hq_datetime_format, sanitize_text_field($datetime_format));
    }

    public function saveFrontEndDateTimeFormat($datetime_format)
    {
        return update_option($this->front_end_datetime_format, sanitize_text_field($datetime_format));
    }

    public function saveEncodedApiKey($tenantKey, $userKey)
    {
        return update_option($this->api_encoded_token, sanitize_text_field(base64_encode($tenantKey . ':' . $userKey)));
    }
    public function saveEncodedApiKeyForWorkspotLocation($tenantKey, $userKey)
    {
        return update_option($this->api_encoded_token_workspot_gebouw_location, sanitize_text_field(base64_encode($tenantKey . ':' . $userKey)));
    }
    public function saveMinifiedResponse($value)
    {
        return update_option($this->support_for_minified_response_on_vehicle_classes, sanitize_text_field($value));
    }
    /*
     * Update All Setting from Admin Screen
     */
    public function updateSettings($postDataFromSettings)
    {
        $postDataFromSettings = $this->helper->sanitizeTextInputs($postDataFromSettings);
        $this->saveEncodedApiKey($postDataFromSettings[$this->api_tenant_token], $postDataFromSettings[$this->api_user_token]);
        $this->saveEncodedApiKeyForWorkspotLocation( $postDataFromSettings[$this->api_tenant_token_workspot_gebouw_location], $postDataFromSettings[$this->api_user_token_workspot_gebouw_location] );
        foreach ($postDataFromSettings as $key => $data) {
            if ($key != 'save') {
                update_option($key, sanitize_text_field($data));
            }
        }
        if(empty($postDataFromSettings[$this->support_for_minified_response_on_vehicle_classes])){
            update_option($this->support_for_minified_response_on_vehicle_classes, "false");
        }
        $_POST['success'] = 'success';
    }

    public function getSettings()
    {
        return array(
            $this->api_user_token                                       => $this->getApiUserToken(),
            $this->api_tenant_token                                     => $this->getApiTenantToken(),
            $this->api_encoded_token                                    => $this->getApiEncodedToken(),
            $this->woocommerce_hq_sync                                  => $this->getWoocommerceSyncOption(),
            $this->hq_datetime_format                                   => $this->getHQDatetimeFormat(),
            $this->front_end_datetime_format                            => $this->getFrontEndDatetimeFormat(),
            $this->api_base_url                                         => $this->getApiBaseUrl(),
            $this->support_for_minified_response_on_vehicle_classes     =>  $this->getSupportForMinifiedResponse()
        );
    }

    public function thereAreSomeSettingMissing()
    {
        return empty ($this->getApiTenantToken()) or
            empty ($this->getApiUserToken()) or
            empty ($this->getWoocommerceSyncOption()) or
            empty ($this->getHQDatetimeFormat()) or
            empty ($this->getFrontEndDatetimeFormat()) or
            empty ($this->getSupportForMinifiedResponse());
    }

    public function forceSyncOnHQData()
    {
        $schedule = new HQRentalsScheduler();
        $schedule->refreshHQData();
        $_POST['forcing_update'] = 'success';
    }
}
