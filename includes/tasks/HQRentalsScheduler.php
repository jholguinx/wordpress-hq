<?php

namespace HQRentalsPlugin\HQRentalsTasks;


use HQRentalsPlugin\HQRentalsTasks\HQRentalsBrandsTask;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsFeaturesTask;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsLocationsTask;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsActiveRatesTask;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsVehicleClassesTask;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsVehicleClassImagesTask;

class HQRentalsScheduler
{
    public function __construct()
    {
        $this->brandsTask = new HQRentalsBrandsTask();
        $this->vehicleClassesTask = new HQRentalsVehicleClassesTask();
        $this->featuresTask = new HQRentalsFeaturesTask();
        $this->locationsTask = new HQRentalsLocationsTask();
        $this->activeRatesTask = new HQRentalsActiveRatesTask();
        $this->vehicleClassImagesTask = new HQRentalsVehicleClassImagesTask();
    }
    public function refreshHQData()
    {
        $this->brandsTask->refreshBrandsData();
        $this->featuresTask->refreshFeaturesData();
        $this->vehicleClassImagesTask->refreshVehicleClassImagesData();
        $this->activeRatesTask->refreshActiveRateData();
        $this->vehicleClassesTask->refreshVehicleClassesData();
        $this->locationsTask->refreshLocationsData();
    }
}