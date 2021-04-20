<?php

namespace HQRentalsPlugin\HQRentalsDb;

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
    }

    public function createTablesOnInit()
    {
        $brandData = $this->brandsModel->getDataToCreateTable();
        $locationData = $this->locationModel->getDataToCreateTable();
        $vehiclesData = $this->vehicleClassModel->getDataToCreateTable();
        $brandTable = $this->db->createTable($brandData['table_name'], $brandData['table_columns']);
        $locationTable = $this->db->createTable($locationData['table_name'], $locationData['table_columns']);
        $vehicleTable = $this->db->createTable($vehiclesData['table_name'], $vehiclesData['table_columns']);
        // add validation for process completed
    }
}