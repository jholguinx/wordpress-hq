<?php

namespace HQRentalsPlugin\HQRentalsBootstrap;

use HQRentalsPlugin\HQRentalsAdmin\HQRentalsAdminBrandsPosts;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsCronJob;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsShortcodes\HQRentalsShortcoder;
use HQRentalsPlugin\HQRentalsCustomPosts\HQRentalsCustomPostsHandler;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsAdminSettings;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesAries;
use HQRentalsPlugin\Webhooks\HQRentalsWebhooksManager;

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
        $this->webhooks = new HQRentalsWebhooksManager();
        $this->posts = new HQRentalsCustomPostsHandler();
        $this->settingsAdmin = new HQRentalsAdminSettings();
        $this->ariesQueries = new HQRentalsQueriesAries();
    }
}