<?php

namespace HQRentalsPlugin\HQRentalsShortcodes;

/**
 * Class HQRentalsShortcoder
 * @package HQRentalsPlugin\HQRentalsShortcodes
 * This class its just for making the Shortcodes accesible to Wordpress
 */
class HQRentalsShortcoder
{
    public function __construct()
    {
        $this->reservationShortcode = new HQRentalsReservationsShortcode();
        $this->reservationFilteredShortcode = new HQRentalsReservationsFilteredShortcode();
        $this->packagesShortcode = new HQRentalsPackagesShortcode();
        $this->reservationPackages = new HQRentalsReservationsPackagesShortcode();
        $this->myReservations = new HQRentalsMyReservationsShortcode();
        $this->myPackagesReservations = new HQRentalsMyPackagesReservationsShortcode();
        $this->formLink = new HQRentalsFormLink();
        $this->reservationsAdvanced = new HQRentalsReservationsAdvancedShortcode();
        $this->systemAssetsShortcode = new HQRentalsSystemAssets();
        $this->calendarShortcode = new HQRentalsAvailabilityCalendarShortcode();
        $this->mapShortcode = new HQRentalsMapShortcode();
        $this->karzoomMapBookForm = new HQRentalsMapBookingForm();
        $this->availabilityGrid = new HQRentalsAvailabilityGridShortcode();
        $this->reservationSnippet = new HQRentalsReservationsSnippetShortcode();
        $this->reservationFormSnippet = new HQRentalsReservationFormSnippetShortcode();
        $this->quoteSnippet = new HQRentalsQuoteSnippetShortcode();
        $this->packageSnippet = new HQRentalsPackageSnippetShortcode();
        $this->paymentSnippet = new HQRentalsPaymentSnippetShortcode();
        $this->gCarVehicleFilterShortcode = new HQGCarVehicleFilterShortcode();
    }
}
