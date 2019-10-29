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
                        <table class="form-table">
                            <tbody>
                            <tr>
                                <th><label class="wp-heading-inline" id="title" for="title">Tenant Token</label></th>
                                <td><input type="text" name="<?php echo esc_attr($this->settings->api_tenant_token); ?>"
                                           size="70"
                                           value="<?php echo esc_attr($this->settings->getApiTenantToken()); ?>"
                                           id="title"
                                           spellcheck="true" autocomplete="off"></td>
                            </tr>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">User
                                        Token</label></th>
                                <td><input type="text" name="<?php echo esc_attr($this->settings->api_user_token); ?>"
                                           size="70"
                                           value="<?php echo esc_attr($this->settings->getApiUserToken()); ?>"
                                           id="title"
                                           spellcheck="true" autocomplete="off"></td>
                            </tr>
                            <?php if (get_site_url() == 'https://workspot.nu' or get_site_url() == 'http://workspot.test'): ?>
                                <tr>
                                    <th><label class="wp-heading-inline" id="title" for="title">Tenant Token Workspot
                                            Gebouw Tenant</label></th>
                                    <td><input type="text"
                                               name="<?php echo esc_attr($this->settings->api_tenant_token_workspot_gebouw_location); ?>"
                                               size="70"
                                               value="<?php echo esc_attr($this->settings->getApiTenantTokenForWorkspotLocation()); ?>"
                                               id="title"
                                               spellcheck="true" autocomplete="off"></td>
                                </tr>
                                <tr>
                                    <th><label class="wp-heading-inline" id="title-prompt-text" for="title">User
                                            Token Workspot Gebouw Tenant</label></th>
                                    <td><input type="text"
                                               name="<?php echo esc_attr($this->settings->api_user_token_workspot_gebouw_location); ?>"
                                               size="70"
                                               value="<?php echo esc_attr($this->settings->getApiUserTokenForWorkspotLocation()); ?>"
                                               id="title"
                                               spellcheck="true" autocomplete="off"></td>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Select Front-end
                                        Date Format</label></th>
                                <td>
                                    <select name="<?php echo esc_attr($this->settings->front_end_datetime_format); ?>">
                                        <?php echo $this->dateHelper->getHtmlOptionForFrontEndDateSettingOption(); ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Select System
                                        Date Format</label></th>
                                <td>
                                    <select name="<?php echo $this->settings->hq_datetime_format; ?>">
                                        <?php echo $this->dateHelper->getHtmlOptionForSystemDateSettingOption(); ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Support for home integration</label></th>
                                <td>
                                    <input type="checkbox"
                                           name="<?php echo $this->settings->hq_integration_on_home; ?>"
                                           value="true" <?php echo ($this->settings->getSupportForHomeIntegration() === 'true') ? 'checked' : ''; ?>/>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Disabled Sync</label></th>
                                <td>
                                    <input type="checkbox"
                                           name="<?php echo $this->settings->hq_disable_cronjob_option; ?>"
                                           value="true" <?php echo ($this->settings->getDisableCronjobOption() === 'true') ? 'checked' : ''; ?>/>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Locations Coordinate Field</label></th>
                                <td>
                                    <input type="text"
                                           name="<?php echo $this->settings->hq_location_coordinate_field; ?>"
                                           value="<?php echo esc_attr($this->settings->getLocationCoordinateField()); ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Locations Description Field</label></th>
                                <td>
                                    <input type="text"
                                           name="<?php echo $this->settings->hq_location_description_field; ?>"
                                           value="<?php echo esc_attr($this->settings->getLocationDescriptionField()); ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Locations Image Field</label></th>
                                <td>
                                    <input type="text"
                                           name="<?php echo $this->settings->hq_location_image_field; ?>"
                                           value="<?php echo esc_attr($this->settings->getLocationImageField()); ?>"/>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Disabled Safari Redirect Functionality</label></th>
                                <td>
                                    <input type="checkbox"
                                           name="<?php echo $this->settings->hq_disable_safari_functionality; ?>"
                                           value="true" <?php echo ($this->settings->getDisableSafari() === 'true') ? 'checked' : ''; ?>/>
                                </td>
                            </tr>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Select Api
                                        Region</label></th>
                                <td>
                                    <select name="<?php echo $this->settings->api_base_url; ?>">
                                        <option value="https://api.caagcrm.com/api/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api.caagcrm.com/api/') ? 'selected="selected"' : ''; ?>>
                                            America
                                        </option>
                                        <option value="https://api-america-2.caagcrm.com/api-america-2/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api-america-2.caagcrm.com/api-america-2/') ? 'selected="selected"' : ''; ?>>
                                            America 2
                                        </option>
                                        <option value="https://api-europe.caagcrm.com/api-europe/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api-europe.caagcrm.com/api-europe/') ? 'selected="selected"' : ''; ?>>
                                            Europe
                                        </option>
                                        <option value="https://api-asia.caagcrm.com/api-asia/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api-asia.caagcrm.com/api-asia/') ? 'selected="selected"' : ''; ?>>
                                            Asia
                                        </option>
                                    </select>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <input type="submit" name="save" value="Save" class="button button-primary button-large">
                    </form>
                </div>
            </div>
            <div class="">
                <form method="post">
                    <table class="form-table">
                        <tbody>
                        <tr>
                            <th><label class="wp-heading-inline" id="title" for="title">Force Sync Update</label>
                                <p style="text-align: justify;">
                                    All the previous data will be deleted
                                </p></th>
                            <td>
                                <input type="hidden" value="1" name="hq_force_update"/>
                                <input type="submit" value="Force Update" name="save"
                                       class="button button-primary button-large">

                            </td>
                        </tr>
                        </tbody>
                    </table>
            </div>
            <?php
        }
        ?>
        <style>
            .fw-brz-dismiss {
                border-left-color: #d62c64 !important;
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

            .fw-brz__btn-install:hover {
                background-color: #141923;
                color: #fff;
                border-color: #141923;
                box-shadow: 0px 2px 0px 0px #141923;
            }

            .hq-warning-woo {
                font-weight: bold;
                color: red;
            }
        </style>
        <?php

    }
}