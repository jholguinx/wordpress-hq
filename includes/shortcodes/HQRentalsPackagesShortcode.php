<?php
namespace HQRentalsPlugin\HQRentalsShortcodes;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;

class HQRentalsPackagesShortcode
{
    public function __construct()
    {
        $this->brand = new HQRentalsModelsBrand();
            add_shortcode('hq_rentals_packages' , array ($this, 'packagesShortcode'));
    }
    public function packagesShortcode( $atts = [] )
    {
        $atts = shortcode_atts(
                array(
                    'id' => '1',
                    'forced_locale' => 'en',
                ), $atts
            );
        $langParams = '?forced_locale=' . $atts['forced_locale'];
        wp_enqueue_style('hq-wordpress-styles');
        wp_enqueue_script('hq-iframe-resizer-script');
        wp_enqueue_script('hq-resize-script');
        $this->brand->findBySystemId( $atts['id'] );
        return '<iframe id="hq-rentals-integration-wrapper" src="' . $this->brand->publicPackagesLinkFull .  $langParams . '" scrolling="no"></iframe>';
    }
}