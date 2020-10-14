<?php

namespace HQRentalsPlugin\HQRentalsCustomPosts;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleType;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsWorkspotLocation;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsWorkspotRegion;

class HQRentalsCustomPostsHandler
{
    public function __construct()
    {
        $this->currentWebsite = get_site_url();
        $this->brands = new HQRentalsModelsBrand();
        $this->vehicleClasses = new HQRentalsModelsVehicleClass();
        $this->locations = new HQRentalsModelsLocation();
        $this->vehicleTypes = new HQRentalsModelsVehicleType();
        $this->workspotLocations = new HQRentalsModelsWorkspotLocation();
        $this->workspotRegions = new HQRentalsModelsWorkspotRegion();
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
        register_post_type( $this->vehicleTypes->vehicleTypeCustomPostName, $this->vehicleTypes->customPostArgs );
        if($this->currentWebsite == 'http://workspot.test' or $this->currentWebsite == 'https://workspot.nu'){
            register_post_type( $this->workspotLocations->locationsCustomPostName, $this->workspotLocations->customPostArgs );
            register_post_type( $this->workspotRegions->regionsCustomPostName, $this->workspotRegions->customPostArgs );
        }
    }
}