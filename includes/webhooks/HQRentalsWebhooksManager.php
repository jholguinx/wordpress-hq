<?php

namespace HQRentalsPlugin\Webhooks;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsScheduler;
use HQRentalsPlugin\HQRentalsActions\HQRentalsUpgrader;

class HQRentalsWebhooksManager{

    public function __construct()
    {
        $this->scheduler = new HQRentalsScheduler();
        $this->upgrader = new HQRentalsUpgrader();
        add_action( 'rest_api_init', array($this, 'setCustomAPIRoutes') );
    }
    public function setCustomApiRoutes(){
        //baseURl/wp-json/hqrentals/update/
        register_rest_route( 'hqrentals', '/update/', array(
            'methods' => 'POST',
            'callback' => array ($this, 'fireUpdate'),
        ) );
        //baseURl/wp-json/hqrentals/plugin/upgrade/
        register_rest_route( 'hqrentals', '/plugin/upgrade/', array(
            'methods' => 'POST',
            'callback' => array ($this, 'firePluginUpgrade'),
        ) );
    }
    public function fireUpdate(\WP_REST_Request $request)
    {
        //Should be validated -> add Success params to the response
        $this->scheduler->refreshHQData();
        $data = $this->resolveResponse();
        $response = new \WP_REST_Response($data);
        $response->status = 200;
        return $response;
    }
    public function firePluginUpgrade()
    {
        $response = $this->upgrader->upgradePlugin();
        if($response){
            $data = $this->resolveResponse($response);
            $response = new \WP_REST_Response($data);
            $response->status = 200;
            return $response;
        }else{
            $data = $this->resolveResponse($response);
            $response = new \WP_REST_Response($data);
            $response->status = 500;
            return $response;
        }

    }
    public function resolveResponse($data){
        return array(
            'message'   =>  'Successful Update',
            'status'    =>  200,
            'data'      =>  empty($data) ? [] : $data
        );
    }
}