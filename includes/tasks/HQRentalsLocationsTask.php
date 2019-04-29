<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation as HQLocation;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsFrontEnd as HQFrontEnd;

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
        if ($locations->success and !empty($locations->data)) {
        	$this->createLocations($locations->data);
        	//$this->createAllLocationsForFrontend($locations->data);
        }
    }

	protected function createLocations( $locations )
    {
		foreach ($locations as $location) {
			$newLocation = new HQLocation();
			$newLocation->setLocationFromApi($location);
			$newLocation->create();
		}
	}
}