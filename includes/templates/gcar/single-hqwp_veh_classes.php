<?php
/**
 * The main template file for display single post page.
 *
 * @package WordPress
 */
global $post;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesBrands;

$queryLocations = new HQRentalsQueriesLocations();
$queryBrands = new HQRentalsQueriesBrands();
$brand = $queryBrands->getBrand($vehicle->brandId);
$vehicle = new HQRentalsModelsVehicleClass($post);
$locations = $queryLocations->allLocations();
get_header();
include_once("templates/template-car-header.php");
?>
    <div class="inner">

        <!-- Begin main content -->
        <div class="inner_wrapper">
            <div class="sidebar_content">
                <h1><?php echo $vehicle->name; ?></h1>

                <div class="single_car_attribute_wrapper themeborder">
                    <?php foreach ($vehicle->features() as $feature): ?>
                        <div class="one_fourth">
                            <div class="car_attribute_icon ti-user"></div>
                            <div class="car_attribute_content">
                                <?php echo $feature->getLabelForWebsite(); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <br class="clear"/>

                <div class="single_car_content">
                    <?php $vehicle->getDescription(); ?>
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
                                    <input id="hq-pickup-date-input" class="hq-inputs" type="text" autocomplete="off" name="pick_up_date" placeholder="Select Date" required="required" />
                                </p>
                                <p>
                                    <label for="">Return Date</label>
                                    <input id="hq-return-date-input" class="hq-inputs" type="text" autocomplete="off" name="return_date" placeholder="Select Date" required="required" />
                                </p>
                                <input type="hidden" name="vehicle_class_id" value="<?php echo $vehicle->id; ?>">
                                <input type="hidden" name="target_step" value="3">
                                <input class="hq-submit-button" type="submit" value="Reserve Now">
                            </form>
                        </div>
                    </div>
                </div>
                <br class="clear"/>
                <div class="sidebar_bottom"></div>
            </div>

        </div>
        <!-- End main content -->
    </div>
    </div>
    <style>
        .hq-inputs{
            width: 100%;
        }
        label{
            text-align: left;
        }
    </style>
<?php get_footer(); ?>