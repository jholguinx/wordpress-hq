<?php
namespace HQRentalsPlugin\HQRentalsQueries;
use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsFeature;

class HQRentalsQueriesFeatures
{
    public function __construct()
    {
        $this->model = new HQRentalsModelsFeature();
    }
    public function getVehicleClassFeatures($classId)
    {
        $data = array();
        $args = array_merge(
            $this->model->postArgs,
            array(
                'order'             =>  'DESC',
                'posts_per_page'    =>   -1,
                'orderby'           =>  'meta_value_num',
                'meta_key'          =>  $this->model->metaOrderKey,
                'meta_query'        =>  array(
                    array(
                        'key'       =>  $this->model->metaClassId,
                        'value'     =>  $classId,
                        'compare'   =>  '='
                    )
                )
            )
        );
        $query = new \WP_Query( $args );
        foreach ( $query->posts as $post ){
            $data[] = new HQRentalsModelsFeature( $post );
        }
        return $data;
    }
}