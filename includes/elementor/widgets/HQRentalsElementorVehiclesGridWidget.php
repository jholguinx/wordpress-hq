<?php

use HQRentalsPlugin\HQRentalsShortcodes\HQRentalsVehicleGrid;

class HQRentalsElementorVehiclesGridWidget extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $this->linkURL = '';
    }

    public function get_name()
    {
        return 'Vehicles Grid';
    }

    public function get_title()
    {
        return __('Vehicles Grid', 'hq-wordpress');
    }

    public function get_icon()
    {
        return 'fas fa-grip-horizontal';
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

        $this->add_control(
            'url',
            [
                'label' => __('Reservations URL', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
            ]
        );
        $this->add_control(
            'title',
            [
                'label' => __('Title', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
            ]
        );
        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $shortcode = new HQRentalsVehicleGrid($settings);
        $shortcode->renderShortcode();
    }

}

