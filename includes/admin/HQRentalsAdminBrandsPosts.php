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
            'title'                     => 'Title',
            'reservation_shortcode'     => 'Reservation Shortcode',
            'my_reservation_shortcode'  => 'My Reservation Shortcode',
            'vehicle_class_calendar'    => 'Vehicle Class Calendar',
            'snippets'                  => 'Snippets',
            'date'                      => 'Date',
        );
    }

    public function displayBrandsDataOnAdminTable($columnName, $postId)
    {
        $currentBrand = new HQRentalsModelsBrand();
        $currentBrand->setBrandFromPostId($postId);
        switch ($columnName) {
            case('reservation_shortcode'):
                $this->resolveReservationShortcode($currentBrand);
                break;
            case('my_reservation_shortcode'):
                $this->resolveMyReservationsShortcode($currentBrand);
                break;
            case('vehicle_class_calendar'):
                $this->resolveCalendarShortcode($currentBrand);
                break;
            case('snippets'):
                $this->resolveSnippets($currentBrand);
            default:
                echo '';
                break;
        }
    }
    public function resolveReservationShortcode($brand)
    {
        ?>
            <div>
                <code>
                <?php echo '[hq_rentals_reservations id=' . $brand->id . ']'; ?>
                </code>
            </div>
        <?php
    }
    public function resolveMyReservationsShortcode($brand)
    {
        ?>
        <div>
            <code>
                <?php echo '[hq_rentals_my_reservations id=' . $brand->id . ']'; ?>
            </code>
        </div>
        <?php
    }
    public function resolveCalendarShortcode($brand)
    {
        ?>
        <div>
            <code>
                <?php echo '[hq_rentals_vehicle_calendar id=' . $brand->id . ']'; ?>
            </code>
        </div>
        <?php
    }
    public function resolveSnippets($brand)
    {
        ?>
        <div>
            <div class="theme-actions">
                <a class="button button-primary customize load-customize hide-if-no-customize" href="">Reservations</a>
            </div>
            <div class="theme-actions">
                <a class="button button-primary customize load-customize hide-if-no-customize" href="">Quotes</a>
            </div>
            <div class="theme-actions">
                <a class="button button-primary customize load-customize hide-if-no-customize" href="">Packages Quotes</a>
            </div>
            <div class="theme-actions">
                <a class="button button-primary customize load-customize hide-if-no-customize" href="">Payment Requests</a>
            </div>
        </div>
        <?php
    }
}
