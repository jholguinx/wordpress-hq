<?php
namespace HQRentalsPlugin\HQRentalsShortcodes;

class HQRentalsFormLink
{
    public function __construct()
    {
            add_shortcode('hq_rentals_form_link' , array ($this, 'packagesShortcode'));
    }
    public function packagesShortcode( $atts = [] )
    {
        $atts = shortcode_atts(
                array(
                    'link' => '',
                ), $atts
            );
        $langParams = '&forced_locale=' . $atts['forced_locale'];
        wp_enqueue_style('hq-wordpress-styles');
        wp_enqueue_script('hq-iframe-resizer-script');
        wp_enqueue_script('hq-resize-script');
        return '<iframe id="hq-rentals-integration-wrapper" src="' . $this->brand->publicPackagesLinkFull .  $langParams . '" scrolling="no"></iframe>';
    }
}