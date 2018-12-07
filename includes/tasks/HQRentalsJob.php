<?php

namespace HQRentalsPlugin\HQRentalsTasks;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsScheduler;

class HQRentalsJob{
    public function __construct()
    {
        $scheduler = new HQRentalsScheduler();
        add_action( 'refreshAllHQDataJob', array( $this, 'refreshAllData' );
        if ( ! wp_next_scheduled( array( $this, 'refreshAllData' ) ) ) {
            wp_schedule_event( time(), 'hourly', 'refreshAllHQDataJob' );
        }
    }
    function refreshAllData(){

    }
    function caag_hq_vehicle_classes_cron_job()
    {
    }
    add_action('caag_hq_vehicle_classes_update','caag_hq_vehicle_classes_cron_job');

}


