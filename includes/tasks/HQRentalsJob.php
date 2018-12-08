<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsTasks\HQRentalsScheduler;

class HQRentalsCronJob
{
    public function __construct()
    {
        $this->scheduler = new HQRentalsScheduler();
        add_action('refreshAllHQDataJob', array($this, 'refreshAllData'));
        if (!wp_next_scheduled(array($this, 'refreshAllData'))) {
            wp_schedule_event(time(), 'hourly', 'refreshAllHQDataJob');
        }
    }
    function refreshAllData()
    {
        $this->scheduler->refreshHQData();
    }
}


