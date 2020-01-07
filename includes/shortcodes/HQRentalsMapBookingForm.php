<?php
namespace HQRentalsPlugin\HQRentalsShortcodes;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;

class HQRentalsMapBookingForm
{
    public function __construct()
    {
        $this->assets = new HQRentalsAssetsHandler();
        $this->helper = new HQRentalsFrontHelper();
        add_shortcode('hq_rentals_map_booking_form' , array ($this, 'shortcode'));
    }
    public function shortcode( $atts = [] )
    {
        $this->assets->loadMapFormAssets();
        $atts = shortcode_atts(
            array(
                'background_url'   => '',
            ), $atts
        );
        $dataToJS = array(
            'backgroundImageURL'    => $atts['background_url'],
            'baseURL'               =>  get_site_url() . '/'
        );
        wp_localize_script('hq-map-form-script', 'HQMapFormShortcode', $dataToJS );
        ?>
            <div id="hq-map-booking-form"></div>
        <?php
    }
}
