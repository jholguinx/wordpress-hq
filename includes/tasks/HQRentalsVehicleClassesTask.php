<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass as HQVehicleClass;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;

class HQRentalsVehicleClassesTask{
	public function __construct() {
		$this->connector = new Connector();
	}

	public function refreshVehicleClassesData() {
		$this->createVehicleClassesData();
	}

	public function createVehicleClassesData() {
		$vehicleClasses = $this->connector->getHQRentalsVehicleClasses();
		$customFields   = $this->connector->getHQVehicleClassCustomFields();
		if ( $customFields->success ) {
			foreach ( $customFields->data as $field ) {
				HQVehicleClass::$custom_fields[] = $field->dbcolumn;
			}
		}

		if ( $vehicleClasses->success ) {
			foreach ( $vehicleClasses->data as $class ) {
				$newVehicleClass = new HQVehicleClass();
				if ( $customFields->success ) {
					$newVehicleClass->setVehicleClassFromApi( $class, $customFields->data );
				} else {
					$newVehicleClass->setVehicleClassFromApi( $class );
				}
				$newVehicleClass->create();
			}
		}
	}
}