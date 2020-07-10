<?php
global $post;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesBrands;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;

$vehicle = new HQRentalsModelsVehicleClass($post);
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
            align-items: center;
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
            font-size: 24px !important;
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
        .inner{
            padding-bottom: 50px;
        }
        #portfolio_filter_wrapper .car_unit_day{
            margin-top: -10px !important;
            font-size: 10px !important;
        }
        #portfolio_filter_wrapper .single_car_currency{
            top: -7px !important;
            font-size: 12px !important;
        }
    </style>
    <div id="vehicle-class-<?php echo $vehicle->id; ?>" class="inner">

        <!-- Begin main content -->
        <div class="inner_wrapper">
            <div class="sidebar_content">
                <h1><?php echo $vehicle->name; ?></h1>
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
                    <?php echo $vehicle->getShortDescription(); ?>
                </div>
                <div class="single_car_departure_wrapper themeborder">
                    <?php echo $vehicle->getDescription(); ?>
                </div>
            </div>

            <div class="sidebar_wrapper">
                <div class="sidebar_top"></div>
                <div class="content">
                    <div class="single_car_header_price"><span id="single_car_price_scroll"></span></div>
                    <div class="single_car_booking_wrapper themeborder book_instantly">
                        <div class="single_car_booking_woocommerce_wrapper">
                            <form action="<?php echo $brand->websiteLink; ?>" method="GET" autocomplete="off">
                                <p>
                                    <label for="">Pickup Location</label>
                                    <select name="pick_up_location" required="required" autocomplete="off">
                                        <?php foreach($locations as $location): ?>
                                            <option value="<?php echo $location->id; ?>"><?php echo $location->name; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </p>
                                <p>
                                    <label for="">Return Location</label>
                                    <select name="return_location" required="required" autocomplete="off">
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
                                    <label for="">Return Date</label>
                                    <input id="hq-return-date-time-input" class="hq-inputs" type="text" autocomplete="off" name="return_date" placeholder="Select Date" required="required" />
                                </p>
                                <input type="hidden" name="vehicle_class_id" value="<?php echo $vehicle->id; ?>">
                                <input type="hidden" name="target_step" value="3">
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
                                    <a class="car_link" href="<?php echo $permalink; ?>"><h5><?php echo $vehicle->getLabel(); ?></h5></a>
                                    <div class="car_attribute_wrapper_icon">
                                        <?php foreach(array_splice($vehicle->features(), 0 , 2) as $feature): ?>
                                            <div class="one_fourth feature-wrapper">
                                                <i class="<?php echo $feature->icon; ?>" aria-hidden="true"></i>
                                                <div class="car_attribute_content"><?php echo $feature->getLabelForWebsite(); ?></div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div><br class="clear">
                                </div>
                                <div class="car_attribute_price">
                                    <div class="car_attribute_price_day four_cols">
                                        <span class="single_car_currency">R</span><span class="single_car_price"><?php echo $vehicle->rate()->getFormattedDailyRate(); ?></span>
                                        <span class="car_unit_day">Per Day</span>
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