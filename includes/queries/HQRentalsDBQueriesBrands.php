<?php

namespace HQRentalsPlugin\HQRentalsQueries;

use HQRentalsPlugin\HQRentalsDb\HQRentalsDbManager;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;

class HQRentalsDBQueriesBrands extends HQRentalsDBBaseQueries
{
    public function __construct()
    {
        $this->model = new HQRentalsModelsBrand();
        $this->db = new HQRentalsDbManager();
    }


    public function allBrands()
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
            return array_map(function ($brandFromDB) {
                return $this->fillObjectFromDB($brandFromDB);
            }, $queryArray);
        }
        return [];
    }

    public function fillObjectFromDB($brandFromDB)
    {
        $brand = new HQRentalsModelsBrand();
        $brand->setFromDB($brandFromDB);
        return $brand;
    }
    public function getAllBrandsIds() :array
    {
        $query = $this->db->selectFromTable($this->model->getTableName(), 'id', '','ORDER BY id');
        if($query->success){
            return array_map(function($id){
                return (int)$id->id;
            },$query->data) ;
        }
        return [];
    }
    public function deleteBrands($ids){
        if(is_array($ids)){
            foreach ($ids as $id){
                $this->db->delete($this->model->getTableName(), $id);
            }
        }
        if(is_string($ids)){
            $this->db->delete($this->model->getTableName(), $ids);
        }
    }
}