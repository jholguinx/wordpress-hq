<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation as HQLocation;

class HQRentalsLocationsTask
{
    public function __construct()
    {
        $this->connector = new Connector();
    }

    public function refreshLocationsData()
    {
        $this->dropLocationsData();
        $this->createLocationsData();
    }

    public function createLocationsData()
    {
        $locations = $this->connector->getHQRentalsLocations();
        if ($locations->success) {
            foreach ($locations->data as $location) {
                $newLocation = new HQLocation();
                $newLocation->setLocationFromApi($location);
                $newLocation->create();
            }
        } else {
            return false;
        }
    }

    public function dropLocationsData()
    {
        $location = new HQLocation();
        foreach ($location->all() as $locationPost) {
            $metas = get_post_meta($locationPost->ID);
            foreach ($metas as $key => $values) {
                delete_post_meta($locationPost->ID, $key);
            }
            $post_id = wp_delete_post($locationPost->ID);
        }
    }
}