<?php
namespace HQRentalsPlugin\HQRentalsModels;


class HQRentalsModelsBrand{

    /*
     * Meta Data Wordpress
     */
    public $brandsCustomPostName = 'hq_wordpress_brands';
    public $brandsCustomPostSlug = 'brands';
    public function __construct($data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->taxLabel = $data->tax_label;
        $this->websiteLink = $data->website_link;
        $this->publicReservationsLinkFull = $data->public_reservations_link_full;
        $this->publicPackagesLinkFull = $data->public_packages_link_full;
        $this->publicReservationsFirstStepLink = $data->public_reservations_link_first_step;
        $this->publicPackagesFirstStepLink = $data->public_packages_link_first_step;
        $this->publicReservationPackagesFirstStepLink = $data->public_reservations_packages_link_first_step;
        $this->myReservationsLink = $data->my_reservations_link;
        $this->myPackagesReservationsLink = $data->my_package_reservations_link;
    }

}