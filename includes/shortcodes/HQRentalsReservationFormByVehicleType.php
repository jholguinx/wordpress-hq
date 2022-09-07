<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;

class HQRentalsReservationFormByVehicleType implements HQShortcodeInterface
{
    public function __construct()
    {
        $this->front = new HQRentalsFrontHelper();
        $this->queryVehicle = new HQRentalsDBQueriesVehicleClasses();
        $this->locationQuery = new HQRentalsDBQueriesLocations();
        $this->assets = new HQRentalsAssetsHandler();
        add_shortcode('hq_rentals_reservation_form_vehicle_types', array($this, 'renderShortcode'));
    }

    public function renderShortcode($atts): string
    {
        $this->assets->loadDatePickersReservationAssets(true);
        $atts = shortcode_atts(
            array(
                'reservation_url' => '',
            ), $atts);
        return "
        <link rel='preconnect' href='https://fonts.googleapis.com'>
        <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
        <link href='https://fonts.googleapis.com/css2?family=Poppins&display=swap' rel='stylesheet'>
        <div id='hq-reservation-vehicle-type'>
           <form method='get' action='". $atts['reservation_url'] ."'>
                <div class='hq-types-form-inner-wrapper'> 
                    <div class='hq-types-form-field-wrapper'>
                        <div class='hq-types-form-label-wrapper'>
                            <label for='hq-type-vehicle-type'>Vehicle</label>
                        </div>
                        <div class='hq-types-form-input-wrapper'>
                            <select id='hq-type-vehicle-type'>
                                {$this->resolveTypes()}
                            </select>
                        </div>
                    </div>
                    {$this->resolveLocations()}
                    <div class='hq-types-dates'>
                        <div class='hq-types-form-field-wrapper-date'>
                            <div class='hq-types-form-label-wrapper'>
                                <label for='hq-type-vehicle-type'>Pick-up Date</label>
                            </div>
                            <div class='hq-types-form-input-wrapper'>
                                <input id='hq_pick_up_date' name='pick_up_date' />
                            </div>
                        </div>
                        <div class='hq-types-form-field-wrapper-time'>
                            <div class='hq-types-form-label-wrapper'>
                                <label for='hq-type-vehicle-type'>Pick-up Time</label>
                            </div>
                            <div class='hq-types-form-input-wrapper'>
                                <select id='hq-type-vehicle-type' name='pick_up_time'>
                                    {$this->front->getTimesForDropdowns('00:00','23:50','12:00','+15 minutes')}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class='hq-types-dates'>
                        <div class='hq-types-form-field-wrapper-date'>
                            <div class='hq-types-form-label-wrapper'>
                                <label for='hq-type-vehicle-type'>Return Date</label>
                            </div>
                            <div class='hq-types-form-input-wrapper'>
                                <input id='hq_return_date' name='return_date' />
                            </div>
                        </div>
                        <div class='hq-types-form-field-wrapper-time'>
                            <div class='hq-types-form-label-wrapper'>
                                <label for='hq-type-vehicle-type'>Return Time</label>
                            </div>
                            <div class='hq-types-form-input-wrapper'>
                                <select id='hq-type-vehicle-type' name='return_time'>
                                    {$this->front->getTimesForDropdowns('00:00','23:50','12:00','+15 minutes')}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class='hq-types-button-wrapper'>
                        <button type='submit'>Book a Car</button>
                        <input type='hidden' name='target_step' value='2' />
                    </div>
                </div>
           </form>
        </div>
        <style>
        #hq-reservation-vehicle-type{
            background-color: #fff;
            border-radius: 10px;
            padding: 40px 30px;
        }
        #hq-reservation-vehicle-type input,
        #hq-reservation-vehicle-type select{
            height: 40px;
            border-radius: 5px;
            border:1px solid #dedede;
            max-width: 100%;
            font-family: Poppins,Helvetica;
            font-size: 16px;
            padding-left: 20px;
        }
        #hq-reservation-vehicle-type label,
        #hq-reservation-vehicle-type button{
            font-family: Poppins,Helvetica;
            font-size: 16px;
        }
        #hq-reservation-vehicle-type label{
            color: #54595F;
        }
        #hq-reservation-vehicle-type button{
            color: #fff;
        }
        
        .hq-types-button-wrapper{
            
        }
        .hq-types-button-wrapper button{
            width: 100%;
        }
        .hq-types-form-field-wrapper{
            display: flex;
            flex-direction: column;
            padding:0 0 30px 0 !important;
        }
        .hq-types-dates{
            padding-bottom:30px !important;
        }
        .hq-types-dates{
            display: flex; 
            flex-direction: row;
        }
        .hq-types-form-field-wrapper-date{
            display: flex;
            flex:1;
            flex-direction: column;
            width:50%;
        }
        
        .hq-types-form-field-wrapper-time{
            display: flex;
            flex:1;
            flex-direction: column;
            width:40%;
            margin-left: 20px;
        }
        </style>
        ";
    }
    private function resolveLocations() : string
    {
        $locs = $this->locationQuery->allLocations();
        if(count($locs) == 1){
          return "
            <input type='hidden' name='pick_up_location' value='{$locs[0]->getId()}' />
            <input type='hidden' name='return_location' value='{$locs[0]->getId()}' />
          ";
        }else{
            $options = "";
            foreach ($locs as $loc){
                $options .= "<option value='{$loc->getId()}'>{$loc->getLabelForWebsite()}</option>";
            }
            return "
            <div class='hq-types-form-field-wrapper'>
                <div class='hq-types-form-label-wrapper'>
                    <label for='hq-pickup-location'>Pickup Location</label>
                </div>
                <div class='hq-types-form-input-wrapper'>
                    <select id='hq-pickup-location' name='pick_up_location'>
                        {$options}
                    </select>
                </div>
            </div>
            <div class='hq-types-form-field-wrapper'>
                <div class='hq-types-form-label-wrapper'>
                    <label for='hq-return-location'>Vehicle</label>
                </div>
                <div class='hq-types-form-input-wrapper'>
                    <select id='hq-return-location' name='return_location'>
                        {$options}
                    </select>
                </div>
            </div>
        ";
        }

    }
    private function getLocationOptions(): string
    {
        return $this->front->getLocationOptions();
    }
    private function resolveTypes() : string
    {
        $html = '';
        $fields = $this->queryVehicle->getAllCustomFields();
        foreach ($fields as $field){
            $html .= "<option value='{$field}'>{$field}</option>";
        }
        return $html;
    }
}
