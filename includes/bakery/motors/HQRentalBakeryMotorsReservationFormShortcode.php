<?php

use \HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use \HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;


new HQRentalBakeryMotorsVehicleGridShortcode();

class HQRentalBakeryMotorsReservationFormShortcode extends WPBakeryShortCode
{
    private $query;
    private $reservationURL;

    public function __construct()
    {
        add_action('vc_before_init', array($this, 'setParams'));
        add_shortcode('hq_bakery_motors_vehicle_grid', array($this, 'content'));
        $this->query = new HQRentalsDBQueriesVehicleClasses();
    }

    public function content($atts, $content = null)
    {
        extract( shortcode_atts( array(
            'reservation_page_url'				=>	'',

        ), $atts ) );
        $this->reservationURL = $atts['reservation_page_url'];
        echo $this->renderShortcode();
    }

    public function setParams()
    {
        vc_map(
            array(
                'name' => __('HQ Vehicles Classes Grid', 'hq-wordpress'),
                'base' => 'hq_bakery_motors_vehicle_grid',
                'content_element' => true,
                "category" => __('HQ Rental Software - Motors Theme'),
                'show_settings_on_create' => true,
                'description' => __('HQ Vehicles Classes Grid', 'hq-wordpress'),
                'icon' => HQRentalsAssetsHandler::getHQLogo(),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Reservation URL', 'hq-wordpress'),
                        'param_name' => 'reservation_page_url',
                        'value' => ''
                    ),
                )
            )
        );
    }

    public function renderShortcode()
    {
        extract( shortcode_atts( array(
            'pick_up_location_label'	        =>	'',
            'pick_up_location_placeholder'	    =>	'',
            'pick_up_date_label'	            =>	'',
            'pick_up_date_placeholder'	        =>	'',
            'return_date_label'		            =>	'',
            'return_date_placeholder'	        =>	'',
            'button_text'                       =>  '',
            'alignment'                         =>  'text-left',
            'action_link'	                    =>	'',
            'pickup_locations'                  =>  '',
            'return_locations'                  =>  '',
            'return_location_label'             =>  '',
            'return_location_placeholder'       =>  '',
            'delivery_location_label'           =>  '',
            'delivery_location_placeholder'     =>  '',
            'collection_location_label'         =>  '',
            'collection_location_placeholder'   =>  '',
            'multiple_brands'                   =>  false,
            'brands_links'                      =>  [],
            'pick_brand_label'                  =>  '',
            'pick_brand_placeholder'            =>  ''
        ), $atts ) );
        return HQRentalsAssetsHandler::getHQFontAwesome() . "
            <div class='stm_rent_car_form_wrapper caag-book-form-style style_1 <?php echo $alignment; ?>'>
                <div class='stm_rent_car_form'>
                    <?php if($multiple_brands): ?>
                    <form id='caag-book-form' action='<?php echo $brands_links[0]['link']; ?>' method='post'>
                        <?php else: ?>
                        <form id='caag-book-form' action='<?php echo $action_link; ?>' method='post'>
                            <?php endif; ?>
                            <?php if($multiple_brands): ?>
                                <h4><?php echo $pick_brand_label; ?></h4>
                                <div class='stm_rent_form_fields' style='margin-bottom: 15px;'>
                                    <div class='stm_pickup_location'>
                                        <i class='stm-service-icon-pin'></i>
                                        <select id='hq-pick-brand' name='pick_up_location' data-class='stm_rent_location' tabindex='-1' class='select2-hidden-accessible' aria-hidden='true'>
                                            <option><?php echo $pick_brand_placeholder; ?></option>
                                            <?php foreach ($brands_links as $brand): ?>
                                                <option value='<?php echo $brand['link']; ?>'><?php echo $brand['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <h4><?php echo $pick_up_location_label; ?></h4>
                            <div class='stm_rent_form_fields'>
                                <div class='stm_pickup_location'>
                                    <i class='stm-service-icon-pin'></i>
                                    <select id='hq-pick-up-location' name='pick_up_location' data-class='stm_rent_location' tabindex='-1' class='select2-hidden-accessible' aria-hidden='true'>
                                        <option value=''><?php echo $pick_up_location_placeholder; ?></option>
                                        <?php foreach ($pickup_locations as $location): ?>
                                            <option value='<?php echo $location['id']; ?>'><?php echo $location['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div id='hq-delivery-location-wrapper'>
                                <h4 style='margin-top:18px;'><?php echo $delivery_location_label; ?></h4>
                                <div class='stm_date_time_input'>
                                    <div class='stm_date_input'>
                                        <input type='text' value='' class='hq-text-fields' name='pick_up_location_custom' placeholder='<?php echo $delivery_location_placeholder; ?>' >
                                        <i class='stm-service-icon-pin'></i>
                                    </div>
                                </div>
                            </div>
                            <h4 style='margin-top:18px;'><?php echo $return_location_label; ?></h4>
                            <div class='stm_rent_form_fields'>
                                <div class='stm_pickup_location'>
                                    <i class='stm-service-icon-pin'></i>
                                    <select id='hq-return-location' name='return_location' data-class='stm_rent_location' tabindex='-1' class='select2-hidden-accessible' aria-hidden='true'>
                                        <option value=''><?php echo $return_location_placeholder; ?></option>
                                        <?php foreach ($return_locations as $location): ?>
                                            <option value='<?php echo $location['id']; ?>'><?php echo $location['label']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div id='hq-collection-location-wrapper'>
                                    <h4 style='margin-top:18px;'><?php echo $collection_location_label; ?></h4>
                                    <div class='stm_date_time_input'>
                                        <div class='stm_date_input'>
                                            <input type='text' value='' class='hq-text-fields' name='return_location_custom' placeholder='<?php echo $collection_location_placeholder; ?>'>
                                            <i class='stm-service-icon-pin'></i>
                                        </div>
                                    </div>
                                </div>
                                <h4 style='margin-top:18px;'><?php echo $pick_up_date_label; ?></h4>
                                <div class='stm_date_time_input'>
                                    <div class='stm_date_input'>
                                        <input type='text' id='caag-pick-up-date' class=' active' name='pick_up_date' placeholder='<?php echo $pick_up_date_placeholder; ?>' required='' readonly=''>
                                        <i class='stm-icon-date'></i>
                                    </div>
                                </div>
                            </div>
                            <h4><?php echo $return_date_label; ?></h4>
                            <div class='stm_rent_form_fields stm_rent_form_fields-drop'>
                                <div class='stm_date_time_input'>
                                    <div class='stm_date_input'>
                                        <input type='text' id='caag-return-date' class=' active' name='return_date' placeholder='<?php echo $return_date_placeholder; ?>' required='' readonly=''>
                                        <i class='stm-icon-date'></i>
                                    </div>
                                </div>
                            </div>
                            <button type='submit'><?php echo $button_text; ?><i class='fa fa-arrow-right'></i></button>
                        </form>
                </div>
            </div>
            <style>
                .stm-template-car_rental .stm_rent_location .select2-dropdown{
                    min-height: 0px;
                }
                #hq-delivery-location-wrapper, #hq-collection-location-wrapper {
                    display: none;
                }
                .hq-text-fields{
                    padding-left: 37px;
                    height: 40px;
                    line-height: 40px;
                    background-color: #fff;
                    border: 0;
                }
            </style>
        ";
    }

    public function resolveSingleVehicleCode($vehicle)
    {
        return "

        <div class='stm_product_grid_single'>
            <a href='{$this->reservationURL}' class='inner'>
                <div class='stm_top clearfix'>
                    <div class='stm_left heading-font'>
                        <h3>{$vehicle->getLabelForWebsite()}</h3>
                        <div class='s_title'></div>
                        <div class='price'>
                            <mark>From</mark>
                            <span class='woocommerce-Price-amount amount'>{$vehicle->getActiveRate()->daily_rate->amount_for_display}<span style='font-size: 12px;'>/day</span></span>
                        </div>
                    </div>
                    ". $this->renderFeatures($vehicle) ."
                </div>
                <div class='stm_image'>
                        <img width='798' height='466'
                        src='{$vehicle->getPublicImage()}' />
                    </div>
            </a>
        </div>
        ";
    }
    public function renderFeatures($vehicle)
    {
        $html = "";
        if(is_array($vehicle->getVehicleFeatures()) and count($vehicle->getVehicleFeatures())){
            foreach ($vehicle->getVehicleFeatures() as $feature){
                $html .= "
                    <div class='single_info'>
                        <i class='{$feature->icon}'></i>
                        <span>{$feature->label}</span>
                    </div>
                ";
            }
            return "<div class='stm_right'>". $html ."</div>";
        }
        return $html;
    }
}