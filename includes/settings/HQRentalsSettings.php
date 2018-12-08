<?php

namespace HQRentalsPlugin\HQRentalsSettings;

use HQRentalsPlugin\HQRentalsTasks\HQRentalsScheduler;
use HQRentalsPlugin\HQRentalsVendor\Carbon;

/*
 * HQ Rental Software Plugin
 *
 */

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

    public function getApiUserToken()
    {
        return get_option($this->api_user_token, true);
    }

    public function getApiTenantToken()
    {
        return get_option($this->api_tenant_token, true);
    }

    public function getApiDecodedToken()
    {
        return get_option($this->api_encoded_token, true);
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
        update_option($this->api_base_url, $newApiUrl);
    }

    public function saveApiUserToken($token)
    {
        return update_option($this->api_user_token, $token);
    }

    public function saveApiTenantToken($token)
    {
        return update_option($this->api_tenant_token, $token);
    }

    public function saveWoocommerSyncOption($value = false)
    {
        return update_option($this->woocommerce_hq_sync, $value);
    }

    public function saveHQDatetimeFormat($datetime_format)
    {
        return update_option($this->hq_datetime_format, $datetimeformat);
    }

    public function saveFrontEndDateTimeFormat($datetime_format)
    {
        return update_option($this->front_end_datetime_format, $datetime_format);
    }

    public function saveEncodedApiKey($tenantKey, $userKey)
    {
        update_option($this->api_encoded_token, base64_encode($tenantKey . ':' . $userKey));
    }

    /*
     * Update All Setting from Admin Screen
     */
    public function updateSettings($postDataFromSettings)
    {
        $this->saveEncodedApiKey($this->getApiTenantToken(), $this->getApiUserToken());
        foreach ($postDataFromSettings as $key => $data) {
            if ($key != 'save') {
                update_option($key, $data);
            }
        }
        $_POST['success'] = 'success';
    }

    public function getSettings()
    {
        return array(
            $this->api_user_token => $this->getApiUserToken(),
            $this->api_tenant_token => $this->getApiTenantToken(),
            $this->api_encoded_token => $this->getApiEncodedToken(),
            $this->woocommerce_hq_sync => $this->getWoocommerceSyncOption(),
            $this->hq_datetime_format => $this->getHQDatetimeFormat(),
            $this->front_end_datetime_format => $this->getFrontEndDatetimeFormat(),
            $this->api_base_url => $this->getApiBaseUrl()
        );
    }

    public function thereAreSomeSettingMissing()
    {
        return empty ($this->getApiTenantToken()) or
            empty ($this->getApiUserToken()) or
            empty ($this->getWoocommerceSyncOption()) or
            empty ($this->getHQDatetimeFormat()) or
            empty ($this->getFrontEndDatetimeFormat());
    }

    public function forceSyncOnHQData()
    {
        $schedule = new HQRentalsScheduler();
        $schedule->refreshHQData();
        $_POST['forcing_update'] = 'success';
    }
}
