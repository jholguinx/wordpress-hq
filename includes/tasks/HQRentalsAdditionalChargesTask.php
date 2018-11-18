<?php
namespace HQRentalsPlugin\HQRentalsTasks;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsAdditionalCharge as HQCharge;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsAdditionalCharge;


class HQRentalsAdditionalChargesTask
{
    public function __construct()
    {
        $this->connector = new Connector();
    }
    public function refreshAdditionalChargesData()
    {
        $this->dropAdditionalChargesData();
        $this->createAdditionalChargesData();
    }
    
    public function createAdditionalChargesData()
    {
        $charges = $this->connector->getHQRentalsAdditionalCharges();
        if($charges->success){
            foreach ($charges->data as $charge){
                $newCharge = new HQCharge();
                $newCharge->setAdditionalChargeFromApi($charge);
                $newCharge->create();
            }
        }
    }
    public function dropAdditionalChargesData()
    {
        $charges = new HQCharge();
        foreach ( $charges->all() as $charge ){
            $metas = get_post_meta( $charge->ID );
            foreach ( $metas as $key => $values ){
                delete_post_meta( $charge->ID, $key );
            }
            $post_id = wp_delete_post( $charge->ID );
        }
    }
}