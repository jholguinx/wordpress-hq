<?php
namespace HQRentalsPlugin\HQRentalsApihelpers;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector;


class HQRentalsApihelpersAvailability{

    protected static $systemFormat = 'Y-m-d H:i';

    public function __construct()
    {
        $this->connector = new HQRentalsApiConnector();
    }
    public static function getAvailability($startDate = '', $endDate = '', $brandId = '1')
    {
        $data = array(
            'start_date'    =>  $startDate,
            'end_date'      =>  $endDate,
            'brand_id'      =>  $brandId
        );
        $connector = new HQRentalsApiConnector();
        return $connector->getHQRentalsAvailability($data);
    }
}