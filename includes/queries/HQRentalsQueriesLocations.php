<?php
namespace HQRentalsPlugin\HQRentalsQueries;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation;

class HQRentalsQueriesLocations{

    public function __construct()
    {
        $this->model = new HQRentalsModelsLocation();
    }
    public function allLocations()
    {
        $locations = $this->model->all();
        $data = array();
        foreach ($locations as $post){
            $location = new HQRentalsModelsLocation($post);
            $data[] = $location;
        }
        return $data;
    }

}