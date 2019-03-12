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
        $data = array();
        foreach ($posts as $post){
            $location = new HQRentalsModelsWorkspotLocations($post);
            $data[] = $location;
        }
        return $data;
    }
    public function getLocationsToFrontEnd()
    {
        $data = array();
        foreach ($this->allLocations() as $location){
            $data[] = $location;
        }
        return $data;
    }
}