<?php

namespace HQRentalsPlugin\HQRentalsModels;

class HQRentalsModelsPriceInterval extends HQRentalsBaseModel
{
    /*
     * Custom Post Configuration
     */
    public $priceIntervalCustomPostName = 'hqwp_price_inter';
    public $priceIntervalCustomPostSlug = 'price-interval';

    /*
     * HQ Rentals Active Rate Data
     * Custom Post Meta
     */
    protected $metaVehicleIdClass = 'hq_wordpress_price_interval_vehicle_class_id_meta';
    protected $metaOrder = 'hq_wordpress_price_interval_order_meta';
    protected $metaPrice = 'hq_wordpress_price_interval_price_meta';
    protected $metaStartInterval = 'hq_wordpress_price_interval_start_interval_meta';
    protected $metaEndInterval = 'hq_wordpress_price_interval_end_interval_meta';


    /*
     * Object Data to Display
     */
    public $vehicleClassId = '';
    public $order = '';
    public $price = '';
    public $startInterval = '';
    public $endInterval = '';
    public $post_id = '';

    public function __construct($post = null)
    {
        $this->post_id = '';
        $this->postArg = array(
            'post_type'         => $this->priceIntervalCustomPostName,
            'post_status'       => 'publish',
            'posts_per_page'    =>  -1
        );
        if (!empty($post)) {
            $this->setFromPost($post);
        }
    }
    public function setFromPost($post)
    {
        foreach ($this->getAllMetaTags() as $property => $metakey) {
            $this->{$property} = get_post_meta($post->ID, $metakey, true);
        }
        $this->post_id = $post->ID;
    }
    public function setIntervalRateFromApi($data, $vehicle_class_id)
    {
        $this->vehicleClassId = $vehicle_class_id;
        $this->order = $data->order;
        $this->price = $data->price;
        $this->startInterval = $data->start_interval;
        $this->endInterval = $data->end_interval;
    }

    public function create()
    {
        $this->postArg = array_merge(
            $this->postArg,
            array(
                'post_title' => 'Price Interval',
                'post_name' => 'Price Interval'
            )
        );
        $post_id = wp_insert_post($this->postArg);
        $this->post_id = $post_id;
        hq_update_post_meta($post_id, $this->metaVehicleIdClass, $this->vehicleClassId);
        hq_update_post_meta($post_id, $this->metaOrder, $this->order);
        hq_update_post_meta($post_id, $this->metaPrice, $this->price);
        hq_update_post_meta($post_id, $this->metaStartInterval, $this->startInterval);
        hq_update_post_meta($post_id, $this->metaEndInterval, $this->endInterval);
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

    public function all()
    {
        $query = new \WP_Query( $this->postArg );
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
    public function getAllMetaTags()
    {
        return array(
            'vehicleClassId'    => $this->metaVehicleIdClass,
            'price'             =>  $this->metaPrice,
            'order'             =>  $this->metaOrder,
            'endInterval'       =>  $this->metaEndInterval,
            'startInterval'     =>  $this->metaStartInterval
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
    public function getIntervalPricesByVehicleId($classId){
        $args = array_merge(
            $this->postArg,
            array(
                'meta_query'    =>  array(
                    array(
                        'key'       =>  $this->metaVehicleIdClass,
                        'value'     =>  $classId,
                        'compare'   =>  '='
                    )
                )
            )
        );
        $query = new \WP_Query($args);
        return $query->posts;
    }
    public function getCheapestPriceInterval($vehicleClassId)
    {
       $args = array_merge(
           $this->postArg,
           array(
               'meta_key'   =>  $this->metaPrice,
               'orderby'    =>  'meta_value',
               'order'      =>  'ASC',
           ),
           array(
               'meta_query' =>  array(
                   'key'       =>  $this->metaVehicleIdClass,
                   'value'     =>  $vehicleClassId,
                   'compare'   =>  '='
               )
           )
       );
       $query = new \WP_Query($args);
       return $query->posts[0];
    }
    public function formatPrice($decimal = 2)
    {
        return number_format((float) $this->price, $decimal, '.', '');
    }
}
