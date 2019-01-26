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
        	$this->createLocations($locations->data);
        	$this->createAllLocationsForFrontend($locations->data);
        }
    }

	protected function createLocations( $locations ) {
		foreach ($locations as $location) {
			$newLocation = new HQLocation();
			$newLocation->setLocationFromApi($location);
			$newLocation->create();
		}
	}

	protected function createAllLocationsForFrontend( $locations ) {
		$all_id         = wp_insert_post( [
			'post_type'      => 'hqwp_locations',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'post_title'     => 'All Locations',
			'post_name'      => 'all_locations',
		] );
		$allForFrontEnd = array_map( function ( $location ) {
			return [
				'id'   => $location->id,
				'name' => $location->name,
			];
		}, $locations );
		hq_update_post_meta( $all_id, 'hq_wordpress_location_all_for_frontend', json_encode( $allForFrontEnd ) );
	}
}