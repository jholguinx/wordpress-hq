<?php
namespace HQRentalsPlugin\HQRentalsQueries;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;

class HQRentalsQueriesCustomFields{

    public function __construct()
    {
        $this->vehicleModel = new HQRentalsModelsVehicleClass();
    }

    public function getCustomFieldsFromVehicleClass($vehicleClassId)
    {

    }
}