<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;

class HQRentalsReservationsSnippetShortcode extends HQBaseShortcode
{
    static $shortcodeTag = 'hq_rentals_reservations_snippet';

    public function __construct()
    {
        add_shortcode(HQRentalsReservationsSnippetShortcode::$shortcodeTag, array($this, 'renderShortcode'));
    }

    public function renderShortcode($atts)
    {
        $atts = shortcode_atts(
            array(
                'id' => '1',
                'forced_locale' => '',
            ), $atts);
        ob_start();
        $brand = new HQRentalsModelsBrand();
        $brand->findBySystemId($atts['id']);
        return $this->filledSnippetData($brand->getReservationSnippet(), $atts);
    }
}
