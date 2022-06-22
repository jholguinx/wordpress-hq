<?php
use \HQRentalsPlugin\HQRentalsShortcodes\HQRentalsPlacesReservationForm;

class HQRentalsElementorPlacesReservationForm extends \Elementor\Widget_Base
{
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);
        $this->linkURL = '';
    }

    public function get_name()
    {
        return 'Places Reservation Form';
    }

    public function get_title()
    {
        return __('Places Form', 'hq-wordpress');
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
        $this->add_control(
            'reservation_url_places_form',
            [
                'label' => __('Reservations URL', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
            ]
        );

        $this->add_control(
            'orientation_places_form',
            [
                'label' => __('Orientation', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => [
                    'horizontal'  => __( 'Horizontal', 'hq-wordpress' ),
                    'vertical' => __( 'Vertical', 'hq-wordpress' ),
                ],
            ]
        );
        $this->add_control(
            'support_for_custom_location',
            [
                'label' => __('Support for Custom Location', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'true',
            ]
        );
        $this->add_control(
            'custom_location_label',
            [
                'label' => __('Label for Custom Location', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
            ]
        );
        $this->add_control(
            'minimum_rental_period',
            [
                'label' => __('Label for Custom Location', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'default' => '1'
            ]
        );
        $this->add_control(
            'google_country',
            [
                'label' => __('Label for Custom Location', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'default' => 'us'
            ]
        );
        $this->add_control(
            'google_map_center',
            [
                'label' => __('Label for Custom Location', 'hq-wordpress'),
                'description' => __('lat,lon', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'default' => 'us'
            ]
        );
        $this->add_control(
            'google_map_center_radius',
            [
                'label' => __('Label for Custom Location', 'hq-wordpress'),
                'description' => __('Degrees', 'hq-wordpress'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'input_type' => 'string',
                'default' => 'us'
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $shortcode = new HQRentalsPlacesReservationForm($settings);
        echo $shortcode->renderShortcode();
    }
}

