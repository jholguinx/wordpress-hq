<?php

namespace HQRentalsPlugin\Webhooks;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsScheduler;

class HQRentalsWebhooksManager{

    public function __construct()
    {
        $this->scheduler = new HQRentalsScheduler();
        add_action( 'rest_api_init', array($this, 'setCustomAPIRoutes') );
    }
    public function setCustomApiRoutes(){
        register_rest_route( 'hqrentals', '/update/', array(
            'methods' => 'POST',
            'callback' => array ($this, 'fireUpdate'),
        ) );
    }
    public function fireUpdate(\WP_REST_Request $request)
    {
        //Should be validate -> add Success params to the response
        $this->scheduler->refreshHQData();
        $data = array(
            'message'   =>  'Successful Update',
            'status'    =>  200,
            'data'      =>  []
        );
        $response = new \WP_REST_Response($data);
        $response->status = 200;
        return $response;
    }
}