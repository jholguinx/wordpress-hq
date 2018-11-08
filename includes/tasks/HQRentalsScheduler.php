<?php

namespace HQRentalsPlugin\HQRentalsTasks;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsBrandsTask;

class HQRentalsScheduler
{
    public function __construct()
    {
        $this->brandsTask = new HQRentalsBrandsTask();
    }
    public function refreshHQData()
    {
        $this->brandsTask->refreshBrandsData();
    }
}