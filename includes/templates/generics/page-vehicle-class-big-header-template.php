<?php
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesVehicleClasses;
$vehicleId = $_GET['id'];
if(empty($vehicleId)){
    wp_redirect(home_url());
    exit;
}
$query = new HQRentalsDBQueriesVehicleClasses();
$vehicle = $query->getVehicleClassById($vehicleId);
get_header();
?>
    <style>
        #page_caption {
            min-height: 500px;
            background-size: cover;
            background-repeat: no-repeat;
        }
    </style>
    <div id="page_caption" class="hasbg lazy"
         style="background-image: url(<?php echo $vehicle->getPublicImage(); ?>);"
         data-bg="url(https://files-europe.caagcrm.com/tenants/07c80036-e2cc-473d-851d-58d0f6ae344f/files/ae837139-c909-4b8c-aae5-59878b0f1c9d/redirect/1648596620/timestamp)"
         data-was-processed="true">

        <div class="single_car_header_button">
            <div class="standard_wrapper">
            </div>
        </div>

        <div class="single_car_header_content">
            <div class="standard_wrapper">
                <div class="single_car_header_price">
                <span id="single_car_price">
                    <span class="single_car_currency">R</span>
                    <span class="single_car_price">5340</span></span>
                    <span id="single_car_price_per_unit_change" class="single_car_price_per_unit">
					<span id="single_car_unit">Per Month</span>
				</span>
                </div>
            </div>
        </div>
    </div>
    <div id="page_content_wrapper">
        <style>
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
                justify-content: flex-start;
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

            /*End Features*/

        </style>
        <div id="vehicle-class-66" class="inner">

            <!-- Begin main content -->
            <div class="inner_wrapper">
                <div class="sidebar_content">
                    <h1 class="hq-class-title">Nissan Micra</h1>
                    <div class="single_car_attribute_wrapper themeborder">
                        <div class="one_fourth hq-feature-wrapper">
                            <i class="fas fa-briefcase"></i>
                            <div class="car_attribute_content">
                                2
                            </div>
                        </div>
                        <div class="one_fourth hq-feature-wrapper">
                            <i class="fab fa-bluetooth"></i>
                            <div class="car_attribute_content">
                                Stereo
                            </div>
                        </div>
                        <div class="one_fourth hq-feature-wrapper">
                            <i class="fas fa-cogs"></i>
                            <div class="car_attribute_content">
                                Manual
                            </div>
                        </div>
                        <div class="one_fourth hq-feature-wrapper">
                            <i class="fas fa-snowflake"></i>
                            <div class="car_attribute_content">
                                A/C
                            </div>
                        </div>
                        <div class="one_fourth hq-feature-wrapper">
                            <i class="fas fa-user-alt"></i>
                            <div class="car_attribute_content">
                                4
                            </div>
                        </div>
                        <div class="one_fourth hq-feature-wrapper">
                            <i class="fa fa-car-side"></i>
                            <div class="car_attribute_content">
                                4
                            </div>
                        </div>
                    </div>
                    <br class="clear">
                    <div class="single_car_content">
                        <div class="single_car_content">
                            <h4 class="p1">Whats included in my Subscription</h4>
                            <p class="p2">For a once off joining fee and a single monthly payment you get the safety of
                                traveling in your own car for essential journeys and financial flexibility in uncertain
                                times.</p>

                            <p class="p2">Includes:</p>
                            <ul>
                                <li>Car</li>
                                <li>Licenses</li>
                                <li>Insurance</li>
                                <li>Maintenance</li>
                                <li>Roadside assistance</li>
                                <li>No 72 month&nbsp;lock-in contract</li>
                                <li>No big deposit</li>
                                <li>No balloon payments</li>
                                <li>No hidden charges</li>
                                <li>No depreciation</li>
                                <li>Cancel at anytime</li>
                                <li>Easy&nbsp;Online process</li>
                            </ul>
                            <p></p>
                        </div>
                    </div>
                    <div class="single_car_departure_wrapper themeborder">
                    </div>
                </div>

                <div class="sidebar_wrapper">
                    <div class="sidebar_top"></div>
                    <div class="content">
                        <div class="single_car_booking_wrapper themeborder book_instantly">
                            <div class="single_car_booking_woocommerce_wrapper">
                                <form action="https://drivve.co.za/reservations/" method="GET" autocomplete="off"
                                      id="hq-wiget-form">
                                    <p>
                                        <label for="">Pickup Location</label>
                                        <select id="pick-up-location" name="pick_up_location" required="required"
                                                autocomplete="off">
                                            <option value="1">Johannesburg</option>
                                            <option value="2">Cape Town</option>
                                            <option value="3">Pretoria</option>
                                            <option value="4">Durban</option>
                                            <option value="5">Bloemfontein</option>
                                            <option value="6">Port Elizabeth</option>
                                        </select>
                                    </p>
                                    <p>
                                        <label for="">Return Location</label>
                                        <select id="return-location-select" name="return_location_select"
                                                required="required" autocomplete="off" disabled="">
                                            <option value="1">Johannesburg</option>
                                            <option value="2">Cape Town</option>
                                            <option value="3">Pretoria</option>
                                            <option value="4">Durban</option>
                                            <option value="5">Bloemfontein</option>
                                            <option value="6">Port Elizabeth</option>
                                        </select>
                                    </p>
                                    <p>
                                        <label for="">Pickup Date</label>
                                        <input id="hq-pickup-date-time-input" class="hq-inputs" type="text"
                                               autocomplete="off" name="pick_up_date" placeholder="Select Date"
                                               required="required">
                                    </p>
                                    <p>
                                        <label for="">Duration</label>
                                        <select name="reservation_interval" id="reservation_interval">
                                            <option value="1_month">1 Months</option>
                                            <option value="2_month">2 Months</option>
                                            <option value="3_month">3 Months</option>
                                            <option value="4_month">4 Months</option>
                                            <option value="5_month">5 Months</option>
                                            <option value="6_month">6 Months</option>
                                            <option value="7_month">7 Months</option>
                                            <option value="8_month">8 Months</option>
                                            <option value="9_month">9 Months</option>
                                            <option value="10_month">10 Months</option>
                                            <option value="11_month">11 Months</option>
                                            <option value="12_month">12 Months</option>
                                            <option value="13_month">13 Months</option>
                                            <option value="14_month">14 Months</option>
                                            <option value="15_month">15 Months</option>
                                            <option value="16_month">16 Months</option>
                                            <option value="17_month">17 Months</option>
                                            <option value="18_month">18 Months</option>
                                            <option value="19_month">19 Months</option>
                                            <option value="20_month">20 Months</option>
                                            <option value="21_month">21 Months</option>
                                            <option value="22_month">22 Months</option>
                                            <option value="23_month">23 Months</option>
                                            <option value="24_month">24 Months</option>
                                        </select>
                                    </p>
                                    <style>
                                        #hq-wiget-form span {
                                            opacity: 0.5;
                                            line-height: 1;
                                            color: #000;
                                            position: relative;
                                            top: 2px;
                                        }
                                    </style>
                                    <input type="hidden" name="vehicle_class_id" value="66">
                                    <input type="hidden" name="target_step" value="4">
                                    <input type="hidden" name="return_date" id="hq-return-date-time-input"
                                           value="30-04-2022" style="">
                                    <input type="hidden" name="return_location" id="return-location" value="1">
                                    <input type="hidden" name="pick_up_time" value="12:00">
                                    <input type="hidden" name="return_time" value="12:00">
                                    <input class="hq-submit-button" type="submit" value="Reserve Now">
                                </form>
                            </div>
                        </div>
                        <a id="single_car_share_button" href="javascript:;" class="button ghost themeborder"><span
                                class="ti-email"></span>Share this car</a>
                    </div>
                    <br class="clear">
                    <div class="sidebar_bottom"></div>
                </div>

            </div>
            <!-- End main content -->

        </div>

    </div>
<?php
get_footer();
