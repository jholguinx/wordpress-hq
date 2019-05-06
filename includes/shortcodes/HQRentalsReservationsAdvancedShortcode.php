<?php


namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsDatesHelper;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueryStringHelper;


class HQRentalsReservationsAdvancedShortcode
{
    public function __construct()
    {
        $this->settings = new HQRentalsSettings();
        $this->dateHelper = new HQRentalsDatesHelper();
        $this->queryHelper = new HQRentalsQueryStringHelper();
        $this->assets = new HQRentalsAssetsHandler();
        $this->frontHelper = new HQRentalsFrontHelper();
        add_shortcode('hq_rentals_reservations_advanced', array($this, 'reservationsAdvancedShortcode'));
    }
    public function reservationsAdvancedShortcode( $atts = [])
    {
        $atts = shortcode_atts(
            array(
                'id' => '1',
                'forced_locale' => 'en',
                'new' => 'true',
            )
            , $atts, 'hq_rentals_reservations_advanced');
        $post_data = $_POST;
        $post_data = $this->frontHelper->sanitizeTextInputs($post_data);
        $brand = HQRentalsModelsBrand::getBrandById($atts['id']);
        ?>
            <iframe id="hq-iframe" src="<?php esc_url($atts['reservation_advanced_url'] . '?' . http_build_query($post_data) ); ?>" scrolling="no"></iframe>
        <?php
        $this->assets->getIframeResizerAssets();
    }
}