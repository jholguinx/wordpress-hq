<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass as HQVehicleClass;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClassCustomFields;
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
        $customFields = $this->connector->getHQVehicleClassCustomFields();
        if($customFields->success){
            foreach ($customFields as $field){
                $newField = new HQRentalsModelsVehicleClassCustomFields();
                $newField->setCustomFieldFromApi($field);
                $newField->create();
            }
        }
        if ($vehicleClasses->success) {
            foreach ($vehicleClasses->data as $class) {

                $newVehicleClass = new HQVehicleClass();
                if($customFields->success){
                    $newVehicleClass->setVehicleClassFromApi($class, $customFields->data);
                }else{
                    $newVehicleClass->setVehicleClassFromApi($class);
                }

                $newVehicleClass->create();
            }
        }
    }

    public function dropVehicleClassesData()
    {
        $vehicles = new HQRentalsModelsVehicleClass();
        foreach ($vehicles->all() as $vehicle) {
            $metas = get_post_meta($vehicle->ID);
            foreach ($metas as $key => $values) {
                delete_post_meta($vehicle->ID, $key);
            }
            $post_id = wp_delete_post($vehicle->ID);
        }
    }
}