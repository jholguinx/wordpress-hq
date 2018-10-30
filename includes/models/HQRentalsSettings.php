<?php
/**
 * Created by PhpStorm.
 * User: Migue
 * Date: 10/29/2018
 * Time: 10:54 PM
 */

namespace HQRentalWordpressModels;


/*
 * HQ Rental Software Plugin
 *
 */
class HQRentalsSettings
{

    /*
     * Options Names
     */
    protected $api_user_token = 'hq_wordpress_api_user_token_key_option';
    protected $api_tenant_token = 'hq_wordpress_api_tenant_token_key_option';
    protected $woocommerce_hq_sync = 'hq_wordpress_woocommerce_hq_rentals_sync';
    protected $hq_datetime_format = 'hq_wordpress_system_datetime_format';
    protected $front_end_datetime_format = 'hq_wordpress_front_end_datetime_format';

    public function getApiUserToken()
    {
        return get_option($this->api_user_token, false);
    }
    public function getApiTenantToken()
    {
        return get_option($this->api_tenant_token, false);
    }
    public function getWoocommerceSyncOption()
    {
        return get_option($this->woocommerce_hq_sync, false);
    }
    public function getHQDatetimeFormat()
    {
        return get_option($this->hq_datetime_format,false);
    }
    public function getFrontEndDatetimeFormat()
    {
        return get_option($this->front_end_datetime_format);
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

    public function update()
    {

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
