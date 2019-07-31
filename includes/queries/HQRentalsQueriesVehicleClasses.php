<?php

namespace HQRentalsPlugin\HQRentalsQueries;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;



class HQRentalsQueriesVehicleClasses extends HQRentalsQueriesBaseClass
{
    /**
     * HQRentalsQueriesVehicleClasses constructor.
     */
    public function __construct()
    {
        $this->model = new HQRentalsModelsVehicleClass();
        $this->rateQuery = new HQRentalsQueriesActiveRates();
    }


    /***
     * Return all vehicles classes order by daily rate
     * @param null $order
     * @return array
     */
    public function allVehicleClasses($order = null)
    {
        /*
         * By Default the vehicles classes should be order by price
         * */
        $rates = $this->rateQuery->allActiveRates($order);
        $data = [];
        foreach ($rates as $rate){
            $data[] = $this->getVehicleClassBySystemId($rate->vehicleClassId);
        }
        return $data;
    }

    /**
     * Retrieve classes by order
     * @return array
     */
    public function allVehicleClassesByOrder()
    {
        $args = array_merge(
            $this->model->postArgs,
            array(
                'order'     =>  'ASC',
                'orderby'   =>  'meta_value_num',
                'meta_key'  =>  $this->model->getOrderMetaKey(),
            )
        );
        $query = new \WP_Query($args);
        return $this->fillModelWithPosts($query->posts);
    }

    /**
     * Retrieve vehicle class id from WP Post
     * @param $post
     * @return string
     */
    public function getVehicleClassIdFromPost($post)
    {
        if (get_post_type($post) === 'hqwp_veh_classes') {
            $class = new HQRentalsModelsVehicleClass($post);
            return $class->id;
        } else {
            return '';
        }
    }


    public function getVehicleClassFilterByCustomField($dbColumn, $value)
    {
        $args = array_merge(
            $this->model->postArgs,
            array(
                'meta_query' => array(
                    array(
                        'key' => $this->model->getCustomFieldMetaPrefix() . $dbColumn,
                        'value' => $value,
                        'compare' => '='
                    )
                )
            )
        );
        $query = new \WP_Query($args);
        return $this->fillModelWithPosts($query->posts);
    }

    /**
     * Retrieve vehicle class by system id
     * @param $hqId
     * @return HQRentalsModelsVehicleClass
     */
    public function getVehicleClassBySystemId($hqId)
    {
        $args = array_merge(
            $this->model->postArgs,
            array(
                'meta_query' => array(
                    array(
                        'key' => 'hq_wordpress_vehicle_class_id_meta',
                        'value' => $hqId,
                        'compare' => '='
                    )
                )
            )
        );
        $query = new \WP_Query($args);
        return new HQRentalsModelsVehicleClass($query->posts[0]);
    }

    /**
     * Retrieve all vehicle classes to front end
     * @return array
     */
    public function allToFrontEnd()
    {
        $vehiclesPost = $this->model->all();
        $data = [];
        foreach ($vehiclesPost as $post) {
            $vehicle = new HQRentalsModelsVehicleClass($post);
            $newData = new \stdClass();
            $newData->id = $vehicle->id;
            $newData->name = $vehicle->name;
            $newData->permalink = $vehicle->permalink;
            $data[] = $newData;
        }
        return $data;
    }


    /**
     * Retrieves all distinct meta value from the vehicle classes
     * @param $dbColumn
     * @return array|null|object
     */
    public function getAllDifferentsValuesFromCustomField($dbColumn)
    {
        global $wpdb;
        $queryString = "SELECT DISTINCT(meta_value)
                    FROM {$wpdb->prefix}postmeta 
                    WHERE meta_key = '" . $this->model->getCustomFieldMetaPrefix() . $dbColumn . "'
                    ";
        $data = $wpdb->get_results($queryString, ARRAY_A);
        return array_filter($data, function ($item) {
            return $item['meta_value'] != 'N;';
        });
    }

    /***
     * Retrieve Cheaspest classes from custom field value
     * @param $dbColumn
     * @return array
     */
    public function getCheapestClassesFromCustomField($dbColumn)
    {
        $customFieldsValues = $this->getAllDifferentsValuesFromCustomField($dbColumn);
        $data = [];
        foreach ($customFieldsValues as $value) {
            $data[] = $this->getCheapestClassFromCustomFieldValue($dbColumn, $value['meta_value']);
        }
        return $data;
    }
    public function getCheapestClassesFromCustomFieldAndPriceIntervals($dbColumn)
    {
        $customFieldsValues = $this->getAllDifferentsValuesFromCustomField($dbColumn);
        $data = [];
        foreach ($customFieldsValues as $value) {
            $data[] = $this->getCheapestClassFromCustomFieldValueAndPriceInterval($dbColumn, $value['meta_value']);
        }
        return $data;
    }

    /**
     * Retrieve vehicle classes filter by a single custom field value
     * @param $dbColumn
     * @param $value
     * @return array
     */
    public function getClassFromCustomField($dbColumn, $value)
    {
        $args = array_merge(
            $this->model->postArgs,
            array(
                'meta_query' => array(
                    array(
                        'key' => $this->model->getCustomFieldMetaPrefix() . $dbColumn,
                        'value' => $value,
                        'compare' => '='
                    )
                )
            )
        );
        $query = new \WP_Query($args);
        return $this->fillModelWithPosts($query->posts);
    }
    public function getClassesFilterByCustomField($dbColumn, $value)
    {
        $args = array_merge(
            $this->model->postArgs,
            array(
                'meta_query' => array(
                    array(
                        'key' => $this->model->getCustomFieldMetaPrefix() . $dbColumn,
                        'value' => $value,
                        'compare' => '='
                    )
                )
            )
        );
        $query = new \WP_Query($args);
        return $query->posts;
    }

    /***
     * Retrieve a single vehicle class filter by custom field
     * @param $dbColumn
     * @param $value
     * @return array|HQRentalsModelsVehicleClass
     */
    public function getCheapestClassFromCustomFieldValue($dbColumn, $value)
    {
        $args = array_merge(
            $this->model->postArgs,
            array(
                'meta_query' => array(
                    array(
                        'key' => $this->model->getCustomFieldMetaPrefix() . $dbColumn,
                        'value' => $value,
                        'compare' => '='
                    )
                )
            )
        );
        $query = new \WP_Query($args);
        if (empty($query->posts)) {
            return array();
        } else {
            $cheapestPost = new HQRentalsModelsVehicleClass($query->posts[0]);
        }
        foreach ($query->posts as $post) {
            $newClass = new HQRentalsModelsVehicleClass($post);
            if ($cheapestPost->rate()->getFormattedDailyRateAsNumber() < $newClass->rate()->getFormattedDailyRateAsNumber()) {
                $cheapestPost = $newClass;
            }
        }
        return $cheapestPost;
    }

    /**
     * Retrieve a single class filter by custom field and based on proce intervals
     * @param $dbColumn
     * @param $value
     * @return array|HQRentalsModelsVehicleClass
     */
    public function getCheapestClassFromCustomFieldValueAndPriceInterval($dbColumn, $value)
    {
        $args = array_merge(
            $this->model->postArgs,
            array(
                'meta_query' => array(
                    array(
                        'key' => $this->model->getCustomFieldMetaPrefix() . $dbColumn,
                        'value' => $value,
                        'compare' => '='
                    )
                )
            )
        );
        $query = new \WP_Query($args);

        if (empty($query->posts)) {
            return array();
        } else {
            $cheapestPost = new HQRentalsModelsVehicleClass($query->posts[0]);
        }
        foreach ($query->posts as $post) {
            $newClass = new HQRentalsModelsVehicleClass($post);
            if ($cheapestPost->getCheapestPriceInterval()->getPriceAsANumber() > $newClass->getCheapestPriceInterval()->getPriceAsANumber()) {
                $cheapestPost = $newClass;
            }
        }
        return $cheapestPost;


    }

    public function getAllMetaKey()
    {
        return 'hq_wordpress_vehicle_class_all_for_frontend';
    }

    /***
     * Fills Models with Posts
     * @param $posts
     * @return array
     */
    public function fillModelWithPosts( $posts )
    {
        $data = [];
        foreach ($posts as $post){
            $data[] = new HQRentalsModelsVehicleClass($post);
        }
        return $data;
    }

    /***
     * Retrieve ids from vehicles classes filtering by custom field
     *
     * @param $dbColumn
     * @param $value
     * @return array
     */
    public function getVehiclesIdsFromCustomField( $dbColumn, $value ){
        $classes = $this->getVehicleClassFilterByCustomField( $dbColumn, $value );
        $data = [];
        foreach ($classes as $class){
            $data[] = $class->id;
        }
        return $data;
    }
}