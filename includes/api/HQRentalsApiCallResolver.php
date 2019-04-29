<?php
namespace HQRentalsPlugin\HQRentalsApi;


class HQRentalsApiCallResolver{


    /**
     * Resolve Availability Data from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallAvailability($response)
    {
        if(is_wp_error($response)){
            return new HQRentalsApiResponse($response->get_error_message(), false, null);
        }else{
            return new HQRentalsApiResponse(null, true, json_decode($response['body']));
        }
    }

    /**
     * Resolve Brands Data from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallBrands($response)
    {
        if(is_wp_error($response)){
            return new HQRentalsApiResponse($response->get_error_message(), false, null);
        }else{
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->fleets_brands);
        }
    }

    /**
     * Resolve Vehicle Classes Data from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallVehicleClasses($response)
    {
        if(is_wp_error($response)){
            return new HQRentalsApiResponse($response->get_error_message(), false, null);
        }else{
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->fleets_vehicle_classes);
        }
    }

    /**
     * Resolve Locations Data from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallLocations( $response )
    {
        if(is_wp_error($response)){
            return new HQRentalsApiResponse($response->get_error_message(), false, null);
        }else{
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->fleets_locations);
        }
    }

    /**
     * Resolve Additional Charges from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallAdditionalCharges( $response )
    {
        if(is_wp_error($response)){
            return new HQRentalsApiResponse($response->get_error_message(), false, null);
        }else{
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->fleets_additional_charges);
        }
    }

    /**
     * Resolve Assets Data from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolverApiCallSystemAssets( $response )
    {
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] ) );
        }
    }

    /**
     * Resolve Customs Field Data from Vehicle Classes from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallForCustomFields( $response )
    {
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }

    /**
     * Resolve Locations Data from Workspot API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallForWorkspotLocations( $response )
    {
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }

    /**
     * Resolve Locations Details from Workspot API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallForWorkspotLocationDetail( $response )
    {
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->{'sheets-10'});
        }
    }

    /**
     * Resolve Gebouw Location Data from Workspot API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallForGebouwLocation($response){
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }

    /**
     * Resolve Gebouw Location Units from Workspot API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallForGebouwUnits($response){
        if(is_wp_error( $response )){
            return new HQRentalsApiResponse( $response->get_error_message(), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }
    
}