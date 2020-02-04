<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand as HQBrand;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;

class HQRentalsBrandsTask{
	public function __construct() {
		$this->connector = new Connector();
	}

	public function refreshBrandsData()
    {
		return $this->createBrandsData();
	}

	public function createBrandsData()
    {
		$brands = $this->connector->getHQRentalsBrands();
		if ( $brands->success and !empty($brands->data)) {
			$this->createBrands( $brands->data );
		}
		return $brands;
	}

	protected function createBrands( $brands )
    {
		foreach ( $brands as $brand ) {
			$newBrand = new HQBrand();
			$newBrand->setBrandFromApi( $brand );
			$newBrand->create();
		}
	}
}
