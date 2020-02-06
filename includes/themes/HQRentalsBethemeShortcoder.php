<?php

namespace HQRentalsPlugin\HQRentalsThemes;

class HQRentalsBethemeShortcoder{

    public function __construct()
    {
        $this->vehicleCarousel = new HQRentalsBethemeVehicleGridShortcode();
    }

}
