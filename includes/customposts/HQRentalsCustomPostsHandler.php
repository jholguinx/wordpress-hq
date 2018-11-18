<?php

namespace HQRentalsPlugin\HQRentalsCustomPosts;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation;

class HQRentalsCustomPostsHandler
{
    public function __construct()
    {
        $this->brands = new HQRentalsModelsBrand();
        $this->vehicleClasses = new HQRentalsModelsVehicleClass();
        $this->locations = new HQRentalsModelsLocation();
        add_action( 'init', array( $this, 'registerAllHQRentalsCustomPosts' ) );
    }
    /*
     * Register all Custom Posts
     */
    public function registerAllHQRentalsCustomPosts()
    {
        register_post_type( $this->brands->brandsCustomPostName , $this->brands->customPostArgs );
        register_post_type( $this->locations->locationsCustomPostName, $this->locations->customPostArgs );
        register_post_type( $this->vehicleClasses->vehicleClassesCustomPostName, $this->vehicleClasses->customPostArgs );
    }
}