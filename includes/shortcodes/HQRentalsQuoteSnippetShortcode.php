<?php
namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;

class HQRentalsQuoteSnippetShortcode extends HQBaseShortcode {
    static $shortcodeTag = 'hq_rentals_quote_snippet';
    public function __construct()
    {
        add_shortcode(HQRentalsQuoteSnippetShortcode::$shortcodeTag, array($this, 'renderShortcode'));
    }
    public function renderShortcode( $atts )
    {
        $atts = shortcode_atts(
            array(
                'id'                =>  '1',
                'forced_locale'     =>  '',
            ), $atts);
        ob_start();
        $brand = new HQRentalsModelsBrand();
        $brand->findBySystemId($atts['id']);
        return $this->filledSnippetData($brand->getQuoteSnippet(), $atts);
    }
}
