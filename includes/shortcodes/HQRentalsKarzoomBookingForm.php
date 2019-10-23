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
        $atts = shortcode_atts(
            array(
                'background_url'   => ' ',
            ), $atts
        );
        wp_localize_script('hq-karzoom-form-script', 'HQMapShortcodeBackground', $atts['background_url'] );
        ?>
            <div id="hq-booking-form-karzoom"></div>
        <?php
    }
}