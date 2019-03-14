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
        if($locations->success and !empty($locations->data)){
            $this->createLocationsData( $locations->data );
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
            if($location->id == 20){
                $floors = $this->connector->getWorkspotGebouwLocationDetail();
                $units = $this->connector->getWorkspotGebouwUnits();
                if($floors->success and $units->success and $details->success and !empty($details)){
                    $location->saveDetailsGebouwLocation($details->data, $floors->data, $units->data);
                }
            }else{
                if($details->success and !empty($details)){
                    $location->saveDetails( $details->data );
                }
            }
        }
    }
}