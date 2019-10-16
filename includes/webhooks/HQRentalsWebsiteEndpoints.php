<?php

namespace HQRentalsPlugin\Webhooks;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesBrands;

class HQRentalsWebsiteEndpoints{

    public function __construct()
    {
        add_action( 'rest_api_init', array($this, 'setEndpoints') );
    }
    public function setEndpoints(){
        //baseURl/wp-json/hqrentals/brands/
        register_rest_route( 'hqrentals', '/brands/', array(
            'methods' => 'GET',
            'callback' => array ($this, 'brands'),
        ));
    }
    public function brands(){
        $query = new HQRentalsQueriesBrands();
        $brands = $query->brandsPublicInterface();
        return $this->resolveResponse($brands, true);
    }
    public function resolveResponse($data, $status){
        if(! empty($data) and $status){
            $response = new \WP_REST_Response($this->resolveResponseData($data), true);
            $response->status = 200;
            return $response;
        }else{
            $response = new \WP_REST_Response($this->resolveResponseData([]), false);
            $response->status = 500;
            return $response;
        }
    }
    public function resolveResponseData($data, $success = true){
        return array(
            'success' => ! empty($success),
            'data'  =>  $data
        );
    }
}