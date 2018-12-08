<?php

namespace HQRentalsPlugin\HQRentalsSettings;

use HQRentalsPlugin\HQRentalsHelpers\HQRentalsDatesHelper;


class HQRentalsAdminSettings
{
    protected $settingsPageTitle = 'HQ Rentals Settings';
    protected $settingsMenuTitle = 'HQ Rentals';
    protected $settingsSlug = 'hq-wordpress-settings';

    function __construct()
    {
        $this->settings = new HQRentalsSettings();
        $this->dateHelper = new HQRentalsDatesHelper();
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
        $devMode = $_GET['devmode'];
        if (!empty($_POST)) {
            if($_POST['hq_force_update'] == '1'){
                $this->settings->forceSyncOnHQData();
            }else{
                $this->settings->updateSettings($_POST);
            }
            ?>
            <div class="wrap">
                <div id="wrap">
                    <h1>Caag Software Authentication Access</h1>
                    <div class="caag-notice-wp notice caag-notice">
                        <p>Don't have an account yet? Create a new account by clicking on this link</p>
                        <a href="https://caagsoftware.com/" class="caag-button caag-button-primary caag-button-external-link" target="_blank">Register Now</a>
                    </div>
                </div>
            </div>
            <?php if($_POST['success'] == 'success'): ?>
                <div class="wrap">
                    <div class="message updated"><p>The Setting were Successfully Saved!</p></div>
                </div>
            <?php elseif($_POST['forcing_update'] == 'success'): ?>
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
                    <h1>Caag Software Authentication Access</h1>
                    <div class="caag-notice-wp notice caag-notice">
                        <p>Don't have an account yet? Create a new account by clicking on this link</p>
                        <a href="https://caagsoftware.com/"
                           class="caag-button caag-button-primary caag-button-external-link" target="_blank">Register
                            Now</a>
                    </div>
                    <form action="" method="post">
                        <table class="form-table">
                            <tbody>
                            <tr>
                                <th><label class="wp-heading-inline" id="title" for="title">Tenant Token</label></th>
                                <td><input type="text" name="<?php echo $this->settings->api_tenant_token; ?>" size="70"
                                           value="<?php echo $this->settings->getApiTenantToken(); ?>" id="title"
                                           spellcheck="true" autocomplete="off"></td>
                            </tr>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">User
                                        Token</label></th>
                                <td><input type="text" name="<?php echo $this->settings->api_user_token; ?>" size="70"
                                           value="<?php echo $this->settings->getApiUserToken(); ?>" id="title"
                                           spellcheck="true" autocomplete="off"></td>
                            </tr>
                            <tr>
                                <th><label class="wp-heading-inline" id="title-prompt-text" for="title">Select Front-end
                                        Date Format</label></th>
                                <td>
                                    <select name="<?php echo $this->settings->front_end_datetime_format; ?>">
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
                <div class="notice updated is-dismissible fw-brz-dismiss">
                    <p style="font-size:14px; font-weight: bold;">
                        Safari & Opera Browser
                    </p>
                    <p style="text-align: justify;">
                        Due to an incompatibility with Safari and Opera browsers, the domain name of the iframe has to
                        be updated.
                        You will need to add an A record in your DNS records where the value is the name of your tenant.

                    </p>
                    <p style="text-align: justify;">
                        For example if your link is rentals.caagcrm.com the value for the A record has to be “rentals”
                        and the IP address will be dependent on your installation:
                    </p>
                    <ul>
                        <li>America: 45.79.176.147</li>
                        <li>Europe: 45.77.139.237</li>
                        <li>Asia: 139.162.35.27</li>
                    </ul>
                    <p style="text-align: justify;">
                        Once you have created the A record please create a support ticket inside the HQ application so
                        our team can proceed with the installation.
                    </p>
                    <button type="button" class="notice-dismiss"><span
                                class="screen-reader-text">Dismiss this notice.</span></button>
                </div>
            </div>
            <?php if (!empty($devMode)): ?>
                <div class="">
                    <form method="post">
                        <table class="form-table">
                            <tbody>
                            <tr>
                                <th><label class="wp-heading-inline" id="title" for="title">Force Sync Update</label></th>
                                <td>
                                    <input type="hidden" value="1" name="hq_force_update"/>
                                    <input type="submit" value="Force Update" name="save" class="button button-primary button-large" >
                                </td>
                            </tr>
                            </tbody>
                        </table>
                </div>
            <?php endif; ?>
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