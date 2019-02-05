<?php
namespace HQRentalsPlugin\HQRentalsQueries;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation;

class HQRentalsQueriesLocations extends HQRentalsQueriesBaseClass{

    public function __construct()
    {
        $this->model = new HQRentalsModelsLocation();
    }
    public function allLocations()
    {
        $locations = $this->model->all();
        return $this->fillModelWithPosts($locations);
    }
	public function getAllMetaKey() {
    	return 'hq_wordpress_location_all_for_frontend';
	}
	public function allToFrontEnd()
    {
        $locationsPost = $this->model->all();
        $data = [];
        foreach ( $locationsPost as $post ){
            $location = new HQRentalsModelsLocation($post);
            $newData = new \stdClass(  );
            $newData->id = $location->id;
            $newData->name = $location->name;
            $data[] = $newData;
        }
        return $data;
    }

    public function fillModelWithPosts($posts)
    {
        $data = [];
        foreach ($posts as $post){
            $location = new HQRentalsModelsLocation($post);
            $data[] = $location;
        }
        return $data;
    }
}