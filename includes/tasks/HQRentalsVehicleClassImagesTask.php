<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClassImage as HQImages;

class HQRentalsVehicleClassImagesTask
{
    public function refreshVehicleClassImagesData(){
        $this->dropVehicleImagesData();
    }
    public function dropVehicleImagesData()
    {
        $images = new HQImages();
        foreach($images->all() as $imagePost){
            $metas = get_post_meta( $imagePost->ID );
            foreach ($metas as $key => $values){
                delete_post_meta( $imagePost->ID, $key );
            }
            $post_id = wp_delete_post( $imagePost->ID );
        }
    }
}