<?php
namespace HQRentalsPlugin\HQRentalsTasks;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass as HQVehicleClass;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;


class HQRentalsVehicleClassesTask
{
    public function __construct()
    {
        $this->connector = new Connector();
    }
    public function refreshVehicleClassesData()
    {
        $this->dropVehicleClassesData();
        $this->createVehicleClassesData();
    }
    public function createVehicleClassesData()
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
    public function dropVehicleClassesData()
    {
        $vehicles = new HQRentalsModelsVehicleClass();
        foreach ( $vehicles->all() as $vehicle ){
            $metas = get_post_meta( $vehicle->ID );
            foreach ( $metas as $key => $values ){
                delete_post_meta( $vehicle->ID, $key );
            }
            $post_id = wp_delete_post( $vehicle->ID );
        }
    }
}