<?php
namespace HQRentalsPlugin\HQRentalsApi;


use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsApiCallResolver{

    public function __construct()
    {
        $this->settings = new HQRentalsSettings();
    }

    public function resolveErrorMessageFromResponse($wpResponse)
    {
        return $wpResponse['response']['code']." - ".$wpResponse['response']['message'];
    }

    /**
     * Resolve Availability Data from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallAvailability($response)
    {
        if(!isset(json_decode($response['body'])->success)){
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
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
        if($response['response']['code'] != 200){
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
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
        if(!isset(json_decode($response['body'])->success)){
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        }else{
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->data);
        }
    }

    /**
     * Resolve Locations Data from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallLocations( $response )
    {
        if($response['response']['code'] != 200){
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
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
        if($response['response']['code'] != 200){
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
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
        if(!isset(json_decode($response['body'])->success)){
            
            return new HQRentalsApiResponse( $this->resolveErrorMessageFromResponse($response), false, null );
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
        if(!isset(json_decode($response['body'])->success)){
            return new HQRentalsApiResponse( $this->resolveErrorMessageFromResponse($response), false, null );
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
        if(!isset(json_decode($response['body'])->success)){
            return new HQRentalsApiResponse( $this->resolveErrorMessageFromResponse($response), false, null );
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
        if(!isset(json_decode($response['body'])->success)){
            return new HQRentalsApiResponse( $this->resolveErrorMessageFromResponse($response), false, null );
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
        if(!isset(json_decode($response['body'])->success)){
            return new HQRentalsApiResponse( $this->resolveErrorMessageFromResponse($response), false, null );
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
        if(!isset(json_decode($response['body'])->success)){
            return new HQRentalsApiResponse( $this->resolveErrorMessageFromResponse($response), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }

    public function resolveApiCallTenantsSettings($response)
    {
        if(!isset(json_decode($response['body'])->success)){
            return new HQRentalsApiResponse( $this->resolveErrorMessageFromResponse($response), false, null );
        }else{
            return new HQRentalsApiResponse( null, true, json_decode( $response['body'] )->data);
        }
    }
    
}