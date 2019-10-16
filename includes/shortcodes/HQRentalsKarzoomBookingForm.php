<?php
namespace HQRentalsPlugin\HQRentalsShortcodes;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;

class HQRentalsKarzoomBookingForm
{
    public function __construct()
    {
        $this->assets = new HQRentalsAssetsHandler();
        $this->helper = new HQRentalsFrontHelper();
        add_shortcode('hq_rentals_karzoom_booking_form' , array ($this, 'shortcode'));
    }
    public function shortcode( $atts = [] )
    {
        $this->assets->loadKarzoomFormAssets();
        ?>
            <div id="hq-booking-form-karzoom"></div>
        <?php
    }
}