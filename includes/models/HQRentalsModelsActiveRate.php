<?php
namespace HQRentalsPlugin\HQRentalsModels;

class HQRentalsModelsActiveRate
{
    /*
     * Custom Post Configuration
     */
    public $activeRateCustomPostName = 'hqwp_active_rate';
    public $activeRateCustomPostSlug = 'rate';

    /*
     * HQ Rentals Active Rate Data
     * Custom Post Meta
     */

    protected $metaId = 'hq_wordpress_active_rate_id_meta';
    protected $metaSeasonId = 'hq_wordpress_active_rate_season_id_meta';
    protected $metaVehicleIdClass = 'hq_wordpress_active_rate_vehicle_class_id_meta';
    protected $metaBaseRate = 'hq_wordpress_active_rate_base_rate_meta';
    protected $metaMinuteRate = 'hq_wordpress_active_rate_minute_rate_meta';
    protected $metaHourRate = 'hq_wordpress_active_rate_hourly_rate_meta';
    protected $metaDailyRate = 'hq_wordpress_active_rate_daily_rate_meta';
    protected $metaWeeklyRate = 'hq_wordpress_active_rate_weekly_rate_meta';
    protected $metaMonthlyRate = 'hq_wordpress_active_rate_monthly_rate_meta';


    /*
     * Object Data to Display
     */
    protected $id = '';
    protected $seasonId = '';
    protected $vehicleClassId = '';
    protected $baseRate = '';
    protected $minuteRate = '';
    protected $hourlyRate = '';
    protected $dailyRate = '';
    protected $weeklyRate = '';
    protected $monthlyRate = '';

    public function __construct()
    {
        $this->post_id = '';
        $this->postArg = array(
            'post_type'     =>  $this->activeRateCustomPostName,
            'post_status'   =>  'publish'
        );
    }

    public function setActiveRateFromApi($data)
    {
        $this->id = $data->id;
        $this->seasonId = $data->season_id;
        $this->vehicleClassId = $data->vehicle_class_id;
        $this->baseRate = $data->base_rate;
        $this->minuteRate = $data->minute_rate;
        $this->hourlyRate = $data->hourly_rate;
        $this->dailyRate = $data->daily_rate;
        $this->weeklyRate = $data->weekly_rate;
        $this->monthlyRate = $data->monthly_rate;
    }

    public function create()
    {
        //ojo si da problemas con esot
        $this->postArg = array_merge(
            $this->postArg,
            array(
                'post_title'    =>  'Active Rate ' .  $this->id,
                'post_name'     =>  'Active Rate ' . $this->id
            )
        );
        $post_id = wp_insert_post( $this->postArg );
        $this->post_id = $post_id;
        update_post_meta( $post_id, $this->metaId, $this->id );
        update_post_meta( $post_id, $this->metaSeasonId, $this->seasonId );
        update_post_meta( $post_id, $this->metaVehicleIdClass, $this->vehicleClassId );
        update_post_meta( $post_id, $this->metaBaseRate, $this->baseRate );
        update_post_meta( $post_id, $this->metaMinuteRate, $this->minuteRate );
        update_post_meta( $post_id, $this->metaHourRate, $this->hourlyRate );
        update_post_meta( $post_id, $this->metaDailyRate, $this->dailyRate );
        update_post_meta( $post_id, $this->metaWeeklyRate, $this->weeklyRate );
        update_post_meta( $post_id, $this->metaMonthlyRate, $this->monthlyRate );
    }
    public function  update()
    {
        update_post_meta( $this->post_id, $this->metaId, $this->id );
        update_post_meta( $this->post_id, $this->metaSeasonId, $this->seasonId );
        update_post_meta( $this->post_id, $this->metaVehicleIdClass, $this->vehicleClassId );
        update_post_meta( $this->post_id, $this->metaBaseRate, $this->baseRate );
        update_post_meta( $this->post_id, $this->metaMinuteRate, $this->minuteRate );
        update_post_meta( $this->post_id, $this->metaHourRate, $this->hourlyRate );
        update_post_meta( $this->post_id, $this->metaDailyRate, $this->dailyRate );
        update_post_meta( $this->post_id, $this->metaWeeklyRate, $this->weeklyRate );
        update_post_meta( $this->post_id, $this->metaMonthlyRate, $this->monthlyRate );
    }
    
    public function delete()
    {
        delete_post_meta( $this->post_id, $this->metaId );
        delete_post_meta( $this->post_id, $this->metaSeasonId );
        delete_post_meta( $this->post_id, $this->metaVehicleIdClass );
        delete_post_meta( $this->post_id, $this->metaBaseRate );
        delete_post_meta( $this->post_id, $this->metaMinuteRate );
        delete_post_meta( $this->post_id, $this->metaHourRate );
        delete_post_meta( $this->post_id, $this->metaDailyRate );
        delete_post_meta( $this->post_id, $this->metaWeeklyRate );
        delete_post_meta( $this->post_id, $this->metaMonthlyRate );
        $post_id = wp_delete_post( $this->post_id , true );
    }
    public function find($caag_id)
    {
        $query = new \WP_Query( $this->postArgs );
    }

    public function first()
    {
        // TODO: Implement first() method.
    }
    public function all()
    {
        $query = new \WP_Query($this->postArgs);
    }
    public function set($data)
    {
        if($this->filter->isPost($data)){

        }else{}
        //$metas =
    }
}
