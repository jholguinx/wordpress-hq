<?php

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;

new HQRentalBakeryWheelsberryReservationFormShortcode();


class HQRentalBakeryWheelsberryReservationFormShortcode extends WPBakeryShortCode
{
    private $title;
    private $button_text;
    private $reservation_url;

    public function __construct()
    {
        global $post;
        add_action('vc_before_init', array($this, 'setParams'));
        add_shortcode('hq_bakery_wheelsberry_reservation_form', array($this, 'content'));
        $this->queryVehicles = new HQRentalsDBQueriesVehicleClasses();
        $this->queryLocations = new HQRentalsDBQueriesLocations();
        $this->assets = new HQRentalsAssetsHandler();
        $this->helper = new HQRentalsFrontHelper();
        $this->post = $post;
    }

    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title' => esc_html__('Book Now', 'wheelsberry'),
            'button_text' => esc_html__('Continue Booking', 'wheelsberry'),
            'reservation_url' => '/reservations/',
        ), $atts));
        $this->title = empty($atts['title']) ?? '';
        $this->button_text = empty($atts['button_text']) ?? '';
        $this->reservation_url = empty($atts['reservation_url']) ?? '';
        echo $this->renderShortcode();
    }

    public function setParams()
    {
        vc_map(
            array(
                'name' => __('HQRS Rentit Reservation Form', 'hq-wordpress'),
                'base' => 'hq_bakery_rentit_reservation_form',
                'content_element' => true,
                "category" => __('HQ Rental Software - Rentit Theme'),
                'show_settings_on_create' => true,
                'description' => __('HQ Rentit Reservation Form', 'hq-wordpress'),
                'icon' => HQRentalsAssetsHandler::getHQLogo(),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Enter the Slider Title', 'hq-wordpress'),
                        'param_name' => 'title',
                        'value' => '',
                        'description' => esc_html__('Enter the Slider Title', 'hq-wordpress')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Enter the Slider Subtitle', 'hq-wordpress'),
                        'param_name' => 'sub_title',
                        'value' => '',
                        'description' => esc_html__('Enter the Slider Subtitle', 'hq-wordpress')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Form Title', 'hq-wordpress'),
                        'param_name' => 'form_title',
                        'value' => '',
                        'description' => esc_html__('Enter the Form Title', 'hq-wordpress')
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => esc_html__('Backgroung Image', 'hq-wordpress'),
                        'param_name' => 'background_image',
                        'value' => '',
                        'description' => esc_html__('Backgroung Image', 'hq-wordpress')
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => esc_html__('Reservation URL', 'hq-wordpress'),
                        'param_name' => 'reservation_url',
                        'value' => '',
                        'description' => esc_html__('Enter Reservation Page Url', 'hq-wordpress')
                    ),
                )
            )
        );
    }

    public function renderShortcode()
    {
        global $post;
        wp_enqueue_style('select2');
        wp_enqueue_script('select2');
        wp_enqueue_script('jquery-ui-datepicker');
        $vehicle_classes = $this->queryVehicles->allVehicleClasses();
        $locations = $this->queryLocations->allLocations();
        wp_enqueue_style('owl-carousel');
        wp_enqueue_script('owl-carousel');
        $slider_title = get_post_meta($post->ID, 'wheelsberry_cars_slider_title', true);
        $slider_subtitle = get_post_meta($post->ID, 'wheelsberry_cars_slider_subtitle', true);
        $form_title = get_post_meta($post->ID, 'wheelsberry_reservation_form_title', true);
        $form_subtitle = get_post_meta($post->ID, 'wheelsberry_reservation_form_subtitle', true);
        $time_from = intval(get_option('omcr_booking_time_from'));
        $time_to = intval(get_option('omcr_booking_time_to'));
        if (!$time_to) {
            $time_to = 85500;
        }
        $time_default = get_option('omcr_booking_time_default');
        if ($time_default === false) {
            $time_default = 43200;
        }
        $html = HQRentalsAssetsHandler::getHQFontAwesome() . "
            <style>
                .cars-slider__hq-feature-icon{
                    display: inline-block;
                    position: relative;
                    width: 44px;
                    height: 44px;
                    text-align: center;
                    line-height: 40px !important;
                    border-radius: 50%;
                    font-size: 25px;
                    background-color: grey;
                    color: #fff;
                    margin-right: 10px;    
                }
                .hq-wheelsberry-image-wrapper{
                    width: 45%;
                }
                @media only screen and (max-width: 519px){
                    .hq-wheelsberry-image-wrapper{
                       width: 100%;
                    }
                }
                .hq-reservation-item-inner-wrapper{
                    overflow:hidden;
                }

            }
            </style>
            <div id='hq-wheelsberry-slider' class='cars-slider' id='cars-slider'>
                <div class='car-slider__title-wrapper om-container'>
                    <div class='om-container__inner'>
                        <h2 class='cars-slider__title'>{$slider_title}</h2>
                        <div class='h-subtitle cars-slider__subtitle'>{$slider_subtitle}</div>
                    </div>
                </div>
            
                <div class='cars-slider__inner owl-carousel'>
                        {$this->renderVehiclesOnSlider($vehicle_classes)}
                </div>
            </div>
        <div class='reservation reservation--full hq-reservation-form-wrapper' id='reservation'>
            <div class='reservation-form'>
                <div class='om-container'>
                    <div class='om-container__inner'>
                        <div class='reservation-form__inner'>
                            <div class='reservation-form__titles'>
                                    <h2 class='reservation-form__title'>{$form_title}</h2>
                                    <div class='h-subtitle reservation-form__subtitle'>{$form_subtitle}</div>
                                </div>
                            <form action='/reservations/' method='get'>
                                <div class='reservation-form__line reservation-form__car'>
                                    <div class='reservation-form__field-inner hq-reservation-item-inner-wrapper'>
                                        <select class='reservation-form__car-select' id='reservation-form__car-select' name='vehicle_class_id'>
                                            <option></option>
                                            {$this->resolveOptionsForClasses($vehicle_classes)}
                                        </select>
                                        <div class='reservation-form__car-select-label' id='reservation-form__car-select-label'>Choose a car</div>
                                    </div>
                                </div>
                                <div class='reservation-form__more'>
                                    <div class='reservation-form__line reservation-form__set reservation-form__pick-up'>
                                        <div class='reservation-form__pick-up-location reservation-form__location'>
                                            <div class='reservation-form__field-inner hq-reservation-item-inner-wrapper'>
                                                <label for='reservation-form__pick-up-location-select' class='reservation-form__label reservation-form__pick-up-location-label reservation-form__location-label'>Pick-up</label>
                                                <select id='hq-pick-up-location' name='pick_up_location' class='reservation-form__pick-up-time-select' data-placeholder='Choose a location'>
                                                    <option>Select Location</option>
                                                    {$this->resolveOptionsForLocations($locations)}
                                                </select>
                                            </div>
                                        </div>
                                        <div class='reservation-form__pick-up-date reservation-form__date'>
                                            <div class='reservation-form__field-inner hq-reservation-item-inner-wrapper'>
                                                <label for='reservation-form__pick-up-date-input' class='reservation-form__label reservation-form__pick-up-date-label reservation-form__date-label'>Pick-up</label>
                                                <div class='reservation-form__date-wrapper'>
                                                    <input type='text' name='pick_up_date' readonly='readonly' placeholder='Choose a date' class='reservation-form__pick-up-date-input' id='reservation-form__pick-up-date-input' data-date-format='m/d/y' />
                                                </div>
                                            </div>
                                        </div>
                                        <div class='reservation-form__pick-up-time reservation-form__time'>
                                            <div class='reservation-form__field-inner hq-reservation-item-inner-wrapper'>
                                                <select name='pick_up_time' class='reservation-form__pick-up-time-select' id='reservation-form__pick-up-time-select'>
                                                    <option value='12:00 am'>12:00 am</option><option value='12:15 am'>12:15 am</option><option value='12:30 am'>12:30 am</option><option value='12:45 am'>12:45 am</option><option value='1:00 am'>1:00 am</option><option value='1:15 am'>1:15 am</option><option value='1:30 am'>1:30 am</option><option value='1:45 am'>1:45 am</option><option value='2:00 am'>2:00 am</option><option value='2:15 am'>2:15 am</option><option value='2:30 am'>2:30 am</option><option value='2:45 am'>2:45 am</option><option value='3:00 am'>3:00 am</option><option value='3:15 am'>3:15 am</option><option value='3:30 am'>3:30 am</option><option value='3:45 am'>3:45 am</option><option value='4:00 am'>4:00 am</option><option value='4:15 am'>4:15 am</option><option value='4:30 am'>4:30 am</option><option value='4:45 am'>4:45 am</option><option value='5:00 am'>5:00 am</option><option value='5:15 am'>5:15 am</option><option value='5:30 am'>5:30 am</option><option value='5:45 am'>5:45 am</option><option value='6:00 am'>6:00 am</option><option value='6:15 am'>6:15 am</option><option value='6:30 am'>6:30 am</option><option value='6:45 am'>6:45 am</option><option value='7:00 am'>7:00 am</option><option value='7:15 am'>7:15 am</option><option value='7:30 am'>7:30 am</option><option value='7:45 am'>7:45 am</option><option value='8:00 am'>8:00 am</option><option value='8:15 am'>8:15 am</option><option value='8:30 am'>8:30 am</option><option value='8:45 am'>8:45 am</option><option value='9:00 am'>9:00 am</option><option value='9:15 am'>9:15 am</option><option value='9:30 am'>9:30 am</option><option value='9:45 am'>9:45 am</option><option value='10:00 am'>10:00 am</option><option value='10:15 am'>10:15 am</option><option value='10:30 am'>10:30 am</option><option value='10:45 am'>10:45 am</option><option value='11:00 am'>11:00 am</option><option value='11:15 am'>11:15 am</option><option value='11:30 am'>11:30 am</option><option value='11:45 am'>11:45 am</option><option value='12:00 pm' selected='selected'>12:00 pm</option><option value='12:15 pm'>12:15 pm</option><option value='12:30 pm'>12:30 pm</option><option value='12:45 pm'>12:45 pm</option><option value='1:00 pm'>1:00 pm</option><option value='1:15 pm'>1:15 pm</option><option value='1:30 pm'>1:30 pm</option><option value='1:45 pm'>1:45 pm</option><option value='2:00 pm'>2:00 pm</option><option value='2:15 pm'>2:15 pm</option><option value='2:30 pm'>2:30 pm</option><option value='2:45 pm'>2:45 pm</option><option value='3:00 pm'>3:00 pm</option><option value='3:15 pm'>3:15 pm</option><option value='3:30 pm'>3:30 pm</option><option value='3:45 pm'>3:45 pm</option><option value='4:00 pm'>4:00 pm</option><option value='4:15 pm'>4:15 pm</option><option value='4:30 pm'>4:30 pm</option><option value='4:45 pm'>4:45 pm</option><option value='5:00 pm'>5:00 pm</option><option value='5:15 pm'>5:15 pm</option><option value='5:30 pm'>5:30 pm</option><option value='5:45 pm'>5:45 pm</option><option value='6:00 pm'>6:00 pm</option><option value='6:15 pm'>6:15 pm</option><option value='6:30 pm'>6:30 pm</option><option value='6:45 pm'>6:45 pm</option><option value='7:00 pm'>7:00 pm</option><option value='7:15 pm'>7:15 pm</option><option value='7:30 pm'>7:30 pm</option><option value='7:45 pm'>7:45 pm</option><option value='8:00 pm'>8:00 pm</option><option value='8:15 pm'>8:15 pm</option><option value='8:30 pm'>8:30 pm</option><option value='8:45 pm'>8:45 pm</option><option value='9:00 pm'>9:00 pm</option><option value='9:15 pm'>9:15 pm</option><option value='9:30 pm'>9:30 pm</option><option value='9:45 pm'>9:45 pm</option><option value='10:00 pm'>10:00 pm</option><option value='10:15 pm'>10:15 pm</option><option value='10:30 pm'>10:30 pm</option><option value='10:45 pm'>10:45 pm</option><option value='11:00 pm'>11:00 pm</option><option value='11:15 pm'>11:15 pm</option><option value='11:30 pm'>11:30 pm</option><option value='11:45 pm'>11:45 pm</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='reservation-form__line reservation-form__set reservation-form__drop-off'>
                                        <div class='reservation-form__drop-off-location reservation-form__location'>
                                            <div class='reservation-form__field-inner hq-reservation-item-inner-wrapper'>
                                                <label for='reservation-form__pick-up-location-select' class='reservation-form__label reservation-form__pick-up-location-label reservation-form__location-label'>Drop-off</label>
                                                <select id='hq-return-location' name='return_location' class='reservation-form__pick-up-time-select' data-placeholder='Choose a location'>
                                                    <option>Select Location</option>
                                                    {$this->resolveOptionsForLocations($locations)}
                                                </select>
                                            </div>
                                        </div>
                                        <div class='reservation-form__drop-off-date reservation-form__date'>
                                            <div class='reservation-form__field-inner hq-reservation-item-inner-wrapper'>
                                                <label for='reservation-form__drop-off-date-input' class='reservation-form__label reservation-form__drop-off-date-label reservation-form__date-label'>Drop-off</label>
                                                <div class='reservation-form__date-wrapper'>
                                                    <input type='text' name='return_date' readonly='readonly' placeholder='Choose a date' class='reservation-form__drop-off-date-input' id='reservation-form__drop-off-date-input' data-date-format='m/d/y' />
                                                </div>
                                            </div>
                                        </div>
                                        <div class='reservation-form__drop-off-time reservation-form__time'>
                                            <div class='reservation-form__field-inner hq-reservation-item-inner-wrapper'>
                                                <select name='return_time' class='reservation-form__drop-off-time-select' id='reservation-form__drop-off-time-select'>
												    <option value='12:00 am'>12:00 am</option><option value='12:15 am'>12:15 am</option><option value='12:30 am'>12:30 am</option><option value='12:45 am'>12:45 am</option><option value='1:00 am'>1:00 am</option><option value='1:15 am'>1:15 am</option><option value='1:30 am'>1:30 am</option><option value='1:45 am'>1:45 am</option><option value='2:00 am'>2:00 am</option><option value='2:15 am'>2:15 am</option><option value='2:30 am'>2:30 am</option><option value='2:45 am'>2:45 am</option><option value='3:00 am'>3:00 am</option><option value='3:15 am'>3:15 am</option><option value='3:30 am'>3:30 am</option><option value='3:45 am'>3:45 am</option><option value='4:00 am'>4:00 am</option><option value='4:15 am'>4:15 am</option><option value='4:30 am'>4:30 am</option><option value='4:45 am'>4:45 am</option><option value='5:00 am'>5:00 am</option><option value='5:15 am'>5:15 am</option><option value='5:30 am'>5:30 am</option><option value='5:45 am'>5:45 am</option><option value='6:00 am'>6:00 am</option><option value='6:15 am'>6:15 am</option><option value='6:30 am'>6:30 am</option><option value='6:45 am'>6:45 am</option><option value='7:00 am'>7:00 am</option><option value='7:15 am'>7:15 am</option><option value='7:30 am'>7:30 am</option><option value='7:45 am'>7:45 am</option><option value='8:00 am'>8:00 am</option><option value='8:15 am'>8:15 am</option><option value='8:30 am'>8:30 am</option><option value='8:45 am'>8:45 am</option><option value='9:00 am'>9:00 am</option><option value='9:15 am'>9:15 am</option><option value='9:30 am'>9:30 am</option><option value='9:45 am'>9:45 am</option><option value='10:00 am'>10:00 am</option><option value='10:15 am'>10:15 am</option><option value='10:30 am'>10:30 am</option><option value='10:45 am'>10:45 am</option><option value='11:00 am'>11:00 am</option><option value='11:15 am'>11:15 am</option><option value='11:30 am'>11:30 am</option><option value='11:45 am'>11:45 am</option><option value='12:00 pm' selected='selected'>12:00 pm</option><option value='12:15 pm'>12:15 pm</option><option value='12:30 pm'>12:30 pm</option><option value='12:45 pm'>12:45 pm</option><option value='1:00 pm'>1:00 pm</option><option value='1:15 pm'>1:15 pm</option><option value='1:30 pm'>1:30 pm</option><option value='1:45 pm'>1:45 pm</option><option value='2:00 pm'>2:00 pm</option><option value='2:15 pm'>2:15 pm</option><option value='2:30 pm'>2:30 pm</option><option value='2:45 pm'>2:45 pm</option><option value='3:00 pm'>3:00 pm</option><option value='3:15 pm'>3:15 pm</option><option value='3:30 pm'>3:30 pm</option><option value='3:45 pm'>3:45 pm</option><option value='4:00 pm'>4:00 pm</option><option value='4:15 pm'>4:15 pm</option><option value='4:30 pm'>4:30 pm</option><option value='4:45 pm'>4:45 pm</option><option value='5:00 pm'>5:00 pm</option><option value='5:15 pm'>5:15 pm</option><option value='5:30 pm'>5:30 pm</option><option value='5:45 pm'>5:45 pm</option><option value='6:00 pm'>6:00 pm</option><option value='6:15 pm'>6:15 pm</option><option value='6:30 pm'>6:30 pm</option><option value='6:45 pm'>6:45 pm</option><option value='7:00 pm'>7:00 pm</option><option value='7:15 pm'>7:15 pm</option><option value='7:30 pm'>7:30 pm</option><option value='7:45 pm'>7:45 pm</option><option value='8:00 pm'>8:00 pm</option><option value='8:15 pm'>8:15 pm</option><option value='8:30 pm'>8:30 pm</option><option value='8:45 pm'>8:45 pm</option><option value='9:00 pm'>9:00 pm</option><option value='9:15 pm'>9:15 pm</option><option value='9:30 pm'>9:30 pm</option><option value='9:45 pm'>9:45 pm</option><option value='10:00 pm'>10:00 pm</option><option value='10:15 pm'>10:15 pm</option><option value='10:30 pm'>10:30 pm</option><option value='10:45 pm'>10:45 pm</option><option value='11:00 pm'>11:00 pm</option><option value='11:15 pm'>11:15 pm</option><option value='11:30 pm'>11:30 pm</option><option value='11:45 pm'>11:45 pm</option>
                                                </select>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class='reservation-form__line reservation-form__required-notice'>
                                        <div class='reservation-form__field-inner hq-reservation-item-inner-wrapper'>
                                            <div class='reservation-form__required-notice-box'>Please fill in all required fields</div>
                                        </div>
                                    </div>
                                    <div class='reservation-form__line reservation-form__submit'>
                                        <div class='reservation-form__field-inner hq-reservation-item-inner-wrapper'>
                                            <input type='hidden' name='target_step' value='3' />
                                            <input type='submit' class='reservation-form__submit-button' id='reservation-form__submit-button' value='Continue booking' />
                                            <circle class='path' cx='24' cy='24' r='20' fill='none' stroke='#fff' stroke-width='4'>
                                              <animate attributeName='stroke-dasharray' attributeType='XML' from='1,200' to='89,200' values='1,200; 89,200; 89,200' keyTimes='0; 0.5; 1' dur='1.5s' repeatCount='indefinite' />
                                              <animate attributeName='stroke-dashoffset' attributeType='XML' from='0' to='-124' values='0; -35; -124' keyTimes='0; 0.5; 1' dur='1.5s' repeatCount='indefinite' />
                                              <animateTransform attributeName='transform' attributeType='XML' type='rotate' from='0 24 24' to='360 24 24' dur='3s' repeatCount='indefinite'/>
                                            </circle>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function setListeners(baseValue, changedValue){
                var pickupLocation = document.getElementById(baseValue);
                pickupLocation.addEventListener('change',function(){
                    var pickupLocation = document.getElementById(baseValue);
                    var returnLocation = document.getElementById(changedValue);
                    console.log(pickupLocation.value);
                    returnLocation.value = pickupLocation.value; 
                });
            }
            setListeners('hq-pick-up-location','hq-return-location');
            setListeners('reservation-form__pick-up-time-select','reservation-form__drop-off-time-select');
        </script>
        ";
        return $html;
    }

    private function getTitle($classTitle)
    {
        return preg_replace('/\s/', '<span class="cars - slider__model - br"><br></span>', $classTitle);
    }

    private function renderVehiclesOnSlider($vehicles)
    {
        if (is_array($vehicles) and count($vehicles)) {
            $html = '';
            foreach ($vehicles as $vehicle) {
                $priceHTML = "";
                $priceHTML = !empty($vehicle->getActiveRate()->daily_rate->amount_for_display) ? ("<span class='omcr-price-currency hq-wheelsberry-daily-tag'>{$vehicle->getActiveRate()->daily_rate->amount_for_display} daily</span>") : "";
                $priceHTML .= !empty($vehicle->getActiveRate()->daily_rate->amount_for_display) ? ("<span class='omcr-price-currency hq-wheelsberry-separator'> |</span> <span class='omcr-price-currency hq-wheelsberry-weekly-tag'>{$vehicle->getActiveRate()->weekly_rate->amount_for_display} weekly</span>") : "";
                $html .= "
                    <div class='cars-slider__item'>
                        <div class='om-container'>
                            <div class='cars-slider__item-inner om-container__inner'>
                                <div class='cars-slider__item-description'>
                                    <div class='cars-slider__item-category'>{$vehicle->name}</div>
                                    <h3 class='cars-slider__model'><span class='cars-slider__model-inner'>{$this->getTitle($vehicle->getLabelForWebsite())}</span></h3>
                                    <div class='cars-slider__item-description-sep'></div>
                                    <div class='cars-slider__item-price'>
                                        <span class='cars-slider__item-price-value'>{$priceHTML}</span>
                                    </div>
                                    <div class='cars-slider__item-reserve'>
                                        <span class='cars-slider__item-reserve-button' data-car-id='{$vehicle->getId()}'>Reserve Now</span>
                                    </div>
                                </div>
                                <div class='cars-slider__item-image hq-wheelsberry-image-wrapper'>
                                    <img src='{$vehicle->getPublicImage()}' alt='{$vehicle->getLabelForWebsite()}' />
                                </div>
                                <div class='cars-slider__item-options'>
                                    <div class='cars-slider__item-options-inner'>
                                        <!-- Features -->
                                        {$this->resolveFeatures($vehicle->getVehicleFeatures())}
                                    </div>
                                </div>
                                <div class='cars-slider__item-reserve-mobile'>
                                    <span class='cars-slider__item-reserve-button' data-car-id='{$this->post->ID}'>Reserve Now</span>
                                </div>
                            </div>            
                        </div>
                    </div>
                    
                ";
            }
            return $html;
        }
        return '';
    }

    private function resolveFeatures($features)
    {
        if (is_array($features) and count($features)) {
            $html = '';
            foreach ($features as $feature) {
                $html .= "
                    <div class='cars-slider__item-option car-option'><i class='cars-slider__hq-feature-icon {$feature->icon}'></i><span class='cars-slider__item-option-label'>{$feature->label}</span></div>       
                ";
            }
            return $html;
        }
        return '';
    }

    private function resolveOptionsForClasses($vehicles)
    {
        if (is_array($vehicles) and count($vehicles)) {
            $html = '';
            foreach ($vehicles as $vehicle) {
                $html .= "<option value='{$vehicle->getId()}'>{$vehicle->getLabelForWebsite()}</option>";
            }
            return $html;
        }
        return '';
    }

    private function resolveOptionsForLocations($locations)
    {
        if (is_array($locations) and count($locations)) {
            $html = '';
            foreach ($locations as $location) {
                $html .= "<option value='{$location->getId()}'>{$location->getName()}</option>";
            }
            return $html;
        }
        return '';
    }
}