<?php

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;

new HQRentalBakeryWheelsberryReservationFormShortcode();


class HQRentalBakeryWheelsberryReservationFormShortcode extends WPBakeryShortCode
{
    private $title;
    private $button_text;
    private $reservation_url;

    public function __construct()
    {
        add_action('vc_before_init', array($this, 'setParams'));
        add_shortcode('hq_bakery_wheelsberry_reservation_form', array($this, 'content'));
        $this->query = new HQRentalsDBQueriesVehicleClasses();
        $this->assets = new HQRentalsAssetsHandler();
        $this->helper = new HQRentalsFrontHelper();
    }

    public function content($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'title' => esc_html__('Book Now', 'wheelsberry'),
            'button_text' => esc_html__('Continue Booking', 'wheelsberry'),
            'reservation_url' => '/reservations/',
        ), $atts));
        $this->title = $atts['title'];
        $this->button_text = $atts['button_text'];
        $this->reservation_url = $atts['reservation_url'];
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
        $queryVehicles = new HQRentalsQueriesVehicleClasses();
        $queryLocations = new HQRentalsQueriesLocations();
        $vehicle_classes = $queryVehicles->allVehicleClasses();
        $locations = $queryLocations->allLocations();
        if(isset($GLOBALS['omCarRentalPlugin'])) {
            global $post;
            $post_id = $post->ID;
            $display_slider=get_post_meta($post_id, 'wheelsberry_cars_slider', true);
            $cf7_form=get_post_meta($post_id, 'wheelsberry_reservation_cf7_form', true);
            if($cf7_form) {
                $display_form=get_post_meta($post_id, 'wheelsberry_reservation_form', true);
            } else {
                $display_form=false;
            }

            if($display_slider && $cf7_form && empty($display_form)) {
                $display_form='hidden';
            }
            $cars_query = new WP_Query('post_type=om-car&posts_per_page=-1&orderby=menu_order&order=ASC');
            if($cars_query->have_posts()) {
                if($display_slider) {
                    wp_enqueue_style( 'owl-carousel' );
                    wp_enqueue_script( 'owl-carousel' );
                    $slider_title=get_post_meta($post_id, 'wheelsberry_cars_slider_title', true);
                    $slider_subtitle=get_post_meta($post_id, 'wheelsberry_cars_slider_subtitle', true);
                    ?>
                    <div class="cars-slider" id="cars-slider">
                        <?php if($slider_title != '' || $slider_subtitle != '') { ?>
                            <div class="car-slider__title-wrapper om-container">
                                <div class="om-container__inner">
                                    <?php if($slider_title != '') { ?><h2 class="cars-slider__title"><?php echo esc_html($slider_title) ?></h2><?php } ?>
                                    <?php if($slider_subtitle != '') { ?><div class="h-subtitle cars-slider__subtitle"><?php echo esc_html($slider_subtitle) ?></div><?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="cars-slider__inner owl-carousel">
                            <?php while( $cars_query->have_posts() ) : $cars_query->the_post(); ?>
                                <?php if( get_post_meta($post->ID, 'omcr_hide_in_slider', true) == 1) { continue; } ?>
                                <div class="cars-slider__item">
                                    <div class="om-container">
                                        <div class="cars-slider__item-inner om-container__inner">
                                            <div class="cars-slider__item-description">
                                                <?php
                                                $categories=get_the_terms($post->ID, 'om-car-type');
                                                if($categories) {
                                                    $categories_=array();
                                                    foreach($categories as $v) {
                                                        $categories_[]=$v->name;
                                                    }
                                                    echo '<div class="cars-slider__item-category">'.implode(', ',$categories_).'</div>';
                                                }
                                                ?>
                                                <h3 class="cars-slider__model"><span class="cars-slider__model-inner"><?php echo preg_replace('/\s/',' <span class="cars-slider__model-br"><br></span>',get_the_title()); ?></span></h3>
                                                <div class="cars-slider__item-description-sep"></div>
                                                <?php
                                                $price=get_post_meta($post->ID, 'omcr_car_price', true);
                                                if($price != '') {
                                                    $price_type=get_post_meta($post->ID, 'omcr_car_price_type', true);
                                                    echo '<div class="cars-slider__item-price">'.($price_type == 'from' ? '<span class="cars-slider__item-price-from">'.esc_html__( 'from', 'wheelsberry' ).' </span>' : '').'<span class="cars-slider__item-price-value">'.omce_html_format_price($price).'</span><span class="cars-slider__item-price-period"> '.esc_html__( 'day', 'wheelsberry' ).'</span></div>';
                                                }
                                                ?>
                                                <?php if ( $custom_link = get_post_meta( $post->ID, 'omcr_custom_link', true ) ) { ?>
                                                    <div class="cars-slider__item-reserve">
                                                        <a href="<?php echo esc_url( $custom_link ) ?>" class="cars-slider__item-reserve-button"<?php echo ( get_post_meta( $post->ID, 'omcr_custom_link_target', true ) == "_blank" ? ' target="_blank"' : '' ) ?>><?php esc_html_e( 'Reserve Now', 'wheelsberry' ) ?></a>
                                                    </div>
                                                <?php } elseif ( $cf7_form ) { ?>
                                                    <div class="cars-slider__item-reserve">
                                                        <span class="cars-slider__item-reserve-button" data-car-id="<?php echo esc_attr($post->ID) ?>"><?php esc_html_e( 'Reserve Now', 'wheelsberry' ) ?></span>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <div class="cars-slider__item-image">
                                                <?php
                                                if( has_post_thumbnail() ) {
                                                    $src=wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');
                                                    if($src) {
                                                        echo '<img src="'.esc_url($src[0]).'" alt="'.esc_attr(get_the_title()).'" />';
                                                    }
                                                }
                                                ?>
                                            </div>
                                            <div class="cars-slider__item-options">
                                                <div class="cars-slider__item-options-inner">
                                                    <?php
                                                    $options=wheelsberry_get_car_options();
                                                    foreach($options as $k=>$v) {
                                                        $val=get_post_meta($post->ID, 'omcr_car_'.$k, true);
                                                        if($val != '') {
                                                            echo '<div class="cars-slider__item-option car-option-'.esc_attr($k).'"><span class="cars-slider__item-option-label">'.esc_html($v).': </span><span class="cars-slider__item-option-value">'.esc_html($val).'</span></div>';
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php if($cf7_form) { ?>
                                                <div class="cars-slider__item-reserve-mobile">
                                                    <span class="cars-slider__item-reserve-button" data-car-id="<?php echo esc_attr($post->ID) ?>"><?php esc_html_e( 'Reserve Now', 'wheelsberry' ) ?></span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php
                    wp_reset_postdata();
                }

                if($display_form) {

                    wp_enqueue_style('select2');
                    wp_enqueue_script('select2');
                    wp_enqueue_script('jquery-ui-datepicker');

                    $form_title=get_post_meta($post_id, 'wheelsberry_reservation_form_title', true);
                    $form_subtitle=get_post_meta($post_id, 'wheelsberry_reservation_form_subtitle', true);
                    $cars_query->rewind_posts();
                    $custom_location=get_option('omcr_booking_custom_location');
                    if($custom_location != 'only') {
                        $locations_query = new WP_Query('post_type=om-car-location&posts_per_page=-1&orderby=menu_order&order=ASC');
                    }
                    $time_from=intval(get_option('omcr_booking_time_from'));
                    $time_to=intval(get_option('omcr_booking_time_to'));
                    if(!$time_to) {
                        $time_to=85500;
                    }
                    $time_default=get_option('omcr_booking_time_default');
                    if($time_default === false) {
                        $time_default=43200;
                    }

                    ?>
                    <div class="reservation reservation--<?php echo esc_attr($display_form)?>" id="reservation">
                        <div class="reservation-form">
                            <div class="om-container">
                                <div class="om-container__inner">
                                    <div class="reservation-form__inner">
                                        <?php if($form_title != '' || $form_subtitle != '') { ?>
                                            <div class="reservation-form__titles">
                                                <?php if($form_title != '') { ?><h2 class="reservation-form__title"><?php echo esc_html($form_title) ?></h2> <?php } ?>
                                                <?php if($form_subtitle != '') { ?><div class="h-subtitle reservation-form__subtitle"><?php echo esc_html($form_subtitle) ?></div> <?php } ?>
                                            </div>
                                        <?php } ?>
                                        <form action="/reservations/" method="post">
                                            <div class="reservation-form__line reservation-form__car">
                                                <div class="reservation-form__field-inner">
                                                    <select class="reservation-form__car-select" id="reservation-form__car-select" name="vehicle_class_id">
                                                        <?php foreach ($vehicle_classes as $vehicle): ?>
                                                            <option value="<?php echo $vehicle->id; ?>"><?php echo $vehicle->name; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="reservation-form__car-select-label" id="reservation-form__car-select-label"><?php esc_html_e( 'Choose a car', 'wheelsberry' ) ?></div>
                                                </div>
                                            </div>
                                            <div class="reservation-form__more">
                                                <div class="reservation-form__line reservation-form__set reservation-form__pick-up">
                                                    <div class="reservation-form__pick-up-location reservation-form__location">
                                                        <div class="reservation-form__field-inner">
                                                            <label for="reservation-form__pick-up-location-select" class="reservation-form__label reservation-form__pick-up-location-label reservation-form__location-label"><?php esc_html_e( 'Pick-up', 'wheelsberry' ) ?></label>
                                                            <select name="pick_up_location" class="reservation-form__pick-up-time-select" data-placeholder="<?php esc_attr_e( 'Choose a location', 'wheelsberry' ) ?>">
                                                                <option> Select Location</option>
                                                                <?php foreach ($locations as $location): ?>
                                                                    <option value="<?php echo $location->id; ?>"><?php echo $location->name; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="reservation-form__pick-up-date reservation-form__date">
                                                        <div class="reservation-form__field-inner">
                                                            <label for="reservation-form__pick-up-date-input" class="reservation-form__label reservation-form__pick-up-date-label reservation-form__date-label"><?php esc_html_e( 'Pick-up', 'wheelsberry' ) ?></label>
                                                            <div class="reservation-form__date-wrapper">
                                                                <input type="text" name="pick_up_date" readonly="readonly" placeholder="<?php esc_attr_e( 'Choose a date', 'wheelsberry' ) ?>" class="reservation-form__pick-up-date-input" id="reservation-form__pick-up-date-input" data-date-format="yy-mm-dd" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="reservation-form__pick-up-time reservation-form__time">
                                                        <div class="reservation-form__field-inner">
                                                            <select name="pick_up_time" class="reservation-form__pick-up-time-select" id="reservation-form__pick-up-time-select">
                                                                <?php
                                                                $time_format=get_option('time_format');
                                                                for($i=$time_from;$i<=$time_to;$i+=900) {
                                                                    $time=date('H:i', $i);
                                                                    echo '<option value="'.esc_attr($time).'"'.($i==$time_default ? ' selected="selected"' : '').'>'.esc_html($time).'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="reservation-form__line reservation-form__set reservation-form__drop-off">
                                                    <div class="reservation-form__drop-off-location reservation-form__location">
                                                        <div class="reservation-form__field-inner">
                                                            <label for="reservation-form__pick-up-location-select" class="reservation-form__label reservation-form__pick-up-location-label reservation-form__location-label"><?php esc_html_e( 'Drop-off', 'wheelsberry' ) ?></label>
                                                            <select name="return_location" class="reservation-form__pick-up-time-select" data-placeholder="<?php esc_attr_e( 'Choose a location', 'wheelsberry' ) ?>">
                                                                <option>Select Location</option>
                                                                <?php foreach ($locations as $location): ?>
                                                                    <option value="<?php echo $location->id; ?>"><?php echo $location->name; ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="reservation-form__drop-off-date reservation-form__date">
                                                        <div class="reservation-form__field-inner">
                                                            <label for="reservation-form__drop-off-date-input" class="reservation-form__label reservation-form__drop-off-date-label reservation-form__date-label"><?php esc_html_e( 'Drop-off', 'wheelsberry' ) ?></label>
                                                            <div class="reservation-form__date-wrapper">
                                                                <input type="text" name="return_date" readonly="readonly" placeholder="<?php esc_attr_e( 'Choose a date', 'wheelsberry' ) ?>" class="reservation-form__drop-off-date-input" id="reservation-form__drop-off-date-input" data-date-format="<?php echo esc_attr(wheelsberry_date_format_wp_to_js(get_option('date_format'))) ?>" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="reservation-form__drop-off-time reservation-form__time">
                                                        <div class="reservation-form__field-inner">
                                                            <select name="return_time" class="reservation-form__drop-off-time-select" id="reservation-form__drop-off-time-select">
                                                                <?php
                                                                $time_format=get_option('time_format');
                                                                for($i=$time_from;$i<=$time_to;$i+=900) {
                                                                    $time=date('H:i', $i);
                                                                    echo '<option value="'.esc_attr($time).'"'.($i==$time_default ? ' selected="selected"' : '').'>'.esc_html($time).'</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="reservation-form__line reservation-form__required-notice">
                                                    <div class="reservation-form__field-inner">
                                                        <div class="reservation-form__required-notice-box"><?php esc_html_e( 'Please fill in all required fields.', 'wheelsberry' ) ?></div>
                                                    </div>
                                                </div>
                                                <div class="reservation-form__line reservation-form__submit">
                                                    <div class="reservation-form__field-inner">
                                                        <input type="submit" class="reservation-form__submit-button" id="reservation-form__submit-button" value="<?php esc_attr_e( 'Continue booking', 'wheelsberry' ) ?>" />
                                                        <img src="<?php echo omfw_Framework::svg_url_data('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="28" height="28">
                                                    <circle class="path" cx="24" cy="24" r="20" fill="none" stroke="#fff" stroke-width="4">
                                                      <animate attributeName="stroke-dasharray" attributeType="XML" from="1,200" to="89,200" values="1,200; 89,200; 89,200" keyTimes="0; 0.5; 1" dur="1.5s" repeatCount="indefinite" />
                                                      <animate attributeName="stroke-dashoffset" attributeType="XML" from="0" to="-124" values="0; -35; -124" keyTimes="0; 0.5; 1" dur="1.5s" repeatCount="indefinite" />
                                                      <animateTransform attributeName="transform" attributeType="XML" type="rotate" from="0 24 24" to="360 24 24" dur="3s" repeatCount="indefinite"/>
                                                    </circle>
                                                    </svg>') ?>" class="ajax-loading" alt="" />
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    wp_reset_postdata();
                }

            }
        }
    }
}