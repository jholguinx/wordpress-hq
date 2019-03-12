<?php
namespace HQRentalsPlugin\HQRentalsQueries;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsWorkspotLocations;

class HQRentalsQueriesWorkspotLocations
{

    public function __construct()
    {
        $this->model = new HQRentalsModelsWorkspotLocations();
    }
    public function allLocations()
    {
        $locations = $this->model->all();
        return $this->fillModelWithPosts($locations);
    }


    public function fillModelWithPosts($posts)
    {
        $data = [];
        foreach ($posts as $post){
            $location = new HQRentalsModelsWorkspotLocations($post);
            $data[] = $location;
        }
        return $data;
    }
}