<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass as HQVehicleClass;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;


class HQRentalsVehicleClassesTask extends HQRentalsBaseTask {

    public function __construct() {
		$this->connector = new Connector();
	}

    public function tryToRefreshSettingsData()
    {
        $this->response = $this->connector->getHQRentalsVehicleClasses();
    }

    public function dataWasRetrieved()
    {
        return $this->response->success;
    }

    public function setDataOnWP()
    {
        $customFields = $this->connector->getHQVehicleClassCustomFields();
        if ( $customFields->success ) {
            foreach ( $customFields->data as $field ) {
                HQVehicleClass::$custom_fields[] = $field->dbcolumn;
            }
        }
        if ( $this->response->success and !empty($this->response->data) ) {
            foreach ( $this->response->data as $vehicle_class ) {
                $newVehicleClass = new HQVehicleClass();
                $newVehicleClass->setVehicleClassFromApi( $vehicle_class, $customFields );
                $newVehicleClass->create();
                $newVehicleClass->saveOrUpdate();
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