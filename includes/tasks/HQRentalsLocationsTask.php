<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation as HQLocation;

class HQRentalsLocationsTask
{
    public function __construct()
    {
        $this->connector = new Connector();
    }
    public function refreshBrandsData(){
        $this->dropBrandsData();
        $this->createBrandsData();
    }
    public function createBrandsData()
    {
        $brands = $this->connector->getHQRentalsBrands();
        if($brands->success){
            foreach ($brands->data as $brand){
                $newBrand = new HQBrand();
                $newBrand->setBrandFromApi($brand);
                $newBrand->create();
            }
        }else{
            return false;
        }
    }
    public function dropBrandsData()
    {
        $brand = new HQBrand();
        foreach($brand->all() as $brandPost){
            $metas = get_post_meta( $brandPost->ID );
            foreach ($metas as $key => $values){
                delete_post_meta( $brandPost->ID, $key );
            }
            $post_id = wp_delete_post( $brandPost->ID );
        }
    }
}