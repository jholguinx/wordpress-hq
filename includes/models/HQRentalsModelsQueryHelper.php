<?php
namespace HQRentalsPlugin\HQRentalsModels;


class HQRentalsModelsQueryHelper
{
    public function __construct()
    {
        $this->additionalCharges = new HQRentalsModelsAdditionalCharge();
    }


    public function getAllAdditionalCharges()
    {
           $charges = array();
           foreach ($this->additionalCharges->getAllAdditionalChargesPosts() as $post){
               $charges[] = new HQRentalsModelsAdditionalCharge($post);
           }
           return $charges;
    }
}