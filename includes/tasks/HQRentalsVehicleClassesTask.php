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
			$this->createVehicleClasses( $vehicleClasses->data, $customFields );
			//$this->createAllVehicleClassesForFrontend( $vehicleClasses->data );
		}
	}

	protected function createVehicleClasses( $vehicleClasses, $customFields ) {
		foreach ( $vehicleClasses as $vehicle_class ) {
			$newVehicleClass = new HQVehicleClass();
			$newVehicleClass->setVehicleClassFromApi( $vehicle_class );
			$newVehicleClass->create();
		}
	}
    /*
	protected function createAllVehicleClassesForFrontend( $vehicleClasses ) {
		$all_id         = wp_insert_post( [
			'post_type'      => 'hqwp_veh_classes',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'post_title'     => 'All Vehicle Classes',
			'post_name'      => 'all_vehicle_classes',
		] );
		$allForFrontEnd = array_map( function ( $vehicleClass ) {
			return [
				'id'   => $vehicleClass->id,
				'name' => $vehicleClass->name,
			];
		}, $vehicleClasses );
		hq_update_post_meta( $all_id, 'hq_wordpress_vehicle_class_all_for_frontend', json_encode( $allForFrontEnd ) );
	}*/
}