<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsAdditionalCharge as HQCharge;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;

class HQRentalsAdditionalChargesTask{
	public function __construct() {
		$this->connector = new Connector();
	}

	public function refreshAdditionalChargesData() {
		$this->createAdditionalChargesData();
	}

	public function createAdditionalChargesData() {
		$charges = $this->connector->getHQRentalsAdditionalCharges();
		if ( $charges->success ) {
			$this->createAdditionalCharges( $charges->data );
			$this->createAllAdditionalChargesForFrontend( $charges->data );
		}
	}

	protected function createAdditionalCharges( $additionalCharges ) {
		foreach ( $additionalCharges as $additionalCharge ) {
			$newCharge = new HQCharge();
			$newCharge->setAdditionalChargeFromApi( $additionalCharge );
			$newCharge->create();
		}
	}

	protected function createAllAdditionalChargesForFrontend( $additionalCharges ) {
		$all_id         = wp_insert_post( [
			'post_type'      => 'hqwp_charges',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'post_title'     => 'All Additional Charges',
			'post_name'      => 'all_additional_charges',
		] );
		$allForFrontEnd = array_map( function ( $additionalCharge ) {
			return [
				'id'   => $additionalCharge->id,
				'name' => $additionalCharge->name,
			];
		}, $additionalCharges );
		hq_update_post_meta( $all_id, 'hq_wordpress_additional_charge_all_for_frontend', json_encode( $allForFrontEnd ) );
	}
}