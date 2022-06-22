<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsElementor\HQRentalsElementorAssetsHandler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesLocations;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsPlacesReservationForm
{
    /*
     [hq_bakery_places_reservation_form
        reservation_url_places_form="/reservations/"
        support_for_custom_location="true"
        custom_location_label="La Paz (Additional Charge 180 USD)"
        minimum_rental_period="2"
        google_country="mx"
        orientation_places_form="horizontal"
    ]
     * */
    private $linkURL;
    private $orientation;
    private $supportForCustomLocation;
    private $customLocationLabel;
    private $minimumRental;
    private $googleCountry;
    private $mapCenter;
    private $mapCenterRadius;

    public function __construct()
    {
        $this->settings = new HQRentalsSettings();
        $this->assets =new HQRentalsAssetsHandler();
        $this->front = new HQRentalsFrontHelper();
        add_shortcode('hq_rentals_places_reservation_form', array($this, 'renderShortcode'));
    }

    public function renderShortcode($params = [])
    {
        //[hq_rentals_places_reservation_form reservation_url_places_form="/reservations/" title="Places Form" support_for_custom_location="true" custom_location_label="Address" minimum_rental_period="2" google_country="syc" orientation_places_form="horizontal"]
        $this->linkURL = !empty($params['reservation_url_places_form']) ? $params['reservation_url_places_form'] : '';
        $this->orientation = !empty($params['orientation_places_form']) ? $params['orientation_places_form'] : '';
        $this->supportForCustomLocation = !empty($params['support_for_custom_location']) ? $params['support_for_custom_location'] : "false";
        $this->customLocationLabel = !empty($params['custom_location_label']) ? $params['custom_location_label'] : '';
        $this->minimumRental = !empty($params['minimum_rental_period']) ? $params['minimum_rental_period'] : 1;
        $this->googleCountry = !empty($params['google_country']) ? $params['google_country'] : 'us';
        $this->mapCenter = !empty($params['google_map_center']) ? $params['google_map_center'] : '';
        $this->mapCenterRadius = !empty($params['google_map_center_radius']) ? $params['google_map_center_radius'] : '';
        $key = $this->settings->getGoogleAPIKey();
        $this->assets->loadPlacesReservationAssets();
        $html = "";
        $minimumRental = "
            <script>
                var minimumDayRentals = ". $this->minimumRental .";
                var googleCountry = '". $this->googleCountry ."';
                var googleMapCenter = '". $this->mapCenter ."';
                var googleMapAddressRadius = '". $this->mapCenterRadius ."';
            </script>
        ";
        if(empty($key)){
            echo "<p>Add Google Key</p>";
        }else{
            if($this->orientation == 'horizontal'){
                $html = HQRentalsAssetsHandler::getHQFontAwesomeForHTML() . $minimumRental ."
            <div id='hq-place-form-desktop' class=''>
               <div id='hq-form-wrapper' class=''>
                  <form id='hq-form' method='get' action='{$this->linkURL}'>
                     <div class='hq-places-inner-wrapper'>
                        <div class='hq-places-input-wrapper'>
                            <div class='hq-places-input-inner-wrapper'>
                                <div class='hq-places-label-wrapper'>
                                    <label class='hq-places-label'>PICK UP LOCATION</label> 
                                </div>
                                <div>
                                    <select name='pick_up_location' id='hq-pick-up-location'>
                                        {$this->front->getLocationOptions()}
                                        {$this->resolveCustomLocation()}
                                    </select>
                                </div>
                            </div>
                            <div class='hq-pickup-custom-location'>
                                <input type='text' name='pick_up_location_custom' class='hq-places-auto-complete' id='pick-up-location-custom'>
                            </div>
                        </div>
                        <div class='hq-places-input-wrapper'>
                            <div class='hq-places-label-wrapper'>
                                <label class='hq-places-label'>FROM</label> 
                            </div>
                            <div class='hq-places-date-time-wrapper'>
                                <div class='hq-places-times-input-wrapper'>
                                    <input type='text' name='pick_up_date' class='hq-places-auto-complete' id='hq-times-pick-up-date'>
                                    <span class='hq-select-icon-wrapper'><i class='fas fa-clock'></i></span>
                                </div>
                            </div>
                        </div>
                        <div class='hq-places-input-wrapper'>
                            <div class='hq-placles-input-inner-wrapper'>
                                <div class='hq-places-label-wrapper'>
                                    <label class='hq-places-label'>RETURN LOCATION</label> 
                                </div>
                                <div>
                                    <select name='return_location' id='hq-return-location'>
                                        {$this->front->getLocationOptions()}
                                        {$this->resolveCustomLocation()}
                                    </select>
                                </div>
                            </div>
                            <div class='hq-return-custom-location'>
                                <input type='text' name='return_location_custom' class='hq-places-auto-complete' id='return-location-custom'>
                            </div>
                        </div>
                        <div class='hq-places-input-wrapper'>
                            <div class='hq-places-label-wrapper'>
                                <label class='hq-places-label'>UNTIL</label> 
                            </div>
                            <div class='hq-places-date-time-wrapper'>
                                <div class='hq-places-times-input-wrapper'>
                                    <input type='text' name='return_date' class='hq-places-auto-complete' id='hq-times-return-date'>
                                    <span class='hq-select-icon-wrapper'><i class='fas fa-clock'></i></span>
                                </div>
                            </div>
                        </div>
                        <div class='hq-places-input-wrapper hq-button-wrapper'>
                            <input type='hidden' name='target_step' value='2'>
                            <button type='submit' class='hq-places-submit-button'>Book Now</button>    
                        </div>
                     </div>
                  </form>
               </div>
            </div>  
        ";
        }else{
                $html = "
                <style>
                    .hq-places-vertical-form-wrapper{
                        background-color: #fff;
                        padding:20px;
                        border-radius:5px;  
                        
                    }
                    .hq-places-date-time-wrapper-vertical{
                        display: flex;
                        flex-direction: row;
                    }
                    .hq-submit-button{
                        display: inline-block;
                        line-height: 1;
                        background-color: #818a91;
                        font-size: 15px;
                        padding: 12px 24px;
                        -webkit-border-radius: 3px;
                        border-radius: 3px;
                        color: #fff;
                        fill: #fff;
                        text-align: center;
                        width: 100%;
                        background-color: #1D71B8 !important;
                        box-shadow: 0 0px 0 #000000 !important;
                    }
                    .hq-places-dates-wrapper-vertical{
                        position: relative !important;
                        flex:1;
                    }
                    .hq-select-icon-wrapper-vertical{
                        position: absolute;
                        top: 0;
                        margin-top: 15px;
                        margin-right: 15px;
                        right:0;
                    }
                    .hq-places-vertical-button-wrapper{
                        margin-top: 20px;  
                    }
                    .hq-places-vertical-form-item-wrapper{
                        margin-top: 10px;
                        margin-bottom: 10px;
                    }
                    .hq-places-vertical-form-item-wrapper label{
                        font-weight: bold;
                    }
                    .hq-places-vertical-form-wrapper {
                        box-shadow:-2px 15px 18px 6px rgba(0,0,0,.30);
                      }
                    b{
                    display: none;
                    }
                    .hq-palces-vertical-select{
                        width: 100%;
                        min-height: 50px;
                    }
                </style>
            ". HQRentalsAssetsHandler::getHQFontAwesomeForHTML() . $minimumRental  ."
                    <div class='hq-places-vertical-form-wrapper'>
                        <div class=''>
                            <div class=''>
                                <div class=''>
                                    <div class=''>
                                        <form method='get' name='Booking' action='{$this->linkURL}'>
                                            <div class=''>
                                                <div class='hq-places-vertical-form-item-wrapper'>
                                                    <label for='form-field-location'
                                                           class='hq-smart-label'>Pickup Location</label>
                                                    <div class='hq-places-dates-wrapper-vertical'>
                                                        <select name='pick_up_location' id='hq-pick-up-location'>
                                                            {$this->front->getLocationOptions()}
                                                            {$this->resolveCustomLocation()}
                                                        </select>
                                                        <span class='hq-select-icon-wrapper-vertical'><i class='fas fa-map-marked-alt'></i></span>
                                                    </div>
                                                </div>
                                                <div class='hq-places-vertical-form-item-wrapper'>
                                                    <label for='form-field-location'
                                                           class='hq-smart-label'>Return Location</label>
                                                    <div class='hq-places-dates-wrapper-vertical'>
                                                        <select name='return_location' id='hq-return-location'>
                                                            {$this->front->getLocationOptions()}
                                                            {$this->resolveCustomLocation()}
                                                        </select>
                                                        <span class='hq-select-icon-wrapper-vertical'><i class='fas fa-map-marked-alt'></i></span>
                                                    </div>
                                                </div>
                                                <div class='hq-places-vertical-form-item-wrapper hq-places-vertical-form-dates-wrapper'>
                                                      <div>
                                                            <label class='hq-places-label'>From</label> 
                                                        </div>
                                                        <div class='hq-places-date-time-wrapper-vertical'>
                                                            <div class='hq-places-times-input-wrapper hq-places-dates-wrapper-vertical'>
                                                                <input type='text' name='pick_up_date' class='hq-places-auto-complete' placeholder='Today' id='hq-times-pick-up-date' required='required'>
                                                                <span class='hq-select-icon-wrapper-vertical'><i class='fas fa-calendar-alt'></i></span>
                                                            </div>
                                                            <div class='hq-places-times-input-wrapper hq-places-dates-wrapper-vertical'>
                                                                <input type='text' name='pick_up_time' class='hq-places-auto-complete' placeholder='12:00' id='hq-times-pick-up-time' required='required'>
                                                                <span class='hq-select-icon-wrapper-vertical'><i class='fas fa-clock'></i></span>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class='hq-places-vertical-form-item-wrapper hq-places-vertical-form-dates-wrapper'>
                                                      <div>
                                                            <label class='hq-places-label'>Until</label> 
                                                        </div>
                                                        <div class='hq-places-date-time-wrapper-vertical'>
                                                            <div class='hq-places-times-input-wrapper hq-places-dates-wrapper-vertical'>
                                                                <input type='text' name='return_date' class='hq-places-auto-complete' placeholder='Tomorrow' id='hq-times-return-date' required='required'>
                                                                <span class='hq-select-icon-wrapper-vertical'><i class='fas fa-calendar-alt'></i></span>
                                                            </div>
                                                            <div class='hq-places-times-input-wrapper hq-places-dates-wrapper-vertical'>
                                                                <input type='text' name='return_time' class='hq-places-auto-complete' placeholder='12:00' id='hq-times-return-time' required='required'>
                                                                <span class='hq-select-icon-wrapper-vertical'><i class='fas fa-clock'></i></span>
                                                            </div>
                                                        </div>
                                                </div>
                                                <div class='hq-places-vertical-button-wrapper'>
                                                    <button type='submit'
                                                            class='hq-submit-button'>
                                                           <span>
                                                           <span class='elementor-button-icon'></span>
                                                           <span class='elementor-button-text'>Book Now</span>
                                                           </span>
                                                    </button>
                                                    <input type='hidden' name='target_step' value='2'>
                                                    <input type='hidden' name='pick_up_location' value='custom'>
                                                    <input type='hidden' name='return_location' value='custom'>
                                                    <input type='hidden' name='return_location_custom' value='' id='hq-return-location-custom'>
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
        }
        return $html;
    }
    public function resolveCustomLocation() : string
    {
        if($this->supportForCustomLocation === 'true'){
            return "<option value='custom'>{$this->customLocationLabel}</option>";
        }
        return '';
    }
}
