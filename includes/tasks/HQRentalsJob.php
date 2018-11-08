<?php

namespace HQRentalsPlugin\HQRentalsTasks;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsScheduler;

$scheduler = new HQRentalsScheduler();
$scheduler->refreshHQData();