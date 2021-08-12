<?php

namespace HQRentalsPlugin\HQRentalsQueries;

use HQRentalsPlugin\HQRentalsDb\HQRentalsDbManager;
use HQRentalsPlugin\HQRentalsHelpers\HQRentalsCacheHandler;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsDBQueriesVehicleClasses extends HQRentalsDBBaseQueries
{

    public function __construct()
    {
        $this->model = new HQRentalsModelsVehicleClass();
        $this->db = new HQRentalsDbManager();
        $this->rateQuery = new HQRentalsQueriesActiveRates();
        $this->cache = new HQRentalsCacheHandler();
        $this->settings = new HQRentalsSettings();
    }

    public function allVehicleClasses($order = null)
    {
        $query = $this->db->selectFromTable($this->model->getTableName(), '*');
        if ($query->success) {
            return $this->fillObjectsFromDB($query->data);
        }
        return [];
    }

    public function fillObjectsFromDB($queryArray)
    {
        if (is_array($queryArray)) {
            return array_map(function ($vehicle) {
                return $this->fillObjectFromDB($vehicle);
            }, $queryArray);
        }
        return [];
    }

    public function fillObjectFromDB($vehicleFromDB)
    {
        $vehicle = new HQRentalsModelsVehicleClass();
        $vehicle->setFromDB($vehicleFromDB);
        return $vehicle;
    }

    public function getAllVehicleClassesIds() :array
    {
        $query = $this->db->selectFromTable($this->model->getTableName(), 'id', '','ORDER BY id');
        if($query->success){
            return array_map(function($id){
                return (int)$id->id;
            },$query->data) ;
        }
        return [];
    }
    public function deleteVehicleClasses($ids){
        if(is_array($ids)){
            foreach ($ids as $id){
                $this->db->delete($this->model->getTableName(), $id);
            }
        }
        if(is_string($ids)){
            $this->db->delete($this->model->getTableName(), $ids);
        }
    }

    public function getVehicleClassById($id)
    {
        $query = $this->db->selectFromTable($this->model->getTableName(), '*', 'id=' . $id);
        if ($query->success) {
            return $this->fillObjectsFromDB($query->data);
        }
    }
    public function getVehiclesByBrand($brandId)
    {
        $query = $this->db->selectFromTable($this->model->getTableName(), '*', 'brand_id=' . $brandId);
        if ($query->success) {
            return $this->fillObjectsFromDB($query->data);
        }
    }
}
