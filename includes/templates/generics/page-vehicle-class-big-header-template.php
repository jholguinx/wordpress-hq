<?php

use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;
use \HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use \HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesLocations;
use \HQRentalsPlugin\HQRentalsHelpers\HQRentalsFrontHelper;
use HQRentalsPlugin\HQRentalsVendor\Carbon;
$vehicleId = $_GET['id'];
$queryLocations = new HQRentalsDBQueriesLocations();
if(empty($vehicleId)){
    wp_redirect(home_url());
    exit;
}
$query = new HQRentalsDBQueriesVehicleClasses();
$vehicle = $query->getVehicleClassById($vehicleId);
$helper = new HQRentalsFrontHelper();
$optionsLocations = $helper->getLocationOptions();
$assets = new HQRentalsAssetsHandler();
$assets->loadDatePickersReservationAssets();
get_header();
?>
    <?php HQRentalsAssetsHandler::getHQFontAwesome(); ?>
    <style>
        #page_caption {
            min-height: 500px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        #page_content_wrapper{
            max-width: 1200px;
            margin: auto;
            display: flex;
        }
        #page_content_wrapper .inner .sidebar_content {
            margin-top: 40px !important;
        }

        #page_caption {
            margin-bottom: 0px !important;
        }

        .hq-feature-wrapper {
            display: flex;
            flex: 1;
            align-items: center;
            justify-content: center;
            width: 20% !important;
        }

        .single_car_attribute_wrapper .car_attribute_content {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hq-feature-wrapper .car_attribute_content {
            margin-left: 20px;
        }

        .feature-wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }

        .hq-inputs {
            width: 100%;
        }

        label {
            text-align: left;
        }

        #portfolio_filter_wrapper .car_attribute_wrapper {
            width: 60% !important;
        }

        #portfolio_filter_wrapper .car_attribute_price {
            width: 40% !important;
        }

        .car_attribute_price_day.three_cols .single_car_price {
            font-size: 34px !important;
        }

        .single_car_attribute_wrapper .fa, .single_car_attribute_wrapper .fas, .single_car_attribute_wrapper .fab {
            font-size: 30px !important;
        }

        .wrapper {
            max-width: 1425px;
            width: 100%;
            box-sizing: border-box;
            margin: auto;
            padding: 0 90px;
            height: 100%;
        }

        @media only screen and (max-width: 960px) and (min-width: 768px) {
            .portfolio_info_wrapper {
                display: flex;
                flex: 1;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }

            .portfolio_info_wrapper div, #portfolio_filter_wrapper .car_attribute_wrapper, #portfolio_filter_wrapper .car_attribute_price {
                width: 100% !important;
            }

            .wrapper {
                width: 100%;
                margin-top: 0;
                padding: 0 30px 0 30px;
                box-sizing: border-box;
            }

        }

        @media only screen and (max-width: 1099px) and (min-width: 960px) {
            .wrapper {
                width: 100%;
                margin-top: 0;
                padding: 0 30px 0 30px;
                box-sizing: border-box;
            }

            .car_attribute_price_day.three_cols .single_car_price {
                font-size: 25px !important;
            }
        }

        @media only screen and (max-width: 767px) {
            .wrapper {
                width: 100%;
                margin-top: 0;
                padding: 0 30px 0 30px;
                box-sizing: border-box;
            }

            #portfolio_filter_wrapper .car_attribute_price, #portfolio_filter_wrapper .car_attribute_wrapper {
                width: 50% !important;
            }

            h4 {
                font-size: 18px !important;
            }

            .single_car_attribute_wrapper .one_fourth, .single_car_attribute_wrapper .one_fourth.last {
                width: 50% !important;
                clear: none;
                text-align: left;
            }
        }

        .hq-feature-wrapper {
            display: flex;
            flex: 1;
            align-items: center;
            justify-content: center;
        }

        .single_car_attribute_wrapper .fa, .single_car_attribute_wrapper .fas, .single_car_attribute_wrapper .fab {
            line-height: 1.5;
        }

        .inner {
            padding-bottom: 50px;
        }

        #portfolio_filter_wrapper .car_unit_day {
            margin-top: -15px !important;
            font-size: 11px !important;
        }

        #portfolio_filter_wrapper .single_car_currency {
            top: -15px !important;
        }

        .car_attribute_price_day.four_cols .single_car_price {
            font-size: 34px !important;
        }

        .hq-class-title {
            font-size: 40px;
            font-weight: 700;
            line-height: 1.3;
        }

        /*Features*/
        .car_attribute_wrapper_icon {
            flex: 1;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            align-items: center;
            padding: 0px 20px 20px 20px;
            margin-top: 0px !important;
        }

        .car_attribute_wrapper_icon .feature-wrapper {
            margin-right: 15px;
        }

        .portfolio_info_wrapper {
            padding-bottom: 0px !important;
        }
        .hq-vehicle-single-page-feature-wrapper{
            border-top: 1px solid #dce0e0;
            border-bottom: 1px solid #dce0e0;
            padding: 10px 0px;
            display: flex;
        }
        #page_content_wrapper{
            width: 100%;
            padding: 0 5%;
        }
        .hq-vehicle-content-wrapper{
            width: 70%;
            padding: 40px;
        }
        .sidebar_wrapper{
            width: 30%;
            margin-top: 100px;
        }
        .hq-title-wrapper{
            display: flex;
            justify-content: space-between;
            margin-right: 40px;
        }
        .hq-form-item-wrapper{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 10px 0;

        }
        #hq-widget-form{
            border: 1px solid #dce0e0;
            width: 100%;
            padding: 10px 20px 20px 20px;
            box-sizing: border-box;
            border-radius: 5px;
            box-shadow: 0 0 10px 2px rgb(0 0 0 / 20%);
        }
        #hq-widget-form label{
            font-weight: bold;
            padding-bottom: 5px;
        }
        #hq-widget-form select,
        #hq-widget-form input{
            padding: 10px;
            font-size: 100%;
            font-family: inherit;
            width: 100%;
            margin: 0;
            background: #fff;
            border: 1px solid #dce0e0;
            outline: none;
            -webkit-transition: border-color linear .3s;
            -moz-transition: border-color linear .3s;
            -o-transition: border-color linear .3s;
            transition: border-color linear .3s;
            box-sizing: border-box;
            -webkit-appearance: none;
            border-radius: 5px;
        }
        /*End Features*/
        .hq-short-description{
            padding:20px 0px;
        }
        .hq-short-description,.hq-description{
            padding:10px 0px;
        }
        .hq-feature-label{
            font-size: 15px;
            font-weight: bold;
            font-family: inherit;
            margin-right: 10px;
        }
        @media (max-width: 992px) {
            .hq-feature-label{
                display: none;
            }
        }
        @media (max-width: 768px) {
            #page_content_wrapper{
                flex-direction: column;
            }
            .hq-vehicle-content-wrapper{
                width: 100%;
                padding-left: 0;
                padding-right: 0;
            }
            .sidebar_wrapper{
                width: 100%;
                margin-top: 0px;
            }
        }
    </style>
    <div id="page_caption" class="hasbg lazy"
         style="background-image: url(<?php echo $vehicle->getCustomFieldForWebsite('f289')[0]->public_link; ?>);">
    </div>
    <div id="page_content_wrapper">
        <div id="vehicle-class-<?php echo $vehicle->getId(); ?>" class="hq-vehicle-content-wrapper inner">
            <!-- Begin main content -->
            <div class="inner_wrapper">
                <div class="sidebar_content">
                    <div class="hq-title-wrapper">
                        <div>
                            <h1 class="hq-class-title"><?php echo $vehicle->getLabelForWebsite(); ?></h1>
                        </div>
                        <div>
                            <h1 class="hq-class-title">
                                <!--CH$49.761-->
                            </h1>
                        </div>
                    </div>
                    <div class="hq-vehicle-single-page-feature-wrapper single_car_attribute_wrapper themeborder">
                        <?php foreach ($vehicle->getVehicleFeatures() as $feature): ?>
                            <div class="one_fourth hq-feature-wrapper">
                                <p class="hq-feature-label"><?php echo $feature->label_for_website->es; ?></p>
                                <i class="<?php echo $feature->icon; ?>"></i>
                                <!--<div class="car_attribute_content">
                                    <?php //echo $feature->label; ?>
                                </div>-->
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <br class="clear">
                    <div class="single_car_content">
                        <div class="single_car_content hq-short-description">
                            <?php echo $vehicle->getShortDescriptionForWebsite(); ?>
                        </div>
                    </div>
                    <div class="single_car_departure_wrapper themeborder hq-description">
                        <?php echo $vehicle->getDescriptionForWebsite(); ?>
                    </div>
                </div>
            </div>
            <!-- End main content -->
        </div>
        <div class="sidebar_wrapper">
            <div class="sidebar_top"></div>
            <div class="content">
                <div class="single_car_booking_wrapper themeborder book_instantly">
                    <div class="single_car_booking_woocommerce_wrapper">
                        <form action="/reservas/" method="GET" autocomplete="off"
                              id="hq-widget-form">
                            <div class="hq-form-item-wrapper">
                                <label for="">Pickup Location</label>
                                <select id="pick-up-location" name="pick_up_location" required="required"
                                        autocomplete="off">
                                    <?php echo $optionsLocations; ?>
                                </select>
                            </div>
                            <div class="hq-form-item-wrapper">
                                <label for="">Pickup Date</label>
                                <input id="hq_pick_up_date" class="hq-inputs" type="text"
                                       autocomplete="off" name="pick_up_date" placeholder="Select Date" />
                            </div>
                            <div class="hq-form-item-wrapper">
                                <label for="">Duration</label>
                                <select name="reservation_interval" id="reservation_interval">
                                    <option value="12_month">12 Months</option>
                                    <option value="24_month">24 Months</option>
                                    <option value="36_month">36 Months</option>
                                </select>
                            </div>
                            <style>
                                #hq-wiget-form span {
                                    opacity: 0.5;
                                    line-height: 1;
                                    color: #000;
                                    position: relative;
                                    top: 2px;
                                }
                            </style>
                            <input type="hidden" name="vehicle_class_id" value="<?php echo $vehicle->getId(); ?>">
                            <input type="hidden" name="target_step" value="4">
                            <input type="hidden" name="pick_up_time" value="12:00">
                            <input type="hidden" name="return_time" value="12:00">
                            <input id="hq_return_date" type="hidden" name="return_date" value="<?php echo Carbon::now()->addDay()->addDays( 12 * 30   )->format('d-m-Y'); ?>" />
                            <input type="hidden" id="rate-type" name="rate_type_uuid" value="rx2fhigt-o79s-9v8g-6ynq-qul5c08mglfe" />
                            <input type="hidden" name="reservation_type" value="long" />
                            <input type="hidden" id="hq-return-location" name="return_location" value="<?php echo $queryLocations->allLocations()[0]->getId(); ?>">
                            <input class="hq-submit-button" type="submit" value="Reserve Now">
                        </form>
                    </div>
                </div>
            </div>
            <br class="clear">
            <div class="sidebar_bottom"></div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.0/dayjs.min.js" integrity="sha512-KTFpdbCb05CY4l242bLjyaPhoL9vAy4erP1Wkn7Rji0AG6jx6zzGtKkdHc7jUOYOVSmbMbTg728u260CA/Qugg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.11.0/plugin/customParseFormat.min.js" integrity="sha512-nbPJ/ANJ1DCwUWGyfS+PY7RMysy5UnFyOzPTjzcphOuVbUqrukQAZ9kkNvTkPmItJRuuL5IqNufQTHPyxxpmig==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        dayjs.extend(window.dayjs_plugin_customParseFormat);
        var rateType12 = 'rx2fhigt-o79s-9v8g-6ynq-qul5c08mglfe';
        var rateType24 = 'ghpaspdi-i9tq-rfyh-b4f1-ddrqqepxurhz';
        var rateType36 = 'tioiivab-hkqo-i78w-qf24-allupspu5fyj';
        var dateFormatMoment = 'DD-MM-YYYY';
        var reservation24Months = ''
        jQuery(document).ready(function (){
            jQuery('#pick-up-location').on('change', function (){
                jQuery('#hq-return-location').val(jQuery(this).val());

            });
            jQuery('#reservation_interval').on('change',function(){
                if(jQuery(this).val() === '12_month'){
                    jQuery('#rate-type').val(rateType12);
                    addMonthsToReturn(12);
                    //addYearsToReturn(1);
                }
                if(jQuery(this).val() === '24_month'){
                    jQuery('#rate-type').val(rateType24);
                    addMonthsToReturn(24);
                    //addYearsToReturn(2);
                }
                if(jQuery(this).val() === '36_month'){
                    jQuery('#rate-type').val(rateType36);
                    addMonthsToReturn(36);
                    //addYearsToReturn(3);
                }
            });
            // init pickup date
            jQuery('#hq_pick_up_date').val('13-04-2022');
        });
        function addMonthsToReturn(months){
            var pickup = jQuery('#hq_pick_up_date');
            jQuery('#hq_return_date').val(
                dayjs(pickup.val(), dateFormatMoment).add(months * 30,'day').format(dateFormatMoment)
            );
        }
        function addYearsToReturn(years){
            var pickup = jQuery('#hq_pick_up_date');
            jQuery('#hq_return_date').val(
                dayjs(pickup.val(), dateFormatMoment).add(years,'year').format(dateFormatMoment)
            );
        }

    </script>
<?php
get_footer();
