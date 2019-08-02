<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass as HQVehicleClass;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;
use HQRentalsPlugin\HQRentalsTransformers\HQRentalsTransformersVehicleClasses;

class HQRentalsVehicleClassesTask{
	public function __construct() {
		$this->connector = new Connector();
		$this->transformer = new HQRentalsTransformersVehicleClasses();
	}

	public function refreshVehicleClassesData() {
		$res = $this->createVehicleClassesData();
		return $res;
	}

	public function createVehicleClassesData() {
		$vehicleClasses = $this->connector->getHQRentalsVehicleClasses();
		$customFields   = $this->connector->getHQVehicleClassCustomFields();
		// var_dump($customFields);
		if ( $customFields->success ) {
			foreach ( $customFields->data as $field ) {
				HQVehicleClass::$custom_fields[] = $field->dbcolumn;
			}
		}
		if ( $vehicleClasses->success and !empty($vehicleClasses->data)) {
			$this->createVehicleClasses( $vehicleClasses->data, $customFields );
		}
		return $vehicleClasses;
	}

	protected function createVehicleClasses( $vehicleClasses, $customFields ) {
		foreach ( $vehicleClasses as $vehicle_class ) {
			
			$newVehicleClass = new HQVehicleClass();
			$newVehicleClass->setVehicleClassFromApi( $this->transformer->transformApiData($vehicle_class), $customFields );
			$newVehicleClass->create();
		}
	}
}