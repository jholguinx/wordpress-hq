<?php
namespace HQRentalsPlugin\HQRentalsTasks;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass as HQVehicleClass;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;


class HQRentalsVehicleClassesTask
{
    public function __construct()
    {
        $this->connector = new Connector();
    }
    public function refreshVehicleClassesData()
    {
        $vehicleClasses = $this->connector->getHQRentalsVehicleClasses();
        if($vehicleClasses->success){
            foreach ($vehicleClasses->data as $class){
                $newVehicleClass = new HQVehicleClass();
                $newVehicleClass->setVehicleClassFromApi($class);
                $newVehicleClass->create();
            }
        }
    }
}