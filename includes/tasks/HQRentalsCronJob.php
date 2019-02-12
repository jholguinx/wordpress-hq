<?php

namespace HQRentalsPlugin\HQRentalsTasks;

class HQRentalsCronJob
{
    public function __construct()
    {
        $this->scheduler = new HQRentalsScheduler();
        add_filter('cron_schedules', array($this, 'addCustomScheduleTime'));
        add_action( 'refreshAllHQDataJob', array($this, 'refreshAllData') );
        if ( ! wp_next_scheduled( 'refreshAllHQDataJob' ) ) {
            wp_schedule_event( time(), 'daily', 'refreshAllHQDataJob' );
        }

    }

    public function refreshAllData()
    {
        $this->scheduler->refreshHQData();
    }

    public function addCustomScheduleTime($schedules)
    {
        $schedules['hqRefreshTime'] = array(
            'interval' => 300,
            'display' => __('Once every five minutes')
        );
        return $schedules;
    }
}


