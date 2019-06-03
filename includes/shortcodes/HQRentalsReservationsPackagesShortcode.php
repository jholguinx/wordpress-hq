<?php
namespace HQRentalsPlugin\HQRentalsShortcodes;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsShortcodeHelper;

class HQRentalsReservationsPackagesShortcode
{
    public function __construct()
    {
        $this->brand = new HQRentalsModelsBrand();
        $this->helper = new HQRentalsShortcodeHelper();
        $this->assetsHelper = new HQRentalsAssetsHandler();
        add_shortcode('hq_rentals_reservation_packages' , array ($this, 'packagesShortcode'));
    }
    public function packagesShortcode( $atts = [] )
    {
        global $is_safari;
        $atts = shortcode_atts(
                array(
                    'id' => '1',
                    'forced_locale' => 'en',
                ), $atts
            );
        $langParams = '?forced_locale=' . $atts['forced_locale'];
        $this->assetsHelper->getIframeResizerAssets();
        $this->brand->findBySystemId( $atts['id'] );
        $this->helper->resolvesSafariIssue($is_safari, [], esc_url($this->brand->publicReservationPackagesFirstStepLink .  $langParams));
        return '<iframe id="hq-rentals-integration-wrapper" src="' . esc_url($this->brand->publicReservationPackagesFirstStepLink .  $langParams) . '" scrolling="no"></iframe>';
    }
}