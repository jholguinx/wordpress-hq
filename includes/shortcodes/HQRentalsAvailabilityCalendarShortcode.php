<?php
namespace HQRentalsPlugin\HQRentalsShortcodes;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;


class HQRentalsAvailabilityCalendarShortcode
{
    public function __construct()
    {
        $this->assets = new HQRentalsAssetsHandler();
        $this->brand = new HQRentalsModelsBrand();
        add_shortcode('hq_rentals_vehicle_calendar', array( $this, 'calendarShortcode' ));
    }

    public function calendarShortcode( $atts = [] )
    {
        wp_enqueue_style('hq-wordpress-iframe-styles');
        wp_enqueue_script('hq-iframe-resizer-script');
        wp_enqueue_script('hq-resize-script');
        $atts = shortcode_atts(
                array(
                    'id'                =>  '1',
                    'forced_locale'     =>  'en',
                    'vehicle_class_id'  =>  ''
                ), $atts
            );
        $this->brand->findBySystemId($atts['id']);
        $url = $this->brand->publicCalendarLink;
        $lang = '&forced_locale=' . $atts['forced_locale'];
        $vehicle_class = (empty($atts['vehicle_class_id'])) ? '' : '&vehicle_class_id=' . $atts['vehicle_class_id'];
        return '<iframe id="hq-rental-iframe" src="' . $url . $lang . $vehicle_class . '" scrolling="no"></iframe>';
    }
}