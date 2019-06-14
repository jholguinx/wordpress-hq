<?php

namespace HQRentalsPlugin\HQRentalsTasks;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsCronJob
{
    public function __construct()
    {
        $this->scheduler = new HQRentalsScheduler();
        $this->pluginSettings = new HQRentalsSettings();
        add_filter('cron_schedules', array($this, 'addCustomScheduleTime'));
        add_action( 'refreshAllHQDataJob', array($this, 'refreshAllData') );
        if ( ! wp_next_scheduled( 'refreshAllHQDataJob' ) ) {
            wp_schedule_event( time(), 'daily', 'refreshAllHQDataJob' );
        }

    }

    public function refreshAllData()
    {
        /*
         * Disable by option on refresh data
         * */
        if(!($this->pluginSettings->getDisableCronjobOption() == 'true')){
            $this->scheduler->refreshHQData();
        }
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


