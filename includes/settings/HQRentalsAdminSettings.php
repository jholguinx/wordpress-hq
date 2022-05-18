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
            $this->settings->updateSettings($_POST);
            ?>
            <?php if (isset($_POST['success']) && $_POST['success'] == 'success'): ?>
                <div class="wrap">
                    <div class="message updated"><p>The settings were saved successfully.</p></div>
                </div>
            <?php elseif (isset($_POST['success']) && $_POST['success'] == 'error'): ?>
                <div class="wrap">
                    <div class="notice notice-error"><p>Error Processing the
                            information: <?php echo $_POST['error_message']; ?></p></div>
                </div>
            <?php else: ?>
                <div class="wrap">
                    <div class="message updated"><p>There was an issue with your request.</p></div>
                </div>
            <?php endif; ?>
            <?php
        } else {
            $this->assets->loadAssetsForAdminSettingPage();
            $okAPI = $this->settings->isApiOkay();
            HQRentalsAssetsHandler::getHQFontAwesome();
            ?>
            <script>
                var loginActive = <?php echo ($okAPI) ? 'true' : 'false'; ?>;
                var hqWebsiteURL = "<?php echo home_url(); ?>"
            </script>
            <style>
                .hq-normal-wrapper{
                    display: block !important;
                    max-width: 600px;
                }
            </style>
            <div class="wrap">
                <div id="wrap">
                    <div class="hq-title-wrapper">
                        <div class="hq-title-item">
                            <h1 class="hq-admin-h1">HQ Rentals Setup</h1>
                        </div>
                    </div>

                    <form action="" method="post">
                        <div class="hq-general-settings-section-wrapper">
                            <div style="max-width: 800px; display: flex; flex-direction: row; justify-content: flex-start; align-items: center">
                                <div>
                                    <h3 class="hq-admin-h3">General Settings</h3>
                                </div>
                                <div>
                                    <?php if ( !isset($_GET['dev']) and empty($_GET['dev'])): ?>
                                        <button id="hq-login-toogle-button" class="hq-admin-toggle-button" type="button"
                                                aria-expanded="true">
                                            <i id="hq-login-button-icon"
                                               class="fas <?php echo ($okAPI) ? 'fa-angle-down' : 'fa-angle-right'; ?>"
                                               aria-hidden="true"></i>
                                        </button>
                                    <?php endif; ?>
                                    <?php if ($okAPI): ?>
                                        <style>
                                            .hq-login-wrapper {
                                                display: none;
                                            }
                                        </style>
                                    <?php endif; ?>
                                </div>
                                <?php if ($okAPI): ?>
                                    <div id="hq-connected-indicator"
                                         style="background-color: #28a745; border: 2px solid #28a745;"
                                         class="hq-connected-sign">
                                        <h6 class="hq-connected-sign-text">CONNECTED</h6>
                                    </div>
                                <?php else: ?>
                                    <div id="hq-not-connected-indicator"
                                         style="background-color: #dc3545; border: 2px solid #dc3545;"
                                         class="hq-connected-sign">
                                        <h6 class="hq-connected-sign-text">NOT CONNECTED</h6>
                                    </div>
                                    <div id="hq-connected-indicator"
                                         style="background-color: #28a745; border: 2px solid #28a745;"
                                         class="hq-connected-sign">
                                        <h6 class="hq-connected-sign-text">CONNECTED</h6>
                                    </div>
                                    <style>
                                        #hq-connected-indicator {
                                            display: none;
                                        }
                                    </style>
                                <?php endif; ?>
                            </div>
                            <div class="hq-general-settings-wrapper">
                                <div class="hq-general-settings-item-wrapper hq-tokens-rows <?php echo empty($_GET['dev']) ? 'hq-normal-wrapper' : ''; ?>">
                                    <?php if (isset($_GET['dev']) and $_GET['dev']): ?>
                                        <style>
                                            .hq-dev{
                                                flex: 1;
                                                display: flex;
                                                flex-direction: column;
                                                margin-right: 40px;
                                            }
                                        </style>
                                    <div style="display: flex; flex-direction: row; width: 100%;">
                                        <div class="hq-dev">
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">Tenant token</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="Log in to your HQ account and navigate to settings > settings > integrations > copy the API token and paste it here."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper tokens">
                                                    <input class="hq-admin-text-input"
                                                           type="text"
                                                           name="<?php echo esc_attr($this->settings->api_tenant_token); ?>"
                                                           value="<?php echo esc_attr($this->settings->getApiTenantToken()); ?>"
                                                           id="hq-api-tenant-token"
                                                           spellcheck="true" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">User token</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="Log in to your HQ account and navigate to settings > user management > users > integrations > select your user profile > generate and copy the API token and paste it here."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper tokens">
                                                    <input class="hq-admin-text-input"
                                                           type="text"
                                                           name="<?php echo esc_attr($this->settings->api_user_token); ?>"
                                                           value="<?php echo esc_attr($this->settings->getApiUserToken()); ?>"
                                                           id="hq-api-user-token"
                                                           spellcheck="true" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hq-dev">
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper hq-dates">
                                                    <h4 class="wp-heading-inline" for="title">Select front-end date
                                                        format</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content=" This is the format of the dates on your website, and this must match the system date format."></span>
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
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This is the date format set up on your HQ account settings. You can find this under general settings."></span>
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
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="<span>For xxx.caagcrm.com, your region is America</span>
                                                                        <p>For xxx.hqrentals.app, your region is in America 2</p>
                                                                        <p>For xxx.west.hqrentals.app, your region is in America West</p>
                                                                        <p>For xxx.hqrentals.eu, your region is Europe</p>
                                                                        <p>For xxx.hqrentals.asia, your region is Asia</p>"></span>
                                                </div>
                                                <div class="hq-general-input-wrapper hq-dates-input">
                                                    <select
                                                            id="hq-api-user-base-url"
                                                            class="hq-admin-select-input "
                                                            name="<?php echo esc_attr($this->settings->api_base_url); ?>">
                                                        <option value="https://api.caagcrm.com/api/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api.caagcrm.com/api/') ? 'selected="selected"' : ''; ?>>
                                                            America
                                                        </option>
                                                        <option value="https://api-america-2.caagcrm.com/api-america-2/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api-america-2.caagcrm.com/api-america-2/') ? 'selected="selected"' : ''; ?>>
                                                            America 2
                                                        </option>
                                                        <option value="https://api-america-3.caagcrm.com/api-america-3/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api-america-3.caagcrm.com/api-america-3/') ? 'selected="selected"' : ''; ?>>
                                                            America 3
                                                        </option>
                                                        <option value="https://api-america-west.caagcrm.com/api-america-west/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api-america-west.caagcrm.com/api-america-west/') ? 'selected="selected"' : ''; ?>>
                                                            America West
                                                        </option>
                                                        <option value="https://api-america-miami.caagcrm.com/api-america-miami/" <?php echo ($this->settings->getApiBaseUrl() == 'https://api-america-miami.caagcrm.com/api-america-miami/') ? 'selected="selected"' : ''; ?>>
                                                            America Miami
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
                                    <?php else: ?>
                                        <div class="hq-login-wrapper">
                                            <div id="hq-login-form-wrapper">
                                                <div class="hq-general-settings-item">
                                                    <div class="hq-general-label-wrapper">
                                                        <h4 class="wp-heading-inline" for="title">Email</h4>
                                                    </div>
                                                    <div class="hq-general-input-wrapper tokens">
                                                        <input class="hq-admin-text-input"
                                                               type="text"
                                                               name="hq-email"
                                                               id="hq-email"
                                                               spellcheck="true" autocomplete="off"
                                                               value="<?php echo esc_attr($this->settings->getEmail()); ?>"
                                                        >
                                                    </div>
                                                </div>
                                                <div class="hq-general-settings-item">
                                                    <div class="hq-general-label-wrapper">
                                                        <h4 class="wp-heading-inline" for="title">Password</h4>
                                                    </div>
                                                    <div class="hq-general-input-wrapper tokens">
                                                        <input
                                                                class="hq-admin-text-input"
                                                                type="password"
                                                                name="hq-password"
                                                                id="hq-password"
                                                                spellcheck="true" autocomplete="off"/>
                                                    </div>
                                                </div>
                                                <div class="hq-loader">
                                                    <div class="hq-loader-inner-wrapper">
                                                        <img src="<?php echo plugins_url('hq-rental-software/includes/assets/img/spinner.gif'); ?>"
                                                             alt="">
                                                    </div>
                                                </div>
                                                <div class="hq-messages-box-failed">
                                                    <div class="alert alert-danger" role="alert">
                                                        There was an issue, please review your login information.
                                                    </div>
                                                </div>
                                                <div class="hq-submit-login-button-wrapper">
                                                    <button id="hq-submit-login-button" type="button" name="save"
                                                            value="Save" class="button button-primary button-large">
                                                        AUTHENTICATE
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden"
                                               name="<?php echo esc_attr($this->settings->api_tenant_token); ?>"
                                               value="<?php echo esc_attr($this->settings->getApiTenantToken()); ?>"
                                               id="hq-api-tenant-token">
                                        <input type="hidden"
                                               name="<?php echo esc_attr($this->settings->api_user_token); ?>"
                                               value="<?php echo esc_attr($this->settings->getApiUserToken()); ?>"
                                               id="hq-api-user-token">

                                        <input
                                                type="hidden"
                                                name="<?php echo esc_attr($this->settings->api_base_url); ?>"
                                                value="<?php echo esc_attr($this->settings->getApiBaseUrl()); ?>"
                                                id="hq-api-user-base-url"
                                                spellcheck="true" autocomplete="off">
                                    <?php endif; ?>
                                    <div class="hq-messages-box-success">
                                        <div class="alert alert-success" role="alert">
                                            The plugin has been successfully setup.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hq-advanced-feature-section-wrapper">
                            <div>
                                <h3 class="hq-admin-h3">Advanced Development Settings</h3>
                            </div>
                            <div>
                                <button id="hq-advanced-features-toogle-button" type="button"
                                        class="hq-admin-toggle-button" aria-expanded="true">
                                    <i id="hq-advanced-button-icon" class="fas fa-angle-down"></i>
                                </button>
                            </div>
                        </div>
                        <div class="hq-advanced-section">
                            <style>
                                .hq-advanced-section {
                                    display: none;
                                }
                                .hq-text-items-wrappers{
                                    flex:1;
                                }
                            </style>
                            <div class="hq-general-settings-wrapper">
                                <div class="hq-general-settings-item-wrapper">
                                    <div class="hq-general-settings-item-wrapper hq-flex-box-container">
                                        <div class="hq-text-items-wrappers">
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">Disable safari redirect</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This will disable the redirection to the public reservation link of your HQ account for users using a Safari browser. You will need to update CNAME record for compatibility"></span>
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
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="Support for reservations iframe on the home page  - this should be applied in case that you are placing the reservation process on the home page."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="checkbox"
                                                           name="<?php echo $this->settings->hq_integration_on_home; ?>"
                                                           value="true" <?php echo ($this->settings->getSupportForHomeIntegration() === 'true') ? 'checked' : ''; ?>/>
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">Disable Data
                                                        Synchronization</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="Select this option to stop data sychronization between HQ Rental Software and the website."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="checkbox"
                                                           name="<?php echo $this->settings->hq_disable_cronjob_option; ?>"
                                                           value="true" <?php echo ($this->settings->getDisableCronjobOption() === 'true') ? 'checked' : ''; ?>/>
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">Enable change of branch
                                                        url</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This option will enable you to change the base url for the public links of the reservation process."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="checkbox"
                                                           name="<?php echo $this->settings->hq_replace_url_on_brand_option; ?>"
                                                           value="true" <?php echo ($this->settings->getReplaceBaseURLOnBrandsSetting() === 'true') ? 'checked' : ''; ?>/>
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">ORDER VEHICLE CLASSES ON
                                                        WIDGET WITH RATES FROM HIGHEST TO LOWEST</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This option will display the vehicles with rates in the vehicle widget from highest to lowest instead of the default ascending order."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="checkbox"
                                                           name="<?php echo $this->settings->hq_enable_decreasing_rate_order_on_vehicles_query; ?>"
                                                           value="true" <?php echo ($this->settings->getDecreasingRateOrder() === 'true') ? 'checked' : ''; ?> />
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">ENABLE CUSTOM POSTS PAGES</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This option will enable Vehicle Classes single pages on your website."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="checkbox"
                                                           name="<?php echo $this->settings->hq_enable_custom_post_pages; ?>"
                                                           value="true" <?php echo ($this->settings->getEnableCustomPostsPages() === 'true') ? 'checked' : ''; ?> />
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">OVERRIDE DAILY RATE WITH PRICE INTERVALS</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This option will force the plugin to display price intervals intead of the daily rate."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="checkbox"
                                                           name="<?php echo $this->settings->hq_override_daily_rate_with_price_interval; ?>"
                                                           value="true" <?php echo ($this->settings->getOverrideDailyRateWithCheapestPriceInterval() === 'true') ? 'checked' : ''; ?> />
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">DEFAULT CURRENCY DISPLAY</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This will be the currency the displayed by default on the vehicle class grid, and the dedicated vehicle class pages."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="text"
                                                           class="hq-admin-text-input small"
                                                           name="<?php echo $this->settings->hq_currency_symbol; ?>"
                                                           value="<?php echo esc_attr($this->settings->getCurrencyIconOption()); ?>"/>
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">Fleet location coordinates
                                                        field id</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
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
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
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
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="text"
                                                           class="hq-admin-text-input small"
                                                           name="<?php echo $this->settings->hq_location_description_field; ?>"
                                                           value="<?php echo esc_attr($this->settings->getLocationDescriptionField()); ?>"/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="hq-text-items-wrappers">
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">Fleet location address field
                                                        id</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
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
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
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
                                                    <h4 class="wp-heading-inline" for="title">Fleet location address field
                                                        id</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="text"
                                                           class="hq-admin-text-input small"
                                                           name="<?php echo $this->settings->hq_location_address_field; ?>"
                                                           value="<?php echo esc_attr($this->settings->getAddressSetting()); ?>"/>
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">Fleet location phone number
                                                        field id</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="text"
                                                           class="hq-admin-text-input small"
                                                           name="<?php echo $this->settings->hq_location_phone_field; ?>"
                                                           value="<?php echo esc_attr($this->settings->getPhoneSetting()); ?>"/>
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">Fleet location vehicle brands
                                                        field id</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This is the id of the custom field added to the locations form. Please navigate to settings > items > fields > search for the custom field you added and paste the number under DB column here."></span>
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
                                                    <h4 class="wp-heading-inline" for="title">Default latitude for Map
                                                        Shortcode</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="Place here the latitude of the location you would like for the map to set focus on in case the user denies location access."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="text"
                                                           class="hq-admin-text-input hq-admin-text-input-small-medium small"
                                                           name="<?php echo $this->settings->hq_default_latitude_for_map_shortcode; ?>"
                                                           value="<?php echo esc_attr($this->settings->getDefaultLatitudeSetting()); ?>"/>
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">Default longitude for Map
                                                        Shortcode</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="Place here the longitude of the location you would like for the map to set focus on in case the user denies location access."></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="text"
                                                           class="hq-admin-text-input hq-admin-text-input-small-medium small"
                                                           name="<?php echo $this->settings->hq_default_longitude_for_map_shortcode; ?>"
                                                           value="<?php echo esc_attr($this->settings->getDefaultLongitudeSetting()); ?>"/>
                                                </div>
                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">Domain to replace in the
                                                        public reservation process</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="This domain will be used to replace the system url in public reservation processes"></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="text"
                                                           class="hq-admin-text-input hq-admin-text-input-medium small"
                                                           name="<?php echo $this->settings->hq_url_to_replace_on_brands_option; ?>"
                                                           value="<?php echo esc_attr($this->settings->getBrandURLToReplaceSetting()); ?>"/>
                                                </div>

                                            </div>
                                            <div class="hq-general-settings-item">
                                                <div class="hq-general-label-wrapper">
                                                    <h4 class="wp-heading-inline" for="title">Google API Key</h4>
                                                    <span id="hq-tooltip-tenant-token" class="dashicons dashicons-search"
                                                          data-tippy-content="Google Services API Key"></span>
                                                </div>
                                                <div class="hq-general-input-wrapper">
                                                    <input type="text"
                                                           class="hq-admin-text-input hq-admin-text-input-medium medium large"
                                                           name="<?php echo $this->settings->hq_google_api_key; ?>"
                                                           value="<?php echo esc_attr($this->settings->getGoogleAPIKey()); ?>"/>
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="hq-admin-help-section">
                                <input style="max-width: 100px;" type="submit"
                                       name="save" value="Refresh Data"
                                       class="button button-primary button-large hq-admin-submit-button">
                                <p style="margin-left: 20px;">Need help? Please click <strong><a target="_blank"
                                                                 href="https://hqrentalsoftware.com/knowledgebase/wordpress-plugin/ ">here</a></strong> for
                                    more information on how to set up the HQ Rentals plugin.</p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php
        }
    }
}
