<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsAdditionalCharge as HQCharge;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;

class HQRentalsAdditionalChargesTask{
	public function __construct() {
		$this->connector = new Connector();
	}

	public function refreshAdditionalChargesData() {
		$res = $this->createAdditionalChargesData();
		return $res;
	}

	public function createAdditionalChargesData() {
		$charges = $this->connector->getHQRentalsAdditionalCharges();
		if ( $charges->success and !empty($charges->data)) {
			$this->createAdditionalCharges( $charges->data );
			//$this->createAllAdditionalChargesForFrontend( $charges->data );
		}
		return $charges;
	}

	protected function createAdditionalCharges( $additionalCharges ) {
		foreach ( $additionalCharges as $additionalCharge ) {
			$newCharge = new HQCharge();
			$newCharge->setAdditionalChargeFromApi( $additionalCharge );
			$newCharge->create();
		}
	}
}