<?php

use \HQRentalsPlugin\HQRentalsShortcodes\HQRentalsReservationFormSnippetShortcode;
use \HQRentalsPlugin\HQRentalsShortcodes\HQRentalsReservationFormByVehicleType;
class HQRentalsElementorReservationFormByVehicleType extends \Elementor\Widget_Base
{
    private $query;
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
    }

    public function get_name()
    {
        return 'Reservation Form - Vehicle Type';
    }

    public function get_title()
    {
        return __('Reservation Form - Vehicle Type', 'hq-wordpress');
    }

    public function get_icon()
    {
        return 'eicon-product-categories';
    }

    public function get_categories()
    {
        return ['hq-rental-software'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Content', 'hq-wordpress'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $shortcode = new HQRentalsReservationFormByVehicleType();
        echo $shortcode->renderShortcode($settings);
    }

}

