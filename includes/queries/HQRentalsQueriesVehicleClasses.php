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
        foreach ($vehicleClassesPosts as $post){
            $vehicle = new HQRentalsModelsVehicleClass($post);
            $data[] = $vehicle;
        }
        return $data;
    }
    public function getVehicleClassIdFromPost($post){
        if(get_post_type($post) === 'hqwp_veh_classes'){
            $class = new HQRentalsModelsVehicleClass($post);
            return $class->id;
        }else{
            return '';
        }
    }
    public function getVehicleClassFilterByCustomField($filterField, $value)
    {
        $data = array();
        $args = array_merge(
            $this->model->postArgs,
            array(
                'meta_query'    =>  array(
                    array(
                        'key'       => $this->model->getCustomFieldMetaPrefix() . $filterField,
                        'value'     =>  $value,
                        'compare'   =>  '='
                    )
                )
            )
        );
        $query = new \WP_Query($args);
        foreach ($query->posts as $post){
            $class = new HQRentalsModelsVehicleClass($post);
            $data[] = $class;
        }
        return $data;
    }

	public function getAllMetaKey() {
    	return 'hq_wordpress_vehicle_class_all_for_frontend';
	}
}