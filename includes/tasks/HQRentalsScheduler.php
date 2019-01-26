<?php

namespace HQRentalsPlugin\HQRentalsTasks;


class HQRentalsScheduler{
	/**
	 * @var HQRentalsBrandsTask
	 */
	protected $brandsTask;
	/**
	 * @var HQRentalsLocationsTask
	 */
	protected $locationsTask;
	/**
	 * @var HQRentalsVehicleClassesTask
	 */
	protected $vehicleClassesTask;
	/**
	 * @var HQRentalsAdditionalChargesTask
	 */
	protected $additionalChargesTask;

	public function __construct() {
		$this->brandsTask            = new HQRentalsBrandsTask();
		$this->locationsTask         = new HQRentalsLocationsTask();
		$this->vehicleClassesTask    = new HQRentalsVehicleClassesTask();
		$this->additionalChargesTask = new HQRentalsAdditionalChargesTask();
	}

	public function refreshHQData() {
		global $wpdb;
		$wpdb->get_results( "delete from wp_posts where post_type like 'hqwp%';" );
		$wpdb->get_results( "delete from wp_postmeta where meta_key like 'hq_wordpress%'" );

		$this->brandsTask->refreshBrandsData();
		$this->locationsTask->refreshLocationsData();
		$this->additionalChargesTask->refreshAdditionalChargesData();
		$this->vehicleClassesTask->refreshVehicleClassesData();
	}
}