<?php

namespace HQRentalsPlugin\HQRentalsAdmin;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;

class HQRentalsAdminBrandsPosts
{
    function __construct()
    {
        $this->brand = new HQRentalsModelsBrand();
        add_filter('manage_' . $this->brand->brandsCustomPostName . '_posts_columns', array($this, 'addNewColumnsOnBrandAdminScreen'));
        add_action('manage_' . $this->brand->brandsCustomPostName . '_posts_custom_column', array($this, 'displayBrandsDataOnAdminTable'), 10, 2);
    }

    public function addNewColumnsOnBrandAdminScreen($defaults)
    {
        return array(
            'cb' => '<input type="checkbox" />',
            'title' => 'Title',
            'reservation_shortcode' => 'Reservation Shortcode',
            'packages_shortcode' => 'Packages Shortcode',
            'reservation_packages_shortcode' => 'Reservation + PackagesShortcode',
            'my_reservation_shortcode' => 'My Reservation Shortcode',
            'my_package_reservation_shortcode' => 'My Package + Reservation Shortocode',
            'vehicle_class_calendar' => 'Vehicle Class Calendar',
            'date' => 'Date',

        );
    }

    public function displayBrandsDataOnAdminTable($columnName, $postId)
    {
        $currentBrand = new HQRentalsModelsBrand();
        $currentBrand->setBrandFromPost($postId);
        switch ($columnName) {
            case('reservation_shortcode'):
                echo '[hq_rentals_reservations id=' . $currentBrand->id . ']';
                break;
            case('packages_shortcode'):
                echo '[hq_rentals_packages id=' . $currentBrand->id . ']';
                break;
            case('reservation_packages_shortcode'):
                echo '[hq_rentals_reservation_packages id=' . $currentBrand->id . ']';
                break;
            case('my_reservation_shortcode'):
                echo '[hq_rentals_my_reservation id=' . $currentBrand->id . ']';
                break;
            case('my_package_reservation_shortcode'):
                echo '[hq_rentals_my_packages_reservations id=' . $currentBrand->id . ']';
                break;
            case('vehicle_class_calendar'):
                echo '[hq_rentals_vehicle_calendar id=' . $currentBrand->id . ']';
                break;
            default:
                return '';
        }
    }
}