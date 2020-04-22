<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsLocation as HQLocation;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsFrontEnd as HQFrontEnd;

class HQRentalsLocationsTask extends HQRentalsBaseTask
{
    public function __construct()
    {
        $this->connector = new Connector();
    }

    /*Get data from api and set response*/
    public function tryToRefreshSettingsData()
    {
        $this->response = $this->connector->getHQRentalsLocations();
    }


    public function dataWasRetrieved()
    {
        return $this->response->success;
    }

    public function setDataOnWP()
    {
        if ($this->response->success and !empty($this->response->data)) {
            foreach ($this->response->data as $location) {
                $newLocation = new HQLocation();
                $newLocation->setLocationFromApi($location);
                $newLocation->create();
            }
        }
    }
    public function getError()
    {
        return $this->response->error;
    }
    public function getResponse()
    {
        return $this->response;
    }
}