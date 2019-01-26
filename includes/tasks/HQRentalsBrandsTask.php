<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand as HQBrand;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;

class HQRentalsBrandsTask{
	public function __construct() {
		$this->connector = new Connector();
	}

	public function refreshBrandsData() {
		$this->createBrandsData();
	}

	public function createBrandsData() {
		$brands = $this->connector->getHQRentalsBrands();
		if ( $brands->success ) {
			foreach ( $brands->data as $brand ) {
				$newBrand = new HQBrand();
				$newBrand->setBrandFromApi( $brand );
				$newBrand->create();
			}
		} else {
			return false;
		}
	}
}