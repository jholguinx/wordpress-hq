<?php

namespace HQRentalsPlugin\HQRentalsQueries;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsVehicleClass;


class HQRentalsQueriesVehicleClasses extends HQRentalsQueriesBaseClass
{
    public function __construct()
    {
        $this->model = new HQRentalsModelsVehicleClass();
    }

    public function allVehicleClasses()
    {
        $vehicleClassesPosts = $this->model->all();
        $data = array();
        foreach ($vehicleClassesPosts as $post) {
            $vehicle = new HQRentalsModelsVehicleClass($post);
            $data[] = $vehicle;
        }
        return $data;
    }

    public function getVehicleClassIdFromPost($post)
    {
        if (get_post_type($post) === 'hqwp_veh_classes') {
            $class = new HQRentalsModelsVehicleClass($post);
            return $class->id;
        } else {
            return '';
        }
    }

    public function getVehicleClassFilterByCustomField($filterField, $value)
    {
        $data = array();
        $args = array_merge(
            $this->model->postArgs,
            array(
                'meta_query' => array(
                    array(
                        'key' => $this->model->getCustomFieldMetaPrefix() . $filterField,
                        'value' => $value,
                        'compare' => '='
                    )
                )
            )
        );
        $query = new \WP_Query($args);
        foreach ($query->posts as $post) {
            $class = new HQRentalsModelsVehicleClass($post);
            $data[] = $class;
        }
        return $data;
    }

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

    public function getAllValuesFromCustomField($dbColumn)
    {
        global $wpdb;
        $queryString = "SELECT DISTINCT(meta_value)
                    FROM {$wpdb->prefix}postmeta 
                    WHERE meta_key = '" . $this->model->getCustomFieldMetaPrefix() . $dbColumn . "'
                    ";
        $data = $wpdb->get_results($queryString, ARRAY_A);
        return array_filter( $data, function($item){
            return $item['meta_value'] != 'N;';
    } );

    }

    public function getAllMetaKey()
    {
        return 'hq_wordpress_vehicle_class_all_for_frontend';
    }
}