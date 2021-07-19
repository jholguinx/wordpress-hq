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
            echo "<p>Add Google Key</p>";
        }else{
            if($this->orientation == 'horizontal'){
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
                </style>
            ". HQRentalsAssetsHandler::getHQFontAwesome() ."
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
                                                        <input type='text' name='pick_up_location_custom' id='hq-places-field' class='hq-places-auto-complete' placeholder='Address' required='required'>
                                                        <span class='hq-select-icon-wrapper-vertical'><i class='fas fa-map-marked-alt'></i></span>
                                                    </div>
                                                </div>
                                                <div class='hq-places-vertical-form-item-wrapper'>
                                                    <label for='form-field-location'
                                                           class='hq-smart-label'>Vehicle Type</label>
                                                    <div class='hq-places-dates-wrapper-vertical'>
                                                        <select name='vehicle_type' placeholder='Vehicle, Bike or Scooter'>
                                                            <option value='vehicle'>Vehicle</option>
                                                            <option value='scooter'>Scooter</option>
                                                            <option value='bike'>Bike</option>
                                                        </select>
                                                        <span class='hq-select-icon-wrapper-vertical'><i class='fas fa-chevron-down'></i></span>
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
}
