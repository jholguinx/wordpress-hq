<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

/**
 * Class HQRentalsShortcoder
 * @package HQRentalsPlugin\HQRentalsShortcodes
 * This class its just for making the Shortcodes accesible to Wordpress
 */
class HQRentalsShortcoder
{
    public function __construct()
    {
        $this->packagesShortcode = new HQRentalsPackagesShortcode();
        $this->reservationShortcode = new HQRentalsReservationsShortcode();
        $this->systemAssetsShortcode = new HQRentalsSystemAssets();
    }
}