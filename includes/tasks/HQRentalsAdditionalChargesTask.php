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
}