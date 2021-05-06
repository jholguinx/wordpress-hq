<?php

namespace HQRentalsPlugin\HQRentalsQueries;

use HQRentalsPlugin\HQRentalsDb\HQRentalsDbManager;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation;

class HQRentalsDBQueriesLocations extends HQRentalsDBBaseQueries
{

    public function __construct()
    {
        $this->model = new HQRentalsModelsLocation();
        $this->db = new HQRentalsDbManager();
    }

    public function allLocations()
    {
        $query = $this->db->selectFromTable($this->model->getTableName(), '*', '','ORDER BY location_order');
        if ($query->success) {
            return $this->fillObjectsFromDB($query->data);
        }
        return [];
    }


    public function allToFrontEnd()
    {
        $locationsPost = $this->model->all();
        $data = [];
        foreach ($locationsPost as $post) {
            $location = new HQRentalsModelsLocation($post);
            $data[] = $this->locationPublicInterface($location);
        }
        return $data;
    }

    public function fillObjectsFromDB($queryArray)
    {
        if (is_array($queryArray)) {
            return array_map(function ($locationFromDB) {
                return $this->fillObjectFromDB($locationFromDB);
            }, $queryArray);
        }
        return [];
    }

    public function fillObjectFromDB($locationFROMDB)
    {
        $location = new HQRentalsModelsLocation();
        $location->setFromDB($locationFROMDB);
        return $location;
    }
}