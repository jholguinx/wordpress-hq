<?php

namespace HQRentalsPlugin\HQRentalsTasks;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsBrandsTask;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsVehicleClassesTask;

class HQRentalsScheduler
{
    public function __construct()
    {
        $this->brandsTask = new HQRentalsBrandsTask();
        $this->vehicleClassesTask = new HQRentalsVehicleClassesTask();
    }
    public function refreshHQData()
    {
        $this->brandsTask->refreshBrandsData();
        $this->vehicleClassesTask->refreshVehicleClassesData();
    }
}