<?php
global $post;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesBrands;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiDataResolver;

$vehicle = new HQRentalsModelsVehicleClass($post);
$vehicleFeatures = HQRentalsApiDataResolver::resolveCKEditor($vehicle->getCustomField('f324'));
$vehicleDescription = HQRentalsApiDataResolver::resolveCKEditor($vehicle->getCustomField('f325'));
$queryLocations = new HQRentalsQueriesLocations();
$queryBrands = new HQRentalsQueriesBrands();
$queryVehicles = new HQRentalsQueriesVehicleClasses();
$brand = $queryBrands->getBrand($vehicle->brandId);
$locations = $queryLocations->allLocations();
$similarCars = $queryVehicles->getVehicleClassFilterByCustomField('f268', $vehicle->getCustomField('f268'));
get_header();
include_once("templates/template-car-header.php");

?>
    <style>
        #page_content_wrapper .inner .sidebar_content{
            margin-top: 40px !important;
        }
        #page_caption{
            margin-bottom: 0px !important;
        }
        .hq-feature-wrapper{
            display: flex;
            flex: 1;
            align-items: center;
            justify-content: center;
            width: 20% !important;
        }
        .single_car_attribute_wrapper .car_attribute_content{
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .hq-feature-wrapper .car_attribute_content{
            margin-left: 20px;
        }
        .feature-wrapper{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
        }
        .hq-inputs{
            width: 100%;
        }
        label{
            text-align: left;
        }
        #portfolio_filter_wrapper .car_attribute_wrapper{
            width: 60% !important;
        }
        #portfolio_filter_wrapper .car_attribute_price{
            width: 40% !important;
        }
        .car_attribute_price_day.three_cols .single_car_price{
            font-size: 34px !important;
        }
        .single_car_attribute_wrapper .fa,.single_car_attribute_wrapper .fas{
            font-size: 30px !important;
        }
        .wrapper{
            max-width: 1425px;
            width: 100%;
            box-sizing: border-box;
            margin: auto;
            padding: 0 90px;
            height: 100%;
        }
        @media only screen and (max-width: 960px) and (min-width: 768px){
            .portfolio_info_wrapper{
                display: flex;
                flex: 1;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }
            .portfolio_info_wrapper div,#portfolio_filter_wrapper .car_attribute_wrapper, #portfolio_filter_wrapper .car_attribute_price{
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

        .single_car_attribute_wrapper .fa, .single_car_attribute_wrapper .fas {
            line-height: 1.5;
        }

        .inner{
            padding-bottom: 50px;
        }
        #portfolio_filter_wrapper .car_unit_day{
            margin-top: -15px !important;
            font-size: 11px !important;
        }
        #portfolio_filter_wrapper .single_car_currency{
            top: -15px !important;
        }
        .car_attribute_price_day.four_cols .single_car_price{
            font-size: 34px !important;
        }
        .hq-class-title{
            font-size: 40px;
            font-weight: 700;
            line-height: 1.3;
        }

    </style>
    <div id="vehicle-class-<?php echo $vehicle->id; ?>" class="inner">

        <!-- Begin main content -->
        <div class="inner_wrapper">
            <div class="sidebar_content">
                <h1 class="hq-class-title"><?php echo $vehicle->name; ?></h1>
                <div class="single_car_attribute_wrapper themeborder">
                    <?php foreach (array_splice($vehicle->features(), 0, 4) as $feature): ?>
                        <div class="one_fourth hq-feature-wrapper">
                            <i class="<?php echo $feature->icon; ?>"></i>
                            <div class="car_attribute_content">
                                <?php echo $feature->getLabelForWebsite(); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <br class="clear"/>
                <div class="single_car_content">
                    <?php echo $vehicleDescription; ?>
                </div>
                <div class="single_car_departure_wrapper themeborder">
                    <?php echo $vehicleFeatures; ?>
                </div>
            </div>

            <div class="sidebar_wrapper">
                <div class="sidebar_top"></div>
                <div class="content">
                    <div class="single_car_booking_wrapper themeborder book_instantly">
                        <div class="single_car_booking_woocommerce_wrapper">
                            <form action="<?php echo $brand->websiteLink; ?>" method="GET" autocomplete="off" id="hq-wiget-form">
                                <p>
                                    <label for="">Pickup Location</label>
                                    <select id="pick-up-location" name="pick_up_location" required="required" autocomplete="off">
                                        <?php foreach($locations as $location): ?>
                                            <option value="<?php echo $location->id; ?>"><?php echo $location->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </p>
                                <p>
                                    <label for="">Pickup Date</label>
                                    <input id="hq-pickup-date-time-input" class="hq-inputs" type="text" autocomplete="off" name="pick_up_date" placeholder="Select Date" required="required" />
                                </p>
                                <p>
                                    <label for="">Interval</label>
                                    <select name="reservation_interval" id="reservation_interval">
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
                                    </select>
                                </p>
                                <style>
                                    #hq-wiget-form span{
                                        opacity: 0.5;
                                        line-height: 1;
                                        color: #000;
                                        position: relative;
                                        top: 2px;
                                    }
                                </style>
                                <input type="hidden" name="vehicle_class_id" value="<?php echo $vehicle->id; ?>">
                                <input type="hidden" name="target_step" value="3">
                                <input type="hidden" name="return_date" id="hq-return-date-time-input">
                                <input type="hidden" name="return_location" id="return-location">
                                <input class="hq-submit-button" type="submit" value="Reserve Now">
                            </form>
                        </div>
                    </div>
                    <a id="single_car_share_button" href="javascript:;" class="button ghost themeborder"><span class="ti-email"></span>Share this car</a>
                </div>
                <br class="clear"/>
                <div class="sidebar_bottom"></div>
            </div>

        </div>
        <!-- End main content -->

    </div>

    </div>
<?php if($similarCars): ?>
    <?php $permalink = get_permalink($vehicle->postId); ?>
    <div class="wrapper">
        <div class="car_related" style="margin-top: 30px;">
            <h3 class="sub_title">Similar cars</h3>
            <div id="portfolio_filter_wrapper" class="gallery classic three_cols portfolio-content section content clearfix" data-columns="3">
                <?php foreach(array_splice($similarCars, 0, 3) as $vehicle): ?>
                    <div class="element grid classic3_cols">
                        <div class="one_third gallery3 classic static filterable portfolio_type themeborder" data-id="post-246">
                            <a class="car_image" href="<?php echo $permalink; ?>">
                                <img src="<?php echo $vehicle->publicImageLink; ?>">
                            </a>
                            <div class="portfolio_info_wrapper">
                                <div class="car_attribute_wrapper">
                                    <a class="car_link" href="<?php echo $permalink; ?>"><h4><?php echo $vehicle->getLabel(); ?></h4></a>
                                    <div class="car_attribute_wrapper_icon">
                                        <?php foreach(array_splice($vehicle->features(), 0 , 6) as $feature): ?>
                                            <div class="one_fourth feature-wrapper">
                                                <i class="<?php echo $feature->icon; ?>" aria-hidden="true"></i>
                                                <div class="car_attribute_content"><?php echo $feature->getLabelForWebsite(); ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div><br class="clear">
                                </div>
                                <div class="car_attribute_price">
                                    <div class="car_attribute_price_day three_cols">
                                        <span class="single_car_currency">R</span><span class="single_car_price"><?php echo $vehicle->rate()->getFormattedMonthlyRate(0); ?></span>
                                        <span class="car_unit_day">Per Month</span>
                                    </div>
                                </div>
                                <br class="clear">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php get_footer(); ?>