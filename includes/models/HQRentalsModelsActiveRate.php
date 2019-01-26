<?php

namespace HQRentalsPlugin\HQRentalsModels;

class HQRentalsModelsActiveRate extends HQRentalsBaseModel
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
    public $id = '';
    public $seasonId = '';
    public $vehicleClassId = '';
    public $baseRate = '';
    public $minuteRate = '';
    public $hourlyRate = '';
    public $dailyRate = '';
    public $weeklyRate = '';
    public $monthlyRate = '';

    public function __construct($vehicleClassID = null)
    {
        $this->post_id = '';
        $this->postArg = array(
            'post_type'         => $this->activeRateCustomPostName,
            'post_status'       => 'publish',
            'posts_per_page'    =>  -1
        );
        if (!empty($vehicleClassID)) {
            $this->setFromVehicleClass($vehicleClassID);
        }
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
                'post_title' => 'Active Rate ' . $this->id,
                'post_name' => 'Active Rate ' . $this->id
            )
        );
        $post_id = wp_insert_post($this->postArg);
        $this->post_id = $post_id;
        hq_update_post_meta($post_id, $this->metaId, $this->id);
        hq_update_post_meta($post_id, $this->metaSeasonId, $this->seasonId);
        hq_update_post_meta($post_id, $this->metaVehicleIdClass, $this->vehicleClassId);
        hq_update_post_meta($post_id, $this->metaBaseRate, $this->baseRate);
        hq_update_post_meta($post_id, $this->metaMinuteRate, $this->minuteRate);
        hq_update_post_meta($post_id, $this->metaHourRate, $this->hourlyRate);
        hq_update_post_meta($post_id, $this->metaDailyRate, $this->dailyRate);
        hq_update_post_meta($post_id, $this->metaWeeklyRate, $this->weeklyRate);
        hq_update_post_meta($post_id, $this->metaMonthlyRate, $this->monthlyRate);
    }

    public function find($vehicleClassPostId)
    {
        $args = array_merge(
            $this->postArg,
            array(
                'posts_per_page' => -1,
                'meta_query' => array(
                    array(
                        'key' => $this->metaVehicleIdClass,
                        'value' => $caag_vehicle_class_id,
                        'compare' => '='
                    )
                )
            )
        );
        $query = new \WP_Query($args);
        return $query->posts;
    }

    public function first()
    {
        // TODO: Implement first() method.
    }

    public function all()
    {
        $query = new \WP_Query();
        return $query->posts;
    }

    public function set($data)
    {
        if ($this->filter->isPost($data)) {

        } else {
        }
        //$metas =
    }

    /***
     * Maps Class Properties with Posts Metas
     * @return array
     */
    public function getAllMetaTag()
    {
        return array(
            'id'                => $this->metaId,
            'seasonId'          => $this->metaSeasonId,
            'vehicleClassId'    => $this->metaVehicleIdClass,
            'baseRate'          => $this->metaBaseRate,
            'minuteRate'        => $this->metaMinuteRate,
            'hourlyRate'        => $this->metaHourRate,
            'dailyRate'         => $this->metaDailyRate,
            'weeklyRate'        => $this->metaWeeklyRate,
            'monthlyRate'       => $this->metaMonthlyRate
        );
    }

    public function getQueryArgumentsFromVehicleClass($vehicleClassID)
    {
        return array_merge(
            $this->postArg,
            array(
                'meta_query'    => array(
                        array(
                            'key'       => $this->metaVehicleIdClass,
                            'value'     => $vehicleClassID,
                            'compare'   => '='
                        )
                )
            )
        );
    }

    public function setFromVehicleClass($vehicleClassId)
    {
        $query = new \WP_Query($this->getQueryArgumentsFromVehicleClass($vehicleClassId));
        $post = $query->posts[0];
        foreach ($this->getAllMetaTag() as $property => $metakey) {
            $this->{$property} = get_post_meta($post->ID, $metakey, true);
        }
    }


    public function getFormattedBaseRate()
    {
        return number_format((float) $this->baseRate, 2, '.', '');
    }
    public function getFormmattedMinuteRate()
    {
        return number_format((float) $this->minuteRate, 2, '.', '');
    }
    public function getFormmattedHourlyRate()
    {
        return number_format((float) $this->hourlyRate, 2, '.', '');
    }
    public function getFormmattedDailyRate()
    {
        return number_format((float) $this->dailyRate, 2, '.', '');
    }
    public function getFormmattedWeeklyRate()
    {
        return number_format((float) $this->weeklyRate, 2, '.', '');
    }
    public function getFormmattedMonthlyRate()
    {
        return number_format((float) $this->monthlyRate, 2, '.', '');
    }
}
