<?php

namespace HQRentalsPlugin\HQRentalsModels;

use HQRentalsPlugin\HQRentalsHelpers\HQRentalsDataFilter;

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
    public $vehicleClassId = '';
    public $baseRate = '';
    public $minuteRate = '';
    public $hourlyRate = '';
    public $dailyRate = '';
    public $weeklyRate = '';
    public $monthlyRate = '';

    public function __construct($vehicleClassID = null, $allRates = null)
    {
        $this->post_id = '';
        $this->dataType = new HQRentalsDataFilter();
        $this->postArg = array(
            'post_type'         => $this->activeRateCustomPostName,
            'post_status'       => 'publish',
            'posts_per_page'    =>  -1
        );
        if ($this->dataType->isPost($vehicleClassID)){
            $this->setFromPost($vehicleClassID);
        }else if(!empty($vehicleClassID)) {
            $this->setFromVehicleClass($vehicleClassID, $allRates);
        }
    }

    public function setActiveRateFromApi($vehicle_class_id, $data)
    {
        $this->baseRate = $data->daily_rate;
        $this->vehicleClassId = $vehicle_class_id;
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
                        'value' => $vehicleClassPostId,
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

    public function all($order = 'daily')
    {
        $args = array_merge(
            $this->postArg,
            array(
                'order'     => 'ASC',
                'orderby'   =>  'meta_value_num',
                'meta_key'  =>  ( ! ( empty($order) ) ) ? $this->getOrderMetaForQuery($order) : $this->metaDailyRate
            )
        );
        $query = new \WP_Query( $args );
        return $query->posts;
    }

    public function setFromPost($post)
    {
        foreach ($this->getAllMetaTag() as $property => $metaKey){
            $this->{$property} = get_post_meta($post->ID, $metaKey, true);
        }
    }

    /***
     * Maps Class Properties with Posts Metas
     * @return array
     */
    public function getAllMetaTag()
    {
        return array(
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

    public function setFromVehicleClass($vehicleClassId, $getAllRates = null)
    {
        $query = new \WP_Query($this->getQueryArgumentsFromVehicleClass($vehicleClassId));
        $post = $query->posts[0];
        foreach ($this->getAllMetaTag() as $property => $metakey) {
            $this->{$property} = get_post_meta($post->ID, $metakey, true);
        }
    }
    public function allRatesFromVehicleClass($vehicleClassId)
    {
        $query = new \WP_Query($this->getQueryArgumentsFromVehicleClass($vehicleClassId));
        $rates= [];
        foreach ($query->posts as $postRate){
            $rates[] = new HQRentalsModelsActiveRate($postRate);
        }
        return $rates;
    }
    public function formatRateForDisplay($rate)
    {
        if($rate and $rate !== "0.00"){

            return number_format((float) $rate, 2, '.', '');
        }else{
            return '';
        }
    }

    public function getFormattedBaseRate()
    {
        return $this->formatRateForDisplay($this->baseRate->amount);
    }
    public function getFormattedBaseRateAsNumber()
    {
        return (float)$this->getFormattedBaseRate();
    }
    public function getFormattedMinuteRate()
    {
        return $this->formatRateForDisplay($this->minuteRate->amount);
    }
    public function getFormattedMinuteRateAsNumber()
    {
        return (float)$this->getFormattedMinuteRate();
    }
    public function getFormattedHourlyRate()
    {
        return $this->formatRateForDisplay($this->hourlyRate->amount);
    }
    public function getFormattedHourlyRateAsNumber()
    {
        return (float)$this->getFormattedHourlyRate();
    }
    public function getFormattedDailyRate()
    {
        return $this->formatRateForDisplay($this->dailyRate->amount);
    }
    public function getFormattedDailyRateAsNumber(){
        return (float)$this->getFormattedDailyRate();
    }
    public function getFormattedWeeklyRate()
    {
        return $this->formatRateForDisplay($this->weeklyRate->amount);
    }
    public function getFormattedWeeklyRateAsNumber()
    {
        return (float)$this->getFormattedWeeklyRate();
    }
    public function getFormattedMonthlyRate()
    {
        return $this->formatRateForDisplay($this->monthlyRate->amount);
    }
    public function getFormattedMonthlyRateAsNumber()
    {
        return (float)$this->getFormattedMonthlyRate();
    }
    public function getOrderMetaForQuery($order)
    {
        switch ($order) {
            case 'minute':
                return $this->metaMinuteRate;
                break;
            case 'hourly':
                return $this->metaHourRate;
                break;
            case 'daily':
                return $this->metaDailyRate;
                break;
            case 'weekly':
                return $this->metaWeeklyRate;
                break;
            case 'monthly':
                return $this->metaMonthlyRate;
                break;
            default:
                return $this->metaDailyRate;
                break;
        }
    }
    public function ratePublicInterface()
    {
        $data = new \stdClass();
        $data->dailyRate = $this->getFormattedDailyRate();
        return $data;
    }
}
