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
        $query = $this->db->selectFromTable($this->model->getTableName(), '*');
        if($query->success){
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
        if(is_array($queryArray)){
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

    public function getLocationsForBrandsFrontEnd($brandId)
    {
        $location = $this->getLocationsByBrand($brandId);
        return array_map(function ($location) {
            $newObject = new \stdClass();
            $newObject->id = $location->id;
            $newObject->name = $location->name;
            $newObject->coordinates = $location->coordinates;
            $newObject->label = $location->getLabelForWebsite();
            return $newObject;
        }, $location);
    }

    public function locationsPublicInterface()
    {
        $locations = $this->allLocations();
        return array_map(function ($location) {
            return $this->locationPublicInterface($location);
        }, $locations);
    }

    public function locationPublicInterface($location)
    {
        return $this->parseObject(array(
            'id',
            'name',
            'coordinates',
            'brand_id' => array(
                'property_name' => 'brand_id',
                'values' => $location->getBrandId()
            ),
            'address' => array(
                'property_name' => 'address',
                'values' => $location->getCustomFieldForAddress()
            ),
            'office_hours' => array(
                'property_name' => 'office_hours',
                'values' => $location->getCustomFieldForOfficeHours()
            ),
            'phone' => array(
                'property_name' => 'phone',
                'values' => $location->getCustomFieldForPhone()
            )

        ), $location);
    }
}
