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
                    <div class="notice updated is-dismissible fw-brz-dismiss">
                        <p style="font-size:14px; font-weight: bold;">
                            Safari & Opera Browser
                        </p>
                        <p style="text-align: justify;">
                            Due to an incompatibility with Safari and Opera browsers, the domain name of the iframe has
                            to
                            be updated.
                            You will need to add an A record in your DNS records where the value is the name of your
                            tenant.

                        </p>
                        <p style="text-align: justify;">
                            For example if your link is rentals.caagcrm.com the value for the A record has to be
                            “rentals”
                            and the IP address will be dependent on your installation:
                        </p>
                        <ul>
                            <li>America: 45.79.176.147</li>
                            <li>Europe: 45.77.139.237</li>
                            <li>Asia: 139.162.35.27</li>
                        </ul>
                        <p style="text-align: justify;">
                            Once you have created the A record please create a support ticket inside the HQ application
                            so
                            our team can proceed with the installation.
                        </p>
                        <button type="button" class="notice-dismiss"><span
                                    class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>
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
                                               name="<?php echo esc_url($this->settings->api_user_token_workspot_gebouw_location); ?>"
                                               size="70"
                                               value="<?php echo esc_url($this->settings->getApiUserTokenForWorkspotLocation()); ?>"
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
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Support for
                                        minified response</label></th>
                                <td>
                                    <input type="checkbox"
                                           name="<?php echo $this->settings->support_for_minified_response_on_vehicle_classes; ?>"
                                           value="true" <?php echo ($this->settings->getSupportForMinifiedResponse() === 'true') ? 'checked' : ''; ?>/>
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
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Select Api
                                        Region</label></th>
                                <td>
                                    <select name="<?php echo $this->settings->api_base_url; ?>">
                                        <option value="https://api.caagcrm.com/api/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api.caagcrm.com/api/') ? 'selected="selected"' : ''; ?>>
                                            America
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