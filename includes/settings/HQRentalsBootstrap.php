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
    public $api_base_url_default_value = "https://api.caagcrm.com/api/";
    public $hq_new_auth_scheme_default_value = 'false';
    public $hq_integration_on_home_default_value = 'false';
    public $hq_cronjob_disable_option_default_value = 'false';
    public $hq_tenant_date_time_format = "Y-m-d H:i";
    public $hq_disable_safari_option_default_value = 'false';

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
        $this->resolveDefaultPages();
    }

    public function resolveDefaultPages()
    {
        $page = get_page_by_title('Quote');
        if (empty($page)) {
            $args = array(
                'post_title' => 'Quote',
                'post_type' => 'page',
                'post_status' => 'publish'
            );
            $post_id = wp_insert_post($args);
            if (is_wp_error($post_id)) {
                $this->resolveDefaultPages();
            } else {
                update_post_meta($post_id, 'hq_wordpress_is_wordpress_page', '1' );
            }
        }
    }

}