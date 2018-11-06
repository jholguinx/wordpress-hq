<?php
namespace HQRentalsPlugin\HQRentalsSettings;

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
    public $woocommerce_hq_sync = 'hq_wordpress_woocommerce_hq_rentals_sync';
    public $hq_datetime_format = 'hq_wordpress_system_datetime_format';
    public $front_end_datetime_format = 'hq_wordpress_front_end_datetime_format';
    public $api_base_url = 'hq_wordpress_api_base_url';


    public function getApiUserToken()
    {
        return get_option($this->api_user_token, true);
    }
    public function getApiTenantToken()
    {
        return get_option($this->api_tenant_token, true);
    }
    public function getWoocommerceSyncOption()
    {
        return get_option($this->woocommerce_hq_sync, true);
    }
    public function getHQDatetimeFormat()
    {
        return get_option($this->hq_datetime_format,true);
    }
    public function getFrontEndDatetimeFormat()
    {
        return get_option($this->front_end_datetime_format, true);
    }
    public function getApiBaseUrl()
    {
        return get_option($this->api_base_url, true);
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

    public function updateSettings($postDataFromSettings)
    {
        foreach ($postDataFromSettings as $key => $data){
            update_option($key, $data);
        }
    }
    public function getSettings()
    {

    }
    public function thereAreSomeSettingMissing()
    {
        return  empty ($this->getApiTenantToken()) or
                empty ($this->getApiUserToken()) or
                empty ($this->getWoocommerceSyncOption()) or
                empty ($this->getHQDatetimeFormat()) or
                empty ($this->getFrontEndDatetimeFormat());
    }

}
