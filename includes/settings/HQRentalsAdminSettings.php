<?php

namespace HQRentalsPlugin\HQRentalsSettings;

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsDatesHelper;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;


class HQRentalsAdminSettings
{
    protected $settingsPageTitle = 'HQ Rentals Settings';
    protected $settingsMenuTitle = 'HQ Rentals';
    protected $settingsSlug = 'hq-wordpress-settings';

    function __construct()
    {
        $this->settings = new HQRentalsSettings();
        $this->dateHelper = new HQRentalsDatesHelper();
        $this->frontHelper = new HQRentalsFrontHelper();
        $this->assets = new HQRentalsAssetsHandler();
        add_action('admin_menu', array($this, 'setAdminMenuOptions'));
    }

    public function setAdminMenuOptions()
    {
        add_options_page(
            $this->settingsPageTitle,
            $this->settingsMenuTitle,
            'manage_options',
            $this->settingsSlug,
            array($this, 'displaySettingsPage')
        );
    }

    public function displaySettingsPage()
    {

        if (!empty($_POST)) {
            if (isset($_POST['hq_force_update'])) {
                $this->settings->forceSyncOnHQData();
            } else {
                $this->settings->updateSettings($_POST);
            }
            ?>
            <?php if (isset($_POST['success']) && $_POST['success'] == 'success'): ?>
                <div class="wrap">
                    <div class="message updated"><p>The Setting were Successfully Saved!</p></div>
                </div>
            <?php elseif (isset($_POST['forcing_update']) && $_POST['forcing_update'] == 'success'): ?>
                <div class="wrap">
                    <div class="message updated"><p>All data was saved</p></div>
                </div>
            <?php elseif (isset($_POST['forcing_update']) && $_POST['forcing_update'] != 'success'): ?>
                <div class="wrap">
                    <div class="notice notice-error"><p><?php echo $_POST['forcing_update']; ?></p></div>
                </div>
            <?php else: ?>
                <div class="wrap">
                    <div class="message updated"><p>The was something wrong</p></div>
                </div>
            <?php endif; ?>
            <?php
        } else {
            ?>


            <div class="wrap">
                <div id="wrap">
                    <h1 class="hq-admin-h1">HQ Rentals Setup</h1>
                    <form action="" method="post">

                        <style>
                            .hq-general-settings-wrapper {
                                display: flex;
                                flex: 1;
                                flex-direction: row;
                                width: 90%;
                            }

                            .hq-general-settings-item-wrapper {
                                display: flex;
                                flex: 1;
                                flex-direction: column;
                                padding-right: 50px;
                            }

                            .hq-general-settings-item {
                                display: flex;
                                flex-direction: row;
                            }

                            .hq-admin-text-input, .hq-admin-select-input {
                                height: 35px !important;
                                width: 100%;
                                border-radius: 5px;
                            }
                            .hq-admin-select-input{
                                max-width: 150px;
                            }
                            .hq-general-input-wrapper {
                                display: flex;
                                flex: 3;
                                align-items: center;
                                justify-content: flex-start;
                            }

                            .hq-general-label-wrapper {
                                display: flex;
                                flex: 1;
                                align-items: center;
                                justify-content: space-between;
                            }

                            .small {
                                max-width: 50px;
                            }
                            .tokens{
                                flex: 4;
                            }
                            #hq-tooltip-user-token, #hq-tooltip-tenant-token{
                                padding-left: 10px;
                                padding-right: 10px;
                            }
                            .hq-tokens-rows{
                                justify-content: flex-start;
                            }
                            .hq-dates{
                                flex:  35 !important;
                            }
                            .hq-dates-input{
                                flex:  65 !important;
                            }
                        </style>
                        <script src="https://unpkg.com/popper.js@1"></script>
                        <script src="https://unpkg.com/tippy.js@5"></script>
                        <div class="hq-general-settings-section-wrapper">
                            <h3 class="hq-admin-h3">General Settings</h3>
                            <div class="hq-general-settings-wrapper">
                                <div class="hq-general-settings-item-wrapper hq-tokens-rows">
                                    <div class="hq-general-settings-item">
                                        <div class="hq-general-label-wrapper">
                                            <h4 class="wp-heading-inline" for="title">Tenant token</h4>
                                            <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="Log in to your HQ account and navigate to settings > settings > integrations > copy the API token and paste it here."></span>
                                        </div>
                                        <div class="hq-general-input-wrapper tokens">
                                            <input class="hq-admin-text-input"
                                                   type="text"
                                                   name="<?php echo esc_attr($this->settings->api_tenant_token); ?>"
                                                   value="<?php echo esc_attr($this->settings->getApiTenantToken()); ?>"
                                                   id="title"
                                                   spellcheck="true" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="hq-general-settings-item">
                                        <div class="hq-general-label-wrapper">
                                            <h4 class="wp-heading-inline" for="title">User token</h4>
                                            <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="Log in to your HQ account and navigate to settings > user management > users > integrations > select your user profile > generate and copy the API token and paste it here."></span>
                                        </div>
                                        <div class="hq-general-input-wrapper tokens">
                                            <input class="hq-admin-text-input"
                                                   type="text"
                                                   name="<?php echo esc_attr($this->settings->api_user_token); ?>"
                                                   value="<?php echo esc_attr($this->settings->getApiUserToken()); ?>"
                                                   spellcheck="true" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="hq-general-settings-item-wrapper">
                                    <div class="hq-general-settings-item">
                                        <div class="hq-general-label-wrapper hq-dates">
                                            <h4 class="wp-heading-inline" for="title">Select front-end date format</h4>
                                            <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content=" This is the format of the dates on your website, and this must match the system date format."></span>
                                        </div>
                                        <div class="hq-general-input-wrapper hq-dates-input">
                                            <select class="hq-admin-select-input"
                                                    name="<?php echo esc_attr($this->settings->front_end_datetime_format); ?>">
                                                <?php echo $this->dateHelper->getHtmlOptionForFrontEndDateSettingOption(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="hq-general-settings-item">
                                        <div class="hq-general-label-wrapper hq-dates">
                                            <h4 class="wp-heading-inline" for="title">Select system date format</h4>
                                            <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="This is the date format set up on your HQ account settings. You can find this under general settings."></span>
                                        </div>
                                        <div class="hq-general-input-wrapper hq-dates-input">
                                            <select class="hq-admin-select-input"
                                                    name="<?php echo $this->settings->hq_datetime_format; ?>">
                                                <?php echo $this->dateHelper->getHtmlOptionForSystemDateSettingOption(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="hq-general-settings-item">
                                        <div class="hq-general-label-wrapper hq-dates">
                                            <h4 class="wp-heading-inline" for="title">API Tenant Region</h4>
                                            <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="<span>For xxx.caagcrm.com, your region is America</span>
                                                                                                                                        <p>For xxx.hqrentals.app, your region is in America 2</p>
                                                                                                                                        <p>For xxx.west.hqrentals.app, your region is in America West</p>
                                                                                                                                        <p>For  xxx.hqrentals.eu, your region is Europe</p>
                                                                                                                                        <p>For xxx.hqrentals.asia, your region is Asia</p>"></span>
                                        </div>
                                        <div class="hq-general-input-wrapper hq-dates-input">
                                            <select class="hq-admin-select-input "
                                                    name="<?php echo $this->settings->api_base_url; ?>">
                                                <option value="https://api.caagcrm.com/api/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api.caagcrm.com/api/') ? 'selected="selected"' : ''; ?>>
                                                    America
                                                </option>
                                                <option value="https://api-america-2.caagcrm.com/api-america-2/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api-america-2.caagcrm.com/api-america-2/') ? 'selected="selected"' : ''; ?>>
                                                    America 2
                                                </option>
                                                <option value="https://api-america-west.caagcrm.com/api-america-west/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api-america-west.caagcrm.com/api-america-west/') ? 'selected="selected"' : ''; ?>>
                                                    America West
                                                </option>
                                                <option value="https://api-europe.caagcrm.com/api-europe/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api-europe.caagcrm.com/api-europe/') ? 'selected="selected"' : ''; ?>>
                                                    Europe
                                                </option>
                                                <option value="https://api-asia.caagcrm.com/api-asia/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api-asia.caagcrm.com/api-asia/') ? 'selected="selected"' : ''; ?>>
                                                    Asia
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hq-advanced-section">
                            <h3 class="hq-admin-h3">Advanced Development Settings</h3>
                            <div class="hq-general-settings-wrapper">
                                <div class="hq-general-settings-item-wrapper">
                                    <div class="hq-general-settings-item-wrapper">
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Disable safari redirect</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="This will disable the redirection to the public reservation link of your HQ account for users using a Safari browser. You will need to update CNAME record for compatibility"></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="checkbox"
                                                       name="<?php echo $this->settings->hq_disable_safari_functionality; ?>"
                                                       value="true" <?php echo ($this->settings->getDisableSafari() === 'true') ? 'checked' : ''; ?>/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Support for reservation iFrame
                                                    on homepage</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="Support for reservations iframe on the home page  - this should be applied in case that you are placing the reservation process on the home page."></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="checkbox"
                                                       name="<?php echo $this->settings->hq_integration_on_home; ?>"
                                                       value="true" <?php echo ($this->settings->getSupportForHomeIntegration() === 'true') ? 'checked' : ''; ?>/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Disable Data Synchronization</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="Select this option to stop data sychronization between HQ Rental Software and the website."></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="checkbox"
                                                       name="<?php echo $this->settings->hq_disable_cronjob_option; ?>"
                                                       value="true" <?php echo ($this->settings->getDisableCronjobOption() === 'true') ? 'checked' : ''; ?>/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Enable change of branch url</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="This option will enable you to change the base url for the public links of the reservation process."></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="checkbox"
                                                       name="<?php echo $this->settings->hq_replace_url_on_brand_option; ?>"
                                                       value="true" <?php echo ($this->settings->getReplaceBaseURLOnBrandsSetting() === 'true') ? 'checked' : ''; ?>/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Fleet location coordinates
                                                    field id</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="text"
                                                       class="hq-admin-text-input small"
                                                       name="<?php echo $this->settings->hq_location_coordinate_field; ?>"
                                                       value="<?php echo esc_attr($this->settings->getLocationCoordinateField()); ?>"/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Fleet location image field
                                                    id</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="text"
                                                       class="hq-admin-text-input small"
                                                       name="<?php echo $this->settings->hq_location_image_field; ?>"
                                                       value="<?php echo esc_attr($this->settings->getLocationImageField()); ?>"/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Fleet location description
                                                    field id</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="text"
                                                       class="hq-admin-text-input small"
                                                       name="<?php echo $this->settings->hq_location_description_field; ?>"
                                                       value="<?php echo esc_attr($this->settings->getLocationDescriptionField()); ?>"/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Fleet location address field
                                                    id</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="text"
                                                       class="hq-admin-text-input small"
                                                       name="<?php echo $this->settings->hq_location_address_label_field; ?>"
                                                       value="<?php echo esc_attr($this->settings->getAddressLabelField()); ?>"/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Fleet location office hours
                                                    field id</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="text"
                                                       class="hq-admin-text-input small"
                                                       name="<?php echo $this->settings->hq_location_office_hours_field; ?>"
                                                       value="<?php echo esc_attr($this->settings->getOfficeHoursSetting()); ?>"/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Fleet location vehicle brands
                                                    field id</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="text"
                                                       class="hq-admin-text-input small"
                                                       name="<?php echo $this->settings->hq_location_brands_field; ?>"
                                                       value="<?php echo esc_attr($this->settings->getBrandsSetting()); ?>"/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Default latitude for Map Shortcode</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="Place here the latitude of the location you would like for the map to set focus on in case the user denies location access."></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="text"
                                                       class="hq-admin-text-input hq-admin-text-input-small-medium"
                                                       name="<?php echo $this->settings->hq_default_latitude_for_map_shortcode; ?>"
                                                       value="<?php echo esc_attr($this->settings->getDefaultLatitudeSetting()); ?>"/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Default longitude for Map Shortcode</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="Place here the longitude of the location you would like for the map to set focus on in case the user denies location access."></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="text"
                                                       class="hq-admin-text-input hq-admin-text-input-small-medium"
                                                       name="<?php echo $this->settings->hq_default_longitude_for_map_shortcode; ?>"
                                                       value="<?php echo esc_attr($this->settings->getDefaultLongitudeSetting()); ?>"/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Domain to replace in the public reservation process</h4>
                                                <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"data-tippy-content="This domain will be used to replace the system url in public reservation processes"></span>
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="text"
                                                       class="hq-admin-text-input hq-admin-text-input-medium"
                                                       name="<?php echo $this->settings->hq_url_to_replace_on_brands_option; ?>"
                                                       value="<?php echo esc_attr($this->settings->getBrandURLToReplaceSetting()); ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hq-general-settings-item-wrapper">
                                    </div>
                                </div>

                            </div>
                            <div class="hq-admin-help-section">
                                <p>Need help? Please click <strong><a target="_blank"
                                                                      href="https://hqrentalsoftware.com/knowledgebase/wordpress-plugin/ ">here</a></strong> for
                                    more information on how to set up the HQ Rentals plugin.</p>
                            </div>
                            <input type="submit" name="save" value="Save" class="button button-primary button-large">
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
        <style>
            .hq-admin-warning-section {
                max-width: 500px;
            }

            .hq-admin-help-section, .hq-admin-help-section {
                padding-top: 25px;
                padding-bottom: 25px;
            }

            .hq-admin-warning-section p, .hq-admin-help-section p {
                font-style: italic;
            }

            .fw-brz-dismiss p:last-of-type a {
                color: #fff;
                font-size: 13px;
                line-height: 1;
                background-color: #d62c64;
                box-shadow: 0px 2px 0px 0px #981e46;
                padding: 11px 27px 12px;
                border: 1px solid #d62c64;
                border-bottom: 0;
                border-radius: 3px;
                text-shadow: none;
                height: auto;
                text-decoration: none;
                display: inline-block;
                transition: all 200ms linear;
            }
            .wp-heading-inline,.hq-admin-h1, .hq-admin-h3{
                text-transform: uppercase;
            }
            .hq-admin-text-input-medium{
                max-width: 300px;
            }
            .hq-admin-text-input-small-medium{
                max-width: 120px;
            }

        </style>
        <script>
            (function($){
                tippy('#hq-tooltip-tenant-token');
            })(jQuery);
        </script>
        <?php

    }
}
