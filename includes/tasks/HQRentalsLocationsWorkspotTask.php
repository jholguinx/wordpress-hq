<?php

namespace HQRentalsPlugin\HQRentalsTasks;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsWorkspotLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesWorkspotLocations;

class HQRentalsLocationsWorkspotTask{

    public function __construct()
    {
        $this->connector = new Connector();
        $this->query = new HQRentalsQueriesWorkspotLocations();
    }

    public function refreshLocationsData()
    {
        $this->createWorkspotLocations();
    }
    public function createWorkspotLocations()
    {
        $locations = $this->connector->getWorkspotLocations();
        if($locations->success){
            $this->createLocations( $locations->data );
        }
    }
    public function createLocationsData( $locations )
    {
        foreach ($locations as $location){
            $newLocation = new HQRentalsModelsWorkspotLocations();
            $newLocation->setLocationFromApi($location);
            $newLocation->create();
        }
        $this->createLocationsDetails();
    }
    public function createLocationsDetails()
    {
        $locations = $this->query->allLocations();
        foreach ($locations as $location){
            $details = $this->connector->getWorkspotLocationDetail($location);
            if($details->success){
                $location->saveDetails( $details->data );
            }
        }
    }
}