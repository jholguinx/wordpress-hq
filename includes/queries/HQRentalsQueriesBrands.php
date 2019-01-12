<?php
namespace HQRentalsPlugin\HQRentalsQueries;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;

class HQRentalsQueriesBrands
{
    public function __construct()
    {
        $this->model = new HQRentalsModelsBrand();
    }
    public function allToFrontEnd()
    {
        $brands = $this->model->all();
        $data = array();
        foreach ($brands as $post){
            $data[] = new HQRentalsModelsBrand($post);
        }
        return $data;
    }
}