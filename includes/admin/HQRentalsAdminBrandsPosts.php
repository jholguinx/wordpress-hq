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
                break;
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
        ob_start();
        ?>
        <div>
            <div class="theme-actions">
                <a
                    id="hq-snippet-reservation-button"
                    class="hq-snippets"
                    data-brand="<?php echo $brand->id; ?>"
                    data-snippet="reservation"
                    data-tippy-content="Click to copy"
                    >Reservations</a>
            </div>
            <div class="theme-actions">
                <a
                    id="hq-snippet-reservation-button"
                    class="hq-snippets"
                    data-brand="<?php echo $brand->id; ?>"
                    data-snippet="package"
                    data-tippy-content="Click to copy"
                >Package Quotes</a>
            </div>
            <div class="theme-actions">
                <a
                    id="hq-snippet-reservation-button"
                    class="hq-snippets"
                    data-brand="<?php echo $brand->id; ?>"
                    data-snippet="payment"
                    data-tippy-content="Click to copy"
                >Payment Requests</a>
            </div>
            <div class="theme-actions">
                <a
                    id="hq-snippet-reservation-button"
                    class="hq-snippets"
                    data-brand="<?php echo $brand->id; ?>"
                    data-snippet="quote"
                    data-tippy-content="Click to copy"
                >Quotes</a>
            </div>
        </div>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
}
