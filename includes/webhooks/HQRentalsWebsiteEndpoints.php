<?php

namespace HQRentalsPlugin\Webhooks;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesBrands;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;
use mysql_xdevapi\Exception;

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
        register_rest_route( 'hqrentals', '/brand/', array(
            'methods' => 'GET',
            'callback' => array ($this, 'brand'),
        ));
        register_rest_route( 'hqrentals', '/shortcodes/bookingform', array(
            'methods' => 'GET',
            'callback' => array ($this, 'bookingform'),
        ));
        register_rest_route( 'hqrentals', '/shortcodes/vehicle-types', array(
            'methods' => 'GET',
            'callback' => array ($this, 'vehicleTypes'),
        ));
    }
    public function brand()
    {
        $id = $_GET['id'];
        try {
            if (empty($id)) {
                return $this->resolveResponse("Brand id Empty", false);
            } else {
                $query = new HQRentalsQueriesBrands();
                return $this->resolveResponse($query->singleBrandPublicInterface($id), true);
            }
        } catch (Exception $e){
            return $this->resolveResponse($e, false);
        }

    }
    public function brands(){
        try{
            $query = new HQRentalsQueriesBrands();
            $brands = $query->brandsPublicInterface();
            return $this->resolveResponse($brands, true);
        }catch (Exception $e){
            return $this->resolveResponse($e, false);
        }

    }
    public function resolveResponse($data, $status){
        if(! empty($data) and $status){
            $response = new \WP_REST_Response($this->resolveResponseData($data), true);
            $response->status = 200;
            return $response;
        }else{
            $response = new \WP_REST_Response($this->resolveResponseData([]), false);
            $response->status = 404;
            return $response;
        }
    }
    public function resolveResponseData($data, $success = true){
        return array(
            'success' => ! empty($success),
            'data'  =>  $data
        );
    }
    public function bookingform()
    {
        try{
            $query = new HQRentalsQueriesBrands();
            $queryLocation = new HQRentalsQueriesLocations();
            $brands = $query->brandsPublicInterface();
            $locations = $queryLocation->locationsPublicInterface();
            $responseData = new \stdClass();
            $responseData->locations = $locations;
            $responseData->brands = $brands;
            return $this->resolveResponse($responseData, true);
        }catch (Exception $e){
            return $this->resolveResponse($e, false);
        }
    }
    public function vehicleTypes(){
        $brandID = $_GET['brand_id'];
        $customField = $_GET['custom_field'];
        try{
            $query = new HQRentalsQueriesVehicleClasses();
            $vehicles = $query->getVehicleClassesByBrand($brandID);
            $types = array();
            foreach ($vehicles as $vehicle){
                $type = $vehicle->getCustomField($customField);
                if(! in_array($type, $types) ){
                    $types[] = $type;
                }
            }
            return $this->resolveResponse($types, true);
        }catch (Exception $e){
            return $this->resolveResponse($e, false);
        }
    }
}