<?php
namespace HQRentalsPlugin\HQRentalsQueries;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsWorkspotLocation;

class HQRentalsQueriesWorkspotLocations
{

    public function __construct()
    {
        $this->model = new HQRentalsModelsWorkspotLocation();
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
            $location = new HQRentalsModelsWorkspotLocation($post);
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
    public function getLocationsFilteredByRegions($regions)
    {
        return array_filter($this->allLocations(), function($location) use ($regions){
                foreach ($regions as $region){
                    if(strpos($location->regions, $region) !== false){
                        return true;
                    }
                }
                return false;
        });
    }
}