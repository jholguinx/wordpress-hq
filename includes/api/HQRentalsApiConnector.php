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
    public function resolveApiCallLocations( $response )
    {
        if(is_wp_error($response)){
            return new ApiResponse($response->get_error_message(), false, null);
        }else{
            return new ApiResponse(null, true, json_decode($response['body'])->fleets_locations);
        }
    }
    public function resolveApiCallAdditionalCharges( $response )
    {
        if(is_wp_error($response)){
            return new ApiResponse($response->get_error_message(), false, null);
        }else{
            return new ApiResponse(null, true, json_decode($response['body'])->fleets_additional_charges);
        }
    }
    public function resolverApiCallSystemAssets( $response )
    {
        if(is_wp_error( $response )){
            return new ApiResponse( $response->get_error_message(), false, null );
        }else{
            return new ApiResponse( null, true, json_decode( $response['body'] ) );
        }
    }
    public function resolveApiCallForCustomFields( $response )
    {
        if(is_wp_error( $response )){
            return new ApiResponse( $response->get_error_message(), false, null );
        }else{
            return new ApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }
    public function resolveApiCallForWorkspotLocations( $response )
    {
        if(is_wp_error( $response )){
            return new ApiResponse( $response->get_error_message(), false, null );
        }else{
            return new ApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }
    public function resolveApiCallForWorkspotLocationDetail( $response )
    {
        if(is_wp_error( $response )){
            return new ApiResponse( $response->get_error_message(), false, null );
        }else{
            return new ApiResponse( null, true, json_decode( $response['body'] )->{'sheets-10'});
        }
    }
    public function resolveApiCallForGebouwLocation($response){
        if(is_wp_error( $response )){
            return new ApiResponse( $response->get_error_message(), false, null );
        }else{
            return new ApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }
    public function resolveApiCallForGebouwUnits($response){
        if(is_wp_error( $response )){
            return new ApiResponse( $response->get_error_message(), false, null );
        }else{
            return new ApiResponse( null, true, json_decode( $response['body'] )->data);
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
    public function getHQRentalsLocations()
    {
        $response = wp_remote_get($this->endpoints->getLocationsApiEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolveApiCallLocations( $response );
    }
    public function getHQRentalsAdditionalCharges()
    {
        $response = wp_remote_get( $this->endpoints->getAdditionalChargesEndpoint(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolveApiCallAdditionalCharges( $response );
    }
    public function getHQRentalsSystemAssets()
    {
        $response = wp_remote_get( $this->endpoints->getHQAssetsEndpoint(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolverApiCallSystemAssets( $response );
    }
    public function getHQVehicleClassCustomFields()
    {
        $response = wp_remote_get( $this->endpoints->getVehicleClassCustomFields(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolveApiCallForCustomFields( $response );
    }
    public function getWorkspotLocations()
    {
        $response = wp_remote_get( $this->endpoints->getWorkspotLocationsEndpoint(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolveApiCallForWorkspotLocations( $response );
    }
    public function getWorkspotLocationDetail($location)
    {
        $response = wp_remote_get( $this->endpoints->getWorkspotLocationDetailEndpoint($location), $this->configuration->getBasicApiConfiguration() );
        return $this->resolveApiCallForWorkspotLocationDetail( $response );
    }
    public function getWorkspotGebouwLocationDetail(){
        $response = wp_remote_get( $this->endpoints->getGebouwFloorDetailEndpoint(), $this->configuration->getBasicApiConfigurationForGebouwWorkspotLocation() );
        return $this->resolveApiCallForGebouwLocation( $response );
    }
    public function getWorkspotGebouwUnits(){
        $response = wp_remote_get( $this->endpoints->getGebouwUnitsEndpoint(), $this->configuration->getBasicApiConfigurationForGebouwWorkspotLocation() );
        return $this->resolveApiCallForGebouwUnits( $response );
    }
}