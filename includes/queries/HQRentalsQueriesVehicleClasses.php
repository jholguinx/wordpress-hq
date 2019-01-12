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
    public function allVehicleClassesToFrontEnd()
    {
        $vehicleClassesPosts = $this->model->all();
        $data = array();
        foreach ($vehicleClassesPosts as $post){
            $data[] = new HQRentalsModelsVehicleClass($post);
        }
        return $data;
    }
    public function getVehicleClassIdFromPost($post){
        if(get_post_type($post) === 'hqwp_veh_classes'){
            $class = new HQRentalsModelsVehicleClass($post);
            return $class->id;
        }else{
            return '';
        }
    }
    public function getVehicleClassFilterByCustomField($filterField)
    {
        $vehicleClassesPost = $this->model->all();
        var_dump($vehicleClassesPost);
    }
}