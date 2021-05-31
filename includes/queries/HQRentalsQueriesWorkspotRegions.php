<?php

namespace HQRentalsPlugin\HQRentalsQueries;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsWorkspotRegion;

class HQRentalsQueriesWorkspotRegions
{

    public function __construct()
    {
        $this->model = new HQRentalsModelsWorkspotRegion();
    }

    public function allRegions()
    {
        $regions = $this->model->all();
        return $this->fillModelWithPosts($regions);
    }

    public function fillModelWithPosts($posts)
    {
        $data = array();
        foreach ($posts as $post) {
            $region = new HQRentalsModelsWorkspotRegion($post);
            $data[] = $region;
        }
        return $data;
    }
}