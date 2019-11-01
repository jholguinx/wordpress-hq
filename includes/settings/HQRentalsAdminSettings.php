<?php

namespace HQRentalsPlugin\HQRentalsSettings;

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
                    <h1>HQ Rentals Authentication Access</h1>
                    <form action="" method="post">

                        <style>
                            .hq-general-settings-wrapper {
                                display: flex;
                                flex: 1;
                                flex-direction: row;
                                width: 80%;
                            }

                            .hq-general-settings-item-wrapper {
                                display: flex;
                                flex: 1;
                                flex-direction: column;
                                padding-right: 50px;
                            }

                            .hq-general-settings-item {
                                display: flex;
                                flex: 1;
                                flex-direction: row;
                            }

                            .hq-admin-text-input, .hq-admin-select-input {
                                height: 35px;
                                width: 100%;
                                border-radius: 5px;
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
                                justify-content: flex-start;
                            }
                            .small{
                                max-width: 100px;
                            }
                        </style>
                        <div class="hq-general-settings-section-wrapper">
                            <h3>General Settings</h3>
                            <div class="hq-general-settings-wrapper">
                                <div class="hq-general-settings-item-wrapper">
                                    <div class="hq-general-settings-item">
                                        <div class="hq-general-label-wrapper">
                                            <h4 class="wp-heading-inline" for="title">Tenant token</h4>
                                        </div>
                                        <div class="hq-general-input-wrapper">
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
                                        </div>
                                        <div class="hq-general-input-wrapper">
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
                                        <div class="hq-general-label-wrapper">
                                            <h4 class="wp-heading-inline" for="title">Select front-end date Format</h4>
                                        </div>
                                        <div class="hq-general-input-wrapper">
                                            <select class="hq-admin-select-input"
                                                    name="<?php echo esc_attr($this->settings->front_end_datetime_format); ?>">
                                                <?php echo $this->dateHelper->getHtmlOptionForFrontEndDateSettingOption(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="hq-general-settings-item">
                                        <div class="hq-general-label-wrapper">
                                            <h4 class="wp-heading-inline" for="title">Select system date format</h4>
                                        </div>
                                        <div class="hq-general-input-wrapper">
                                            <select class="hq-admin-select-input"
                                                    name="<?php echo $this->settings->hq_datetime_format; ?>">
                                                <?php echo $this->dateHelper->getHtmlOptionForSystemDateSettingOption(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="hq-general-settings-item">
                                        <div class="hq-general-label-wrapper">
                                            <h4 class="wp-heading-inline" for="title">API tenant region</h4>
                                        </div>
                                        <div class="hq-general-input-wrapper">
                                            <select class="hq-admin-select-input"
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
                            <h3>Advanced Development Settings</h3>
                            <div class="hq-general-settings-wrapper">
                                <div class="hq-general-settings-item-wrapper">
                                    <div class="hq-general-settings-item-wrapper">
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Disable safari redirect</h4>
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
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="checkbox"
                                                       name="<?php echo $this->settings->hq_integration_on_home; ?>"
                                                       value="true" <?php echo ($this->settings->getSupportForHomeIntegration() === 'true') ? 'checked' : ''; ?>/>
                                            </div>
                                        </div>
                                        <div class="hq-general-settings-item">
                                            <div class="hq-general-label-wrapper">
                                                <h4 class="wp-heading-inline" for="title">Fleet location coordinates
                                                    field id</h4>
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
                                            </div>
                                            <div class="hq-general-input-wrapper">
                                                <input type="text"
                                                       class="hq-admin-text-input small"
                                                       name="<?php echo $this->settings->hq_location_brands_field; ?>"
                                                       value="<?php echo esc_attr($this->settings->getBrandsSetting()); ?>"/>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="hq-general-settings-item-wrapper">
                                    </div>
                                </div>

                            </div>
                            <div class="hq-admin-help-section">
                                <p>Need help? Please click <strong><a target="_blank" href="https://hqrentalsoftware.com/knowledgebase_category/website-integration/">here</a></strong> for more information on how to set up the HQ Rentals plugin.</p>
                            </div>
                            <input type="submit" name="save" value="Save" class="button button-primary button-large">
                            <div class="hq-admin-warning-section">
                                <p><strong>Note:</strong> Please save your settings first, then force the update of the settings. All previous data will be lost and the webiste will be updated with the recently saved settings.
                                </p>
                            </div>
                    </form>
                </div>
            </div>
            <?php
        }
        ?>
        <style>
            .hq-admin-warning-section{
                max-width: 500px;
            }
            .hq-admin-help-section, .hq-admin-help-section{
                padding-top: 25px;
                padding-bottom: 25px;
            }
            .hq-admin-warning-section p, .hq-admin-help-section p{
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
        </style>
        <?php

    }
}