<?php

namespace HQRentalsPlugin\HQRentalsBootstrap;

use HQRentalsPlugin\HQRentalsActions\HQRentalsActionsRedirects;
use HQRentalsPlugin\HQRentalsActions\HQRentalsAjaxHandler;
use HQRentalsPlugin\HQRentalsAdmin\HQRentalsAdminBrandsPosts;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsCronJob;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsShortcodes\HQRentalsShortcoder;
use HQRentalsPlugin\HQRentalsCustomPosts\HQRentalsCustomPostsHandler;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsAdminSettings;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesAries;
use HQRentalsPlugin\HQRentalsThemes\HQRentalsBethemeShortcoder;
use HQRentalsPlugin\Webhooks\HQRentalsWebhooksManager;
use HQRentalsPlugin\Webhooks\HQRentalsWebsiteEndpoints;
use HQRentalsPlugin\HQRentalsTemplates\HQRentalsTemplateHandler;

class HQRentalsBootstrapPlugin
{
    /**
     * HQRentalsBootstrapPlugin constructor.
     * Review menus Later on
     */
    public function __construct()
    {
        $this->worker = new HQRentalsCronJob();
        $this->assets = new HQRentalsAssetsHandler();
        $this->brandPostAdmin = new HQRentalsAdminBrandsPosts();
        $this->shortcoder = new HQRentalsShortcoder();
        $this->shortcoderBetheme = new HQRentalsBethemeShortcoder();
        $this->webhooks = new HQRentalsWebhooksManager();
        $this->api = new HQRentalsWebsiteEndpoints();
        $this->posts = new HQRentalsCustomPostsHandler();
        $this->settingsAdmin = new HQRentalsAdminSettings();
        $this->ariesQueries = new HQRentalsQueriesAries();
        $this->actions = new HQRentalsActionsRedirects();
        $this->templates = new HQRentalsTemplateHandler();
        $this->ajaxHandler = new HQRentalsAjaxHandler();
    }
}
