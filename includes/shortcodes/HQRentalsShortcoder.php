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
        $this->reservationShortcode = new HQRentalsReservationsShortcode();
        $this->packagesShortcode = new HQRentalsPackagesShortcode();
        $this->reservationPackages = new HQRentalsReservationsPackagesShortcode();
        $this->myReservations = new HQRentalsMyReservationsShortcode();
        $this->myPackagesReservations = new HQRentalsMyPackagesReservationsShortcode();
        $this->formLink = new HQRentalsFormLink();
        $this->systemAssetsShortcode = new HQRentalsSystemAssets();
    }
}