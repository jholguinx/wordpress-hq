<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

class HQRentalsShortcoder
{
    public function __construct()
    {
        $this->packagesShortcode = new HQRentalsPackagesShortcode();
        $this->reservationShortcode = new HQRentalsReservationsShortcode();
        $this->systemAssetsShortcode = new HQRentalsSystemAssets();
    }
}