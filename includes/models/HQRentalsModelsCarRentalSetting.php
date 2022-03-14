<?php

namespace HQRentalsPlugin\HQRentalsModels;

use HQRentalsPlugin\HQRentalsDb\HQRentalsDbManager;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsModelsCarRentalSetting extends HQRentalsBaseModel
{
    private $tableName = 'hq_car_rental_preferences';
    private $columns = array(
        array(
            'column_name' => 'id',
            'column_data_type' => 'int'
        ),
        array(
            'column_name' => 'module',
            'column_data_type' => 'varchar(255)'
        ),
        array(
            'column_name' => 'preference',
            'column_data_type' => 'varchar(255)'
        ),
        array(
            'column_name' => 'settings',
            'column_data_type' => 'LONGTEXT'
        ),
    );



    public $id = '';
    public $module = '';
    public $preference = '';
    public $settings = '';


    public function __construct($data = null)
    {
        $this->db = new HQRentalsDbManager();
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function create(){ }

    public function all(){ }
    public function getDataToCreateTable(): array
    {
        return array(
            'table_name' => $this->tableName,
            'table_columns' => $this->columns
        );
    }

    public function saveOrUpdate(): void
    {
        $result = $this->db->selectFromTable($this->tableName, '*', 'id="' . $this->id . '"');
        if ($result->success) {
            $resultUpdate = $this->db->updateIntoTable($this->tableName, $this->parseDataToSaveOnDB(), array('id' => $this->id));
        } else {
            $resultInsert = $this->db->insertIntoTable($this->tableName, $this->parseDataToSaveOnDB());
        }
    }
    private function parseDataToSaveOnDB(): array
    {
        return array(
            'id' => $this->id,
            'module' => $this->module,
            'preference' => $this->preference,
            'settings' => json_encode($this->settings),
        );
    }
    public function setFromDB($settingDB)
    {
        $this->id = $settingDB->id;
        $this->module = $settingDB->module;
        $this->preference = $settingDB->preference;
        $this->settings = json_decode($settingDB->settings);
    }
    public function setFromApi($settingApi)
    {
        $this->id = $settingApi->id;
        $this->module = $settingApi->module;
        $this->preference = $settingApi->preference;
        $this->settings = $settingApi->settings;
    }
}
