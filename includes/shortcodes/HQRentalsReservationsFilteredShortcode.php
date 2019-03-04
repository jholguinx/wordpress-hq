<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

use HQRentalsPlugin\HQRentalsHelpers\HQRentalsDatesHelper;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;
use HQRentalsPlugin\HQRentalsVendor\Carbon;
use HQRentalsPlugin\HQRentalsAssets\HQRentalsAssetsHandler;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueryStringHelper;

class HQRentalsReservationsFilteredShortcode
{
    public function __construct()
    {
        $this->brand = new HQRentalsModelsBrand();
        $this->settings = new HQRentalsSettings();
        $this->dateHelper = new HQRentalsDatesHelper();
        $this->assets = new HQRentalsAssetsHandler();
        $this->queryVehicles = new HQRentalsQueriesVehicleClasses();
        $this->queryStringHelper = new HQRentalsQueryStringHelper();
        add_shortcode('hq_rentals_reservation_filter' , array ($this, 'reservationsShortcode'));
    }
    public function reservationsShortcode($atts = [])
    {
        $atts = shortcode_atts(
            array(
                'id' => '1',
                'forced_locale' => 'en',
                'new' => 'true',
            )
            , $atts, 'hq_rentals_reservations');
        $post_data = $_POST;
        $this->brand->findBySystemId($atts['id']);
        $this->assets->getIframeResizerAssets();
        try {
            if ($post_data['pick_up_date']) {
                if ($post_data['pick_up_time']) {
                    $pickup_date = Carbon::createFromFormat($this->settings->getFrontEndDatetimeFormat(), $post_data['pick_up_date'] . ' ' . $post_data['pick_up_time']);
                    $return_date = Carbon::createFromFormat($this->settings->getFrontEndDatetimeFormat(), $post_data['return_date'] . ' ' . $post_data['return_time']);
                } else {
                    $pickup_date = Carbon::createFromFormat($this->settings->getFrontEndDatetimeFormat(), $post_data['pick_up_date']);
                    $return_date = Carbon::createFromFormat($this->settings->getFrontEndDatetimeFormat(), $post_data['return_date']);
                }

                $queryStringVehicle = $this->queryStringHelper->getVehicleClassesQueryString($_POST['vehicle_class_filter_db_column'], $_POST['vehicle_classes_filter']);
                ?>

                <form action="<?php echo $this->brand->publicReservationsFirstStepLink . $queryStringVehicle; ?>" method="POST"
                      target="hq-rental-iframe" id="hq-form-init">
                    <input type="hidden" name="pick_up_date"
                           value="<?php echo $pickup_date->format($this->dateHelper->getDateFormatFromCarbon($this->settings->getHQDatetimeFormat())); ?>" />
                    <input type="hidden" name="pick_up_time"
                           value="<?php echo $pickup_date->format($this->dateHelper->getTimeFormatFromCarbon($this->settings->getHQDatetimeFormat())); ?>" />
                    <input type="hidden" name="return_date"
                           value="<?php echo $return_date->format($this->dateHelper->getDateFormatFromCarbon($this->settings->getHQDatetimeFormat())); ?>" />
                    <input type="hidden" name="return_time"
                           value="<?php echo $return_date->format($this->dateHelper->getTimeFormatFromCarbon($this->settings->getHQDatetimeFormat())); ?>" />
                    <?php foreach ($post_data as $key => $value): ?>
                        <?php if ($key !== 'pick_up_date' and $key !== 'pick_up_time' and $key !== 'return_date' and $key !== 'return_time'): ?>
                            <input type="hidden" name="<?php echo $key ?>" value="<?php echo $value; ?>" />
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <input type="submit" style="display: none;">
                </form>
                <iframe id="hq-rental-iframe" name="hq-rental-iframe"
                        src="<?php echo $brand->publicReservationsLinkFull; ?>" scrolling="no"></iframe>
                <?php
                $this->assets->getFirstStepShortcodeAssets();
            } else {
                ?>
                <iframe id="hq-rental-iframe" name="hq-rental-iframe" src="<?php echo $brand->publicReservationsLinkFull; ?>"
                        scrolling="no"></iframe>
                <?php
            }
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }
}