<?php
namespace HQRentalsPlugin\HQRentalsQueries;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;

class HQRentalsQueriesVehicleClasses
{
    public function __construct()
    {
        $this->model = new HQRentalsModelsVehicleClass();
    }

    public function allVehicleClasses()
    {
        $vehicleClassesPosts = $this->model->all();
        $data = array();
        foreach ($vehicleClassesPosts as $post){
            $vehicle = new HQRentalsModelsVehicleClass($post);
            $data[] = $vehicle;
        }
        return $data;
    }
}