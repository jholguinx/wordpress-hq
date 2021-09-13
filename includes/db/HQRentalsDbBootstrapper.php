<?php

namespace HQRentalsPlugin\HQRentalsDb;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsActiveRate;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;

class HQRentalsDbBootstrapper
{

    public function __construct()
    {
        $this->db = new HQRentalsDbManager();
        $this->brandsModel = new HQRentalsModelsBrand();
        $this->locationModel = new HQRentalsModelsLocation();
        $this->vehicleClassModel = new HQRentalsModelsVehicleClass();
        $this->activeRates = new HQRentalsModelsActiveRate();
    }

    public function createTablesOnInit()
    {
        $brandData = $this->brandsModel->getDataToCreateTable();
        $locationData = $this->locationModel->getDataToCreateTable();
        $vehiclesData = $this->vehicleClassModel->getDataToCreateTable();
        $ratesData = $this->activeRates->getDataToCreateTable();
        $brandTable = $this->db->createTable($brandData['table_name'], $brandData['table_columns']);
        $locationTable = $this->db->createTable($locationData['table_name'], $locationData['table_columns']);
        $vehicleTable = $this->db->createTable($vehiclesData['table_name'], $vehiclesData['table_columns']);
        $rateTables = $this->db->createTable($ratesData['table_name'], $ratesData['table_columns']);
        //this should be implemented on updates
        //$vehicleTableCheckUp = $this->db->updateTableOnChanges($vehiclesData['table_name'], $vehiclesData['table_columns']);
        // add validation for process completed
    }
    public function createColumnsForVehiclesClassesCustomFields($customFields)
    {
        $vehiclesData = $this->vehicleClassModel->getDataToCreateTable();
        foreach ($customFields as $column){
            $result = $this->db->checkColumnOnDB($vehiclesData['table_name'], $column);
            if(!$result->success or !$result->data){
                $data = $this->db->alterTable($vehiclesData['table_name'], $column);
            }
        }
    }
}