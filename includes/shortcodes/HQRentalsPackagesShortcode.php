<?php
namespace HQRentalsPlugin\HQRentalsShortcodes;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsShortcodeHelper;

class HQRentalsPackagesShortcode
{
    public function __construct()
    {
        $this->brand = new HQRentalsModelsBrand();
        $this->shortcodeHelper = new HQRentalsShortcodeHelper();
        $this->assetsHelper = new HQRentalsAssetsHandler();
        add_shortcode('hq_rentals_packages' , array ($this, 'packagesShortcode'));
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
        $langParams = '&forced_locale=' . $atts['forced_locale'];
        $this->assetsHelper->getIframeResizerAssets();
        $this->brand->findBySystemId( $atts['id'] );
        $this->shortcodeHelper->resolvesSafariIssue($is_safari, [], esc_url( $this->brand->publicPackagesLinkFull .  $langParams ));
        return '<iframe id="hq-rentals-integration-wrapper" src="' . esc_url( $this->brand->publicPackagesLinkFull .  $langParams ) . '" scrolling="no"></iframe>';
    }
}