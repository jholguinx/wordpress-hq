<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsWorkspotLocation;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesWorkspotLocations;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsWorkspotRegion;

class HQRentalsLocationsWorkspotTask
{

    public function __construct()
    {
        $this->connector = new Connector();
        $this->query = new HQRentalsQueriesWorkspotLocations();
    }

    public function refreshLocationsData()
    {
        $res = [];
        $res[0] = $this->createWorkspotRegions();
        $res[1] = $this->createWorkspotLocations();
        return $res;
    }

    public function createWorkspotLocations()
    {
        $locations = $this->connector->getWorkspotLocations();
        if ($locations->success and !empty($locations->data)) {
            $this->createLocationsData($locations->data);
        }
        return $locations;

    }

    public function createLocationsData($locations)
    {
        foreach ($locations as $location) {
            $newLocation = new HQRentalsModelsWorkspotLocation();
            $newLocation->setLocationFromApi($location);
            $newLocation->create();
        }
        $this->createLocationsDetails();

    }

    public function createLocationsDetails()
    {
        $locations = $this->query->allLocations();
        foreach ($locations as $location) {
            $details = $this->connector->getWorkspotLocationDetail($location);
            if ($location->id == 20) {
                $floors = $this->connector->getWorkspotGebouwLocationDetail();
                $units = $this->connector->getWorkspotGebouwUnits();
                if ($floors->success and $units->success and $details->success and !empty($details)) {
                    $location->saveDetailsGebouwLocation($details->data, $floors->data, $units->data);
                }
            } else {
                if ($details->success and !empty($details)) {
                    $location->saveDetails($details->data);
                }
            }
        }
    }

    public function createWorkspotRegions()
    {
        $regions = $this->connector->getWorkspotRegions();
        if ($regions->success) {
            foreach ($regions->data as $region) {
                $newRegion = new HQRentalsModelsWorkspotRegion();
                $newRegion->setRegionFromApi($region);
                $newRegion->create();
            }
        }
        return $regions;

    }
}