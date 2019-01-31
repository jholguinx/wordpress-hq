<?php

namespace HQRentalsPlugin\HQRentalsQueries;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand;

class HQRentalsQueriesBrands extends HQRentalsQueriesBaseClass
{
    public function __construct()
    {
        $this->model = new HQRentalsModelsBrand();
    }

    public function getAllMetaKey()
    {
        return 'hq_wordpress_brand_all_for_frontend';
    }

    public function getAllBrands()
    {
        $brandsPosts = $this->model->all();
        $data = [];
        foreach ($brandsPosts as $post) {
            $data[] = new HQRentalsModelsBrand($post);
        }
        return $data;
    }

    public function allToFrontEnd()
    {
        $brandsPost = $this->model->all();
        $data = [];
        foreach ($brandsPost as $post) {
            $brand = new HQRentalsModelsBrand($post);
            $newData = new \stdClass();
            $newData->id = $brand->id;
            $newData->name = $brand->name;
            $data[] = $newData;
        }
        return $data;
    }
}