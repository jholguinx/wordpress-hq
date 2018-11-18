<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsActiveRate as HQRate;

class HQRentalsActiveRatesTask
{
    public function refreshActiveRateData(){
        $this->dropBrandsData();
    }
    public function dropBrandsData()
    {
        $rates = new HQRate();
        if(!empty($rates->all())){
            foreach($rates->all() as $ratePost){
                $metas = get_post_meta( $ratePost->ID );
                foreach ($metas as $key => $values){
                    delete_post_meta( $ratePost->ID, $key );
                }
                $post_id = wp_delete_post( $ratePost->ID );
            }
        }

    }
}