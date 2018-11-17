<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsFeature as HQFeature;

class HQRentalsFeaturesTask
{
    public function refreshFeaturesData(){
        $this->dropFeaturesData();
    }
    public function dropFeaturesData()
    {
        $features = new HQFeature();
        foreach($features->all() as $featurePost){
            $metas = get_post_meta( $featurePost->ID );
            foreach ($metas as $key => $values){
                delete_post_meta( $featurePost->ID, $key );
            }
            $post_id = wp_delete_post( $featurePost->ID );
        }
    }
}