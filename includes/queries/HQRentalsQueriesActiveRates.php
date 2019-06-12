<?php
namespace HQRentalsPlugin\HQRentalsQueries;


use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsActiveRate;

class HQRentalsQueriesActiveRates{


    public function __construct()
    {
        $this->model = new HQRentalsModelsActiveRate();
    }
    public function allActiveRates($orderBy = null)
    {
        $rates = $this->model->all();
    }
    protected function setRatesFromPosts($posts)
    {
        $data = [];
        foreach ($posts as $post){
            $data[] = new HQRentalsModelsActiveRate($post);
        }
        return $data;
    }
}