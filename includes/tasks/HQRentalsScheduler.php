<?php

namespace HQRentalsPlugin\HQRentalsTasks;

class HQRentalsScheduler
{
    public function __construct()
    {
        $this->brandsTask = new HQRentalsBrandsTask();
        $this->locationsTask = new HQRentalsLocationsTask();
        $this->vehicleClassesTask = new HQRentalsVehicleClassesTask();
        $this->featuresTask = new HQRentalsFeaturesTask();
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