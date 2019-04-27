<?php
namespace HQRentalsPlugin\HQRentalsApi;


class HQRentalsApiCallResolver{



    public function resolveApiCallAvailability($response)
    {
        if(is_wp_error($response)){
            return new HQRentalsApiResponse($response->get_error_message(), false, null);
        }else{
            return new HQRentalsApiResponse(null, true, json_decode($response['body']));
        }
    }
    public function resolveApiCallBrands($response)
    {
        if(is_wp_error($response)){
            return new HQRentalsApiResponse($response->get_error_message(), false, null);
        }else{
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->fleets_brands);
        }
    }
    public function resolveApiCallVehicleClasses($response)
    {
        if(is_wp_error($response)){
            return new HQRentalsApiResponse($response->get_error_message(), false, null);
        }else{
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->fleets_vehicle_classes);
        }
    }
    public function resolveApiCallLocations( $response )
    {
        if(is_wp_error($response)){
            return new HQRentalsApiResponse($response->get_error_message(), false, null);
        }else{
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->fleets_locations);
        }
    }
    public function resolveApiCallAdditionalCharges( $response )
    {
        if(is_wp_error($response)){
            return new HQRentalsApiResponse($response->get_error_message(), false, null);
        }else{
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->fleets_additional_charges);
        }
    }
    public function resolverApiCallSystemAssets( $response )
    {
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] ) );
        }
    }
    public function resolveApiCallForCustomFields( $response )
    {
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }
    public function resolveApiCallForWorkspotLocations( $response )
    {
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }
    public function resolveApiCallForWorkspotLocationDetail( $response )
    {
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->{'sheets-10'});
        }
    }
    public function resolveApiCallForGebouwLocation($response){
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }
    public function resolveApiCallForGebouwUnits($response){
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }
    
}