<?php
namespace HQRentalsPlugin\HQRentalsHelpers;
use HQRentalsPlugin\HQRentalsTasks\HQRentalsScheduler;


class HQRentalsFilters{


    public function __construct()
    {
        $this->scheduler = new HQRentalsScheduler();
        add_action( 'rest_api_init', array($this, 'setCustomAPIRoutes') );
    }
    public function setCustomApiRoutes(){
        register_rest_route( 'hqrentals', '/update/', array(
            'methods' => 'GET',
            'callback' => 'fireUpdate',
        ) );
    }
    public function fireUpdate()
    {
        return array(
            'gay'   =>  false
        );
    }
}
function fireUpdate(\WP_REST_Request $request)
{
    return array(
        'gay'   =>  false
    );

}