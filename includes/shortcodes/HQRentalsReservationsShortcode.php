<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;


use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;
class HQRentalsReservationsShortcode
{
    public function __construct()
    {
        add_shortcode('hq_rentals_reservations', array( $this, 'reservationsShortcode' ) );
    }


    public function reservationsShortcode( $atts = [] )
    {
        $brand = new HQRentalsModelsBrand( $atts['id'] );
        var_dump($brand);
        die();
    }
}