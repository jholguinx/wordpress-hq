<?php

namespace HQRentalsPlugin\HQRentalsApi;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiEndpoint;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConfiguration;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiResponse as ApiResponse;


class HQRentalsApiConnector{
    public function __construct()
    {
        $this->endpoints = new HQRentalsApiEndpoint();
        $this->configuration = new HQRentalsApiConfiguration();
    }

    /*
     * Resolved Api Calls
     */
    public function resolveApiCall($response)
    {
        if(is_wp_error($response)){
           return new ApiResponse($response->get_error_message(), false, null);
        }else{

            return new ApiResponse(null, true, $response['body']);
        }
    }
    public function getHQRentalsBrands()
    {
        $response = wp_remote_get($this->endpoints->getBrandsApiEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolveApiCall($response);
    }
}