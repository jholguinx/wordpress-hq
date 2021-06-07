<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsElementor\HQRentalsElementorAssetsHandler;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsPlacesReservationForm
{
    private $linkURL;
    private $title;
    private $orientation;

    public function __construct($params)
    {
        if (!empty($params['url'])) {
            $this->linkURL = $params['url'];
        }
        if (!empty($params['title'])) {
            $this->title = $params['title'];
        }
        if (!empty($params['orientation'])) {
            $this->orientation = $params['orientation'];
        }
        $this->settings = new HQRentalsSettings();
        $this->assets =new HQRentalsAssetsHandler();
        add_shortcode('hq_rentals_places_reservation_form', array($this, 'renderShortcode'));
    }

    public function renderShortcode()
    {
        $key = $this->settings->getGoogleAPIKey();
        $this->assets->loadPlacesReservationAssets();
        $html = "";
        if(empty($key)){
            return "<p>Add Google Key</p>";
        }else{
            if($this->orientation === 'horizontal'){
                $html = "
            ". HQRentalsAssetsHandler::getHQFontAwesome() ."
            <div id='hq-place-form-desktop' class=''>
               <div id='hq-form-wrapper' class=''>
                  <form id='hq-form' class='' method='get' action='{$this->linkURL}'>
                     <div class='hq-places-inner-wrapper'>
                        <div class='hq-places-input-wrapper'>
                            <div>
                                <label class='hq-places-label'>PICK UP LOCATION</label> 
                            </div>
                            <div>
                                <input type='text' name='pick_up_location_custom' id='hq-places-field' class='hq-places-auto-complete'>
                            </div>
                        </div>
                        <div class='hq-places-input-wrapper'>
                            <div>
                                <label class='hq-places-label'>FROM</label> 
                            </div>
                            <div class='hq-places-date-time-wrapper'>
                                <div class='hq-places-times-input-wrapper'>
                                    <input type='text' name='pick_up_date' class='hq-places-auto-complete' id='hq-times-pick-up-date'>
                                    <span class='hq-select-icon-wrapper'><i class='fas fa-chevron-down'></i></span>
                                </div>
                                <div class='hq-places-times-input-wrapper'>
                                    <input type='text' name='pick_up_time' class='hq-places-auto-complete' id='hq-times-pick-up-time'>
                                    <span class='hq-select-icon-wrapper'><i class='fas fa-chevron-down'></i></span>
                                </div>
                            </div>
                        </div>
                        <div class='hq-places-input-wrapper'>
                            <div>
                                <label class='hq-places-label'>UNTIL</label> 
                            </div>
                            <div class='hq-places-date-time-wrapper'>
                                <div class='hq-places-times-input-wrapper'>
                                    <input type='text' name='return_date' class='hq-places-auto-complete' id='hq-times-return-date'>
                                    <span class='hq-select-icon-wrapper'><i class='fas fa-chevron-down'></i></span>
                                </div>
                                <div class='hq-places-times-input-wrapper'>
                                    <input type='text' name='return_time' class='hq-places-auto-complete' id='hq-times-return-time'>
                                    <span class='hq-select-icon-wrapper'><i class='fas fa-chevron-down'></i></span>
                                </div>
                            </div>
                        </div>
                        <div class='hq-places-input-wrapper hq-button-wrapper'>
                            <button type='submit' class='hq-places-submit-button'>Book Now</button>    
                        </div>
                        <input type='hidden' name='target_step' value='2'>
                        <input type='hidden' name='pick_up_location' value='custom'>
                        <input type='hidden' name='return_location' value='custom'>
                        <input type='hidden' name='return_location_custom' value='' id='hq-return-location-custom'>
                     </div>
                  </form>
               </div>
            </div>
        ";
        }else{
                $html = "
            ". HQRentalsAssetsHandler::getHQFontAwesome() ."
                <div class='elementor-tab-title elementor-tab-mobile-title' data-tab='1' role='tab'>
                        <center><i aria-hidden='true' class='icon icon-car'></i>Cars</center>
                    </div>
                    <div id='elementor-tab-content-1931' class='elementor-tab-content elementor-clearfix' data-tab='1'
                         role='tabpanel' aria-labelledby='elementor-tab-title-1931' style='display: none;'>

                        <div class='elementor-column-wrap  elementor-element-populated'>
                            <div class='elementor-widget-wrap'>
                                <div class='elementor-element elementor-element-3f9ae7f6 elementor-button-align-stretch elementor-widget elementor-widget-form'
                                     data-id='3f9ae7f6' data-element_type='widget' data-widget_type='form.default'>
                                    <div class='elementor-widget-container'>
                                        <form method='post' name='Booking' action='/cars-reservations/'>
                                            <div class='elementor-form-fields-wrapper elementor-labels-above'>
                                                <div class='hq-smart-form-element-wrapper elementor-field-type-select elementor-field-group elementor-column elementor-field-group-location elementor-col-50 elementor-field-required'>
                                                    <label for='form-field-location'
                                                           class='elementor-field-label hq-smart-label'>Location</label>
                                                    <div class='elementor-field elementor-select-wrapper '>
                                                        <select name='pick_up_location' id='hq-form-pick_up_location_cars'
                                                                class='hq-smart-select elementor-field-textual elementor-size-sm'
                                                                required='required' aria-required='true'>
                                                            <?php foreach ($locationCars as $location): ?>
                                                                <option value='<?php echo $location->id ?>'><?php echo $location->name ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <input type='hidden' name='return_location' id='hq-form-return_location_cars' value='<?php echo $locationCars[0]->id; ?>'>
                                                <div class='hq-smart-form-element-wrapper elementor-field-type-date elementor-field-group elementor-column elementor-field-group-pick_up_date elementor-col-50 elementor-field-required'>
                                                    <label for='form-field-pick_up_date'
                                                           class='elementor-field-label hq-smart-label'>Pickup
                                                        Date</label>
                                                    <input type='text' name='pick_up_date' id='hq-form-pick_up_date_cars'
                                                           class='hq-smart-input-picker elementor-field elementor-size-sm elementor-field-textual flatpickr-input'
                                                           placeholder='Today' required='true'
                                                           pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' aria-required='true'
                                                           readonly='readonly'>
                                                </div>
                                                <div class='hq-smart-form-element-wrapper elementor-field-type-date elementor-field-group elementor-column elementor-field-group-return_date elementor-col-50 elementor-field-required'>
                                                    <label for='form-field-return_date'
                                                           class='elementor-field-label hq-smart-label'>Return
                                                        Date</label>
                                                    <input type='text' name='return_date' id='hq-form-return_date_cars'
                                                           class='hq-smart-input-picker elementor-field elementor-size-sm elementor-field-textual flatpickr-input'
                                                           placeholder='Tomorrow' required='required'
                                                           pattern='[0-9]{4}-[0-9]{2}-[0-9]{2}' readonly='readonly'>
                                                </div>
                                                <div class='hq-smart-form-element-wrapper elementor-field-type-time elementor-field-group elementor-column elementor-field-group-field_b55a2fd elementor-col-50 elementor-field-required'>
                                                    <label for='form-field-field_b55a2fd'
                                                           class='elementor-field-label hq-smart-label'>Pickup
                                                        Time</label>
                                                    <input type='text' name='pick_up_time' id='hq-form-pick_up_time_cars'
                                                           class='hq-smart-input-picker elementor-field elementor-size-sm elementor-field-textual flatpickr-input'
                                                           placeholder='8:00' required='required'
                                                           readonly='readonly'>
                                                </div>
                                                <div class='hq-smart-form-element-wrapper elementor-field-type-time elementor-field-group elementor-column elementor-field-group-field_2fcfe93 elementor-col-50 elementor-field-required'>
                                                    <label for='form-field-field_2fcfe93'
                                                           class='elementor-field-label hq-smart-label'>Return
                                                        Time</label>
                                                    <input type='text' name='return_time' id='hq-form-return_time_cars'
                                                           class='hq-smart-input-picker elementor-field elementor-size-sm elementor-field-textual flatpickr-input'
                                                           placeholder='8:00' required='required'
                                                           readonly='readonly'>
                                                </div>
                                                <div class='hq-smart-form-element-wrapper elementor-field-group elementor-column elementor-field-type-submit elementor-col-100'>
                                                    <button type='submit'
                                                            class='elementor-button elementor-size-sm'>
                                       <span>
                                       <span class='elementor-button-icon'></span>
                                       <span class='elementor-button-text'>Find a Car</span>
                                       </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                ";      
            }
            echo $html;
        }
    }
}
