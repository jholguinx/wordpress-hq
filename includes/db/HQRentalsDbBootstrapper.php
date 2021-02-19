<?php

namespace HQRentalsPlugin\HQRentalsDb;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;

class HQRentalsDbBootstrapper{

    public function __construct()
    {
        $this->db = new HQRentalsDbManager();
        $this->brandsModel = new HQRentalsModelsBrand();
    }

    public function createTablesOnInit(){
        $brandData = $this->brandsModel->getDataToCreateTable();
        $brandTable = $this->db->createTable($brandData['table_name'], $brandData['table_columns']);
        dd($brandTable);
    }
}