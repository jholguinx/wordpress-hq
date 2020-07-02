<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;


class HQRentalsReservationFormSnippetShortcode extends HQBaseShortcode
{
    static $shortcodeTag = 'hq_rentals_reservation_form_snippet';

    public function __construct()
    {
        add_shortcode(HQRentalsReservationFormSnippetShortcode::$shortcodeTag, array($this, 'renderShortcode'));
    }

    public function renderShortcode($atts)
    {
        $atts = shortcode_atts(
            array(
                'id'                =>  '1',
                'forced_locale'     =>  '',
                'reservation_page'  =>  '',
                'layout'            =>  ''
            ), $atts);
        ob_start();
        $brand = new HQRentalsModelsBrand();
        $brand->findBySystemId($atts['id']);
        return $this->filledSnippetData($brand->getReservationFormSnippet(), $atts);
    }
}
