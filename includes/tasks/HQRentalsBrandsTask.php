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
		if ( $brands->success and !empty($brands->data)) {
			$this->createBrands( $brands->data );
			//$this->createAllBrandsForFrontEnd( $brands->data );
		}
	}

	protected function createBrands( $brands ) {
		foreach ( $brands as $brand ) {
			$newBrand = new HQBrand();
			$newBrand->setBrandFromApi( $brand );
			$newBrand->create();
		}
	}
    /*
	protected function createAllBrandsForFrontEnd( $brands ) {
		$all_id         = wp_insert_post( [
			'post_type'      => 'hqwp_brands',
			'post_status'    => 'publish',
			'posts_per_page' => - 1,
			'post_title'     => 'All Brands',
			'post_name'      => 'all_brands',
		] );
		$allForFrontEnd = array_map( function ( $brand ) {
			return [
				'id'   => $brand->id,
				'name' => $brand->name,
			];
		}, $brands );
		hq_update_post_meta( $all_id, 'hq_wordpress_brand_all_for_frontend', json_encode( $allForFrontEnd ) );
	}*/
}