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

    public function __construct($params)
    {
        if (!empty($params['url'])) {
            $this->linkURL = $params['url'];
        }
        if (!empty($params['title'])) {
            $this->title = $params['title'];
        }
        $this->settings = new HQRentalsSettings();
        $this->assets =new HQRentalsAssetsHandler();
        add_shortcode('hq_rentals_places_reservation_form', array($this, 'renderShortcode'));
    }

    public function renderShortcode()
    {
        $key = $this->settings->getGoogleAPIKey();
        $this->assets->loadPlacesReservationAssets();
        if(empty($key)){
            return "<p>Add Google Key</p>";
        }else{
            $html = "
            <style>
                .hq-places-inner-wrapper{
                    display: flex;
                    flex-direction: row;
                    justify-content: space-around;
                    align-items: flex-end;
                    flex: 1;
                    width: 100%;
                }
                .hq-places-input-wrapper{
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: flex-start;
                }
                #hq-place-form-desktop{
                    width: 100%;
                    display: flex;
                    justify-content: center; 
                }
                #hq-form-wrapper{
                    background-color: #fff;
                    border-radius: 10px;
                    width: 100%;
                    max-width: 1440px;
                    padding:20px
                }
                .hq-places-date-time-wrapper{
                    display: flex;
                    position
                }
                .hq-select-icon-wrapper{
                    position: absolute;
                    right: 0;
                    top: 0;
                    bottom: 0;
                    margin-right: 18px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                .hq-places-times-input-wrapper{
                    position: relative;
                }
                .hq-places-label{
                    font-size: 14px;
                    font-weight: bold;
                    font-family: inherit;
                }
            </style>
            ". HQRentalsAssetsHandler::getHQFontAwesome() ."
            
            
            <div id='hq-place-form-desktop' class=''>
               <div id='hq-form-wrapper' class=''>
                  <form id='hq-form' class='' method='get' action='{$this->linkURL}}'>
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
                        <div class='hq-places-input-wrapper'>
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
            $html_mobile = "
            <div id='hq-mobile'><div class='elementor-element elementor-element-b2b3f84 mobile-tabs elementor-hidden-desktop elementor-tabs-view-horizontal elementor-widget elementor-widget-tabs' data-id='b2b3f84' data-element_type='widget' data-widget_type='tabs.default'><div class='elementor-widget-container'><div class='elementor-tabs' role='tablist'><div class='elementor-tabs-wrapper'><div id='elementor-tab-title-1871' class='elementor-tab-title elementor-tab-desktop-title elementor-active' data-tab='1' role='tab' aria-controls='elementor-tab-content-1871'><a href=''>🛵 Motorbikes</a></div><div id='elementor-tab-title-1872' class='elementor-tab-title elementor-tab-desktop-title' data-tab='2' role='tab' aria-controls='elementor-tab-content-1872'><a href=''>🚙 Cars</a></div><div id='elementor-tab-title-1873' class='elementor-tab-title elementor-tab-desktop-title' data-tab='3' role='tab' aria-controls='elementor-tab-content-1873'><a href=''>🚲 Bikes</a></div></div><div class='elementor-tabs-content-wrapper'><div class='elementor-tab-title elementor-tab-mobile-title elementor-active' data-tab='1' role='tab'>🛵 Motorbikes</div><div id='elementor-tab-content-1871' class='elementor-tab-content elementor-clearfix elementor-active' data-tab='1' role='tabpanel' aria-labelledby='elementor-tab-title-1871' style='display: block;'><div data-elementor-type='section' data-elementor-id='250' class='elementor elementor-250'><div class='elementor-inner'><div class='elementor-section-wrap'><section class='elementor-element elementor-element-1eefe744 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section'><div class='elementor-container elementor-column-gap-default'><div class='elementor-row'><div class='elementor-element elementor-element-4b614e6 elementor-column elementor-col-100 elementor-top-column' data-id='4b614e6' data-element_type='column'><div class='elementor-column-wrap elementor-element-populated'><div class='elementor-widget-wrap'><div class='elementor-element elementor-element-2cd2903b elementor-hidden-desktop elementor-hidden-tablet mobile-booking elementor-button-align-stretch elementor-widget elementor-widget-form'><div class='elementor-widget-container'><form class='elementor-form' method='get' action='/motorbike-rental/'><div class='elementor-form-fields-wrapper elementor-labels-above'><div class='elementor-field-type-select elementor-field-group elementor-column elementor-field-group-field_c66f54e elementor-col-50 elementor-sm-50'> <label for='form-field-field_c66f54e' class='elementor-field-label'>PICK UP LOCATION</label><div class='elementor-field elementor-select-wrapper '> <select id='hq-pickup-location_motos' name='pick_up_location' class='elementor-field-textual elementor-size-sm'><option value='2'>Cala Ferrera</option><option value='3'>Central – Cala d’Or</option> </select></div></div><div class='elementor-field-type-select elementor-field-group elementor-column elementor-field-group-field_3333ab6 elementor-col-50 elementor-sm-50'> <label for='form-field-field_3333ab6' class='elementor-field-label'>RETURN LOCATION</label><div class='elementor-field elementor-select-wrapper '> <select id='hq-return-location_motos' name='return_location' class='elementor-field-textual elementor-size-sm'><option value='2'>Cala Ferrera</option><option value='3'>Central – Cala d’Or</option> </select></div></div><div class='elementor-field-type-date elementor-field-group elementor-column elementor-col-50 elementor-sm-50'> <label class='elementor-field-label'>PICK UP DATE</label> <input id='hq-form-pick_up_date_motos' type='text' name='pick_up_date' class='elementor-field elementor-size-sm elementor-field-textual flatpickr-input' placeholder='Today' readonly='readonly'></div><div class='elementor-field-type-time elementor-field-group elementor-column elementor-field-group-email elementor-col-50 elementor-sm-50 elementor-field-required'> <label for='form-field-email' class='elementor-field-label'>PICK UP TIME</label> <input type='text' name='pick_up_time' id='hq-form-pick_up_time_motos' class='elementor-field elementor-size-sm elementor-field-textual flatpickr-input active' placeholder='03:30PM' required='required' aria-required='true' readonly='readonly'></div><div class='elementor-field-type-date elementor-field-group elementor-column elementor-field-group-field_655c2ba elementor-col-50 elementor-sm-50'> <label class='elementor-field-label'>RETURN DATE</label><input type='text' name='return_date' id='hq-form-return_date_motos' class='elementor-field elementor-size-sm elementor-field-textual flatpickr-input active' placeholder='Tomorrow' readonly='readonly'></div><div class='elementor-field-type-time elementor-field-group elementor-column elementor-field-group-field_d76b75b elementor-col-50 elementor-sm-50 elementor-field-required'> <label for='form-field-field_d76b75b' class='elementor-field-label'>RETURN TIME</label><input type='text' name='return_time' id='hq-form-return_time_motos' class='elementor-field elementor-size-sm elementor-field-textual elementor-time-field flatpickr-input' placeholder='4:00PM' required='required' aria-required='true' readonly='readonly'></div><div class='elementor-field-group elementor-column elementor-field-type-submit elementor-col-100 e-form__buttons'> <input type='hidden' name='target_step' value='2'> <button type='submit' class='elementor-button elementor-size-md'> <span><span class=' elementor-button-icon'></span><span class='elementor-button-text'>SEARCH</span></span> </button></div></div></form></div></div></div></div></div></div></div></section></div></div></div></div><div class='elementor-tab-title elementor-tab-mobile-title' data-tab='2' role='tab'>🚙 Cars</div><div id='elementor-tab-content-1872' class='elementor-tab-content elementor-clearfix' data-tab='2' role='tabpanel' aria-labelledby='elementor-tab-title-1872'><div data-elementor-type='section' data-elementor-id='250' class='elementor elementor-250'><div class='elementor-inner'><div class='elementor-section-wrap'><section class='elementor-element elementor-element-1eefe744 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section' data-id='1eefe744' data-element_type='section'><div class='elementor-container elementor-column-gap-default'><div class='elementor-row'><div class='elementor-element elementor-element-4b614e6 elementor-column elementor-col-100 elementor-top-column' data-id='4b614e6' data-element_type='column'><div class='elementor-column-wrap elementor-element-populated'><div class='elementor-widget-wrap'><div class='elementor-element elementor-element-2cd2903b elementor-hidden-desktop elementor-hidden-tablet mobile-booking elementor-button-align-stretch elementor-widget elementor-widget-form'><div class='elementor-widget-container'><form class='elementor-form' method='get' action='/car-rental/'><div class='elementor-form-fields-wrapper elementor-labels-above'><div class='elementor-field-type-select elementor-field-group elementor-column elementor-field-group-field_c66f54e elementor-col-50 elementor-sm-50'> <label for='form-field-field_c66f54e' class='elementor-field-label'>PICK UP LOCATION</label><div class='elementor-field elementor-select-wrapper '> <select id='hq-pickup-location_cars' name='pick_up_location' class='elementor-field-textual elementor-size-sm'><option value='4'>Cala Ferrera</option><option value='6'>Central – Cala d’Or</option><option value='5'>Airport</option> </select></div></div><div class='elementor-field-type-select elementor-field-group elementor-column elementor-field-group-field_3333ab6 elementor-col-50 elementor-sm-50'> <label class='elementor-field-label'>RETURN LOCATION</label><div class='elementor-field elementor-select-wrapper '> <select id='hq-return-location_cars' name='return_location' class='elementor-field-textual elementor-size-sm'><option value='4'>Cala Ferrera</option><option value='6'>Central – Cala d’Or</option><option value='5'>Airport</option> </select></div></div><div class='elementor-field-type-date elementor-field-group elementor-column elementor-field-group-field_abc1c3b elementor-col-50 elementor-sm-50'> <label class='elementor-field-label'>PICK UP DATE</label><input type='text' name='pick_up_date' id='hq-form-pick_up_date_cars' class='elementor-field elementor-size-sm elementor-field-textual flatpickr-input' placeholder='Today' readonly='readonly'></div><div class='elementor-field-type-time elementor-field-group elementor-column elementor-field-group-email elementor-col-50 elementor-sm-50 elementor-field-required'> <label for='form-field-email' class='elementor-field-label'>PICK UP TIME</label><input type='text' name='pick_up_time' id='hq-form-pick_up_time_cars' class='elementor-field elementor-size-sm elementor-field-textual flatpickr-input' required='required' readonly='readonly'></div><div class='elementor-field-type-date elementor-field-group elementor-column elementor-field-group-field_655c2ba elementor-col-50 elementor-sm-50'> <label for='form-field-field_655c2ba' class='elementor-field-label'>RETURN DATE</label><input type='text' name='return_date' id='hq-form-return_date_cars' class='elementor-field elementor-size-sm elementor-field-textual flatpickr-input' readonly='readonly'></div><div class='elementor-field-type-time elementor-field-group elementor-column elementor-field-group-field_d76b75b elementor-col-50 elementor-sm-50 elementor-field-required'> <label class='elementor-field-label'>RETURN TIME</label><input type='text' name='return_time' id='hq-form-return_time_cars' class='elementor-field elementor-size-sm elementor-field-textual flatpickr-input' required='required' readonly='readonly'></div><div class='elementor-field-group elementor-column elementor-field-type-submit elementor-col-100 e-form__buttons'> <input type='hidden' name='target_step' value='2'> <button type='submit' class='elementor-button elementor-size-md'> <span><span class=' elementor-button-icon'></span><span class='elementor-button-text'>SEARCH</span></span> </button></div></div></form></div></div></div></div></div></div></div></section></div></div></div></div><div class='elementor-tab-title elementor-tab-mobile-title' data-tab='3' role='tab'>🚲 Bikes</div><div id='elementor-tab-content-1873' class='elementor-tab-content elementor-clearfix' data-tab='3' role='tabpanel' aria-labelledby='elementor-tab-title-1873'><div data-elementor-type='section' data-elementor-id='250' class='elementor elementor-250'><div class='elementor-inner'><div class='elementor-section-wrap'><section class='elementor-element elementor-element-1eefe744 elementor-section-boxed elementor-section-height-default elementor-section-height-default elementor-section elementor-top-section' data-id='1eefe744' data-element_type='section'><div class='elementor-container elementor-column-gap-default'><div class='elementor-row'><div class='elementor-element elementor-element-4b614e6 elementor-column elementor-col-100 elementor-top-column' data-id='4b614e6' data-element_type='column'><div class='elementor-column-wrap elementor-element-populated'><div class='elementor-widget-wrap'><div class='elementor-element elementor-element-2cd2903b elementor-hidden-desktop elementor-hidden-tablet mobile-booking elementor-button-align-stretch elementor-widget elementor-widget-form'><div class='elementor-widget-container'><form class='elementor-form' method='get' action='/bicycle-rental/'><div class='elementor-form-fields-wrapper elementor-labels-above'><div class='elementor-field-type-select elementor-field-group elementor-column elementor-field-group-field_c66f54e elementor-col-50 elementor-sm-50'> <label for='form-field-field_c66f54e' class='elementor-field-label'>PICK UP LOCATION</label><div class='elementor-field elementor-select-wrapper '> <select id='hq-pickup-location_bikes' name='pick_up_location' class='elementor-field-textual elementor-size-sm'><option value='7'>Cala Ferrera</option><option value='8'>Central – Cala d’Or</option> </select></div></div><div class='elementor-field-type-select elementor-field-group elementor-column elementor-field-group-field_3333ab6 elementor-col-50 elementor-sm-50'> <label class='elementor-field-label'>RETURN LOCATION</label><div class='elementor-field elementor-select-wrapper '> <select id='hq-return-location_bikes' name='return_location' class='elementor-field-textual elementor-size-sm'><option value='7'>Cala Ferrera</option><option value='8'>Central – Cala d’Or</option> </select></div></div><div class='elementor-field-type-date elementor-field-group elementor-column elementor-field-group-field_abc1c3b elementor-col-50 elementor-sm-50'> <label class='elementor-field-label'>PICK UP DATE</label> <input type='text' name='pick_up_date' id='hq-form-pick_up_date_bikes' class='elementor-field elementor-size-sm elementor-field-textual flatpickr-input' readonly='readonly'></div><div class='elementor-field-type-time elementor-field-group elementor-column elementor-field-group-email elementor-col-50 elementor-sm-50 elementor-field-required'> <label for='form-field-email' class='elementor-field-label'>PICK UP TIME</label><input type='text' name='pick_up_time' id='hq-form-pick_up_time_bikes' class='elementor-field elementor-size-sm elementor-field-textual flatpickr-input' required='required' readonly='readonly'></div><div class='elementor-field-type-date elementor-field-group elementor-column elementor-field-group-field_655c2ba elementor-col-50 elementor-sm-50'> <label for='form-field-field_655c2ba' class='elementor-field-label'>RETURN DATE</label><input type='text' name='return_date' id='hq-form-return_date_bikes' class='elementor-field elementor-size-sm elementor-field-textual flatpickr-input' readonly='readonly'></div><div class='elementor-field-type-time elementor-field-group elementor-column elementor-field-group-field_d76b75b elementor-col-50 elementor-sm-50 elementor-field-required'> <label for='form-field-field_d76b75b' class='elementor-field-label'>RETURN TIME</label><input type='text' name='return_time' id='hq-form-return_time_bikes' class='elementor-field elementor-size-sm elementor-field-textual flatpickr-input' required='required' readonly='readonly'></div><div class='elementor-field-group elementor-column elementor-field-type-submit elementor-col-100 e-form__buttons'> <input type='hidden' name='target_step' value='2'> <button type='submit' class='elementor-button elementor-size-md'> <span><span class=' elementor-button-icon'></span><span class='elementor-button-text'>SEARCH</span></span> </button></div></div></form></div></div></div></div></div></div></div></section></div></div></div></div></div></div></div></div></div>
        ";
            echo $html;
        }

    }
}
