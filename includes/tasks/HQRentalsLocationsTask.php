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
}