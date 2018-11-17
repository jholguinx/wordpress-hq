<?php

namespace HQRentalsPlugin\HQRentalsApi;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiEndpoint;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConfiguration;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiResponse as ApiResponse;


class HQRentalsApiConnector{

    /*
     * Constructor
     */
    public function __construct()
    {
        $this->endpoints = new HQRentalsApiEndpoint();
        $this->configuration = new HQRentalsApiConfiguration();
    }

    /*
     * Resolved Api Calls
     */
    public function resolveApiCallBrands($response)
    {
        if(is_wp_error($response)){
           return new ApiResponse($response->get_error_message(), false, null);
        }else{
            return new ApiResponse(null, true, json_decode($response['body'])->fleets_brands);
        }
    }
    public function resolveApiCallVehicleClasses($response)
    {
        if(is_wp_error($response)){
            return new ApiResponse($response->get_error_message(), false, null);
        }else{
            return new ApiResponse(null, true, json_decode($response['body'])->fleets_vehicle_classes);
        }
    }
    public function getHQRentalsBrands()
    {
        $response = wp_remote_get($this->endpoints->getBrandsApiEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolveApiCallBrands($response);
    }
    public function getHQRentalsVehicleClasses()
    {
        $response = wp_remote_get( $this->endpoints->getVehicleClassesApiEndpoint(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolveApiCallVehicleClasses( $response );
    }
}