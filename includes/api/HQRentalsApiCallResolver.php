<?php

namespace HQRentalsPlugin\HQRentalsApi;


use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;
use HQRentalsPlugin\HQRentalsTransformers\HQRentalsTransformersBrands;
use HQRentalsPlugin\HQRentalsTransformers\HQRentalsTransformersCarRentalSettings;
use HQRentalsPlugin\HQRentalsTransformers\HQRentalsTransformersGoogle;
use HQRentalsPlugin\HQRentalsTransformers\HQRentalsTransformersLocations;
use HQRentalsPlugin\HQRentalsTransformers\HQRentalsTransformersSettings;

class HQRentalsApiCallResolver
{

    public function __construct()
    {
        $this->settings = new HQRentalsSettings();
    }

    public function resolveErrorMessageFromResponse($wpResponse)
    {
        if (is_wp_error($wpResponse)) {
            return $wpResponse->get_error_message();
        } else {
            $errorResponse = json_decode($wpResponse['body']);
            return $errorResponse->errors->error_message;
        }
    }

    public function isErrorOnApiInteraction($responseWP)
    {
        if (is_wp_error($responseWP)) {
            return true;
        }
        $responseData = json_decode($responseWP['body']);
        if (isset($responseData->errors) and $responseData->errors) {
            return true;
        }
        return false;
    }

    /*
     * Refactor this class using this instead
     * */
    public function resolveApiCall($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body']));
        }
    }

    /**
     * Resolve Availability Data from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallAvailability($response)
    {
        if ($this->isErrorOnApiInteraction($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
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
        if ($this->isErrorOnApiInteraction($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, HQRentalsTransformersBrands::transformDataFromApi(json_decode($response['body'])->fleets_brands));
        }
    }

    /**
     * Resolve Vehicle Classes Data from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallVehicleClasses($response)
    {
        if ($this->isErrorOnApiInteraction($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->data);
        }
    }

    /**
     * Resolve Locations Data from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallLocations($response)
    {
        if ($this->isErrorOnApiInteraction($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            $parseData = json_decode($response['body']);
            if(isset($parseData->fleets_locations)){
                return new HQRentalsApiResponse(null, true, HQRentalsTransformersLocations::transformDataFromApi($parseData->fleets_locations));
            }
            return new HQRentalsApiResponse(null, true, HQRentalsTransformersLocations::transformDataFromApi([]));
        }
    }

    /**
     * Resolve Additional Charges from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallAdditionalCharges($response)
    {
        if ($this->isErrorOnApiInteraction($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->fleets_additional_charges);
        }
    }

    public function resolveVehicleTypes($response)
    {
        if ($this->isErrorOnApiInteraction($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->fleets_vehicle_types);
        }
    }

    /**
     * Resolve Assets Data from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolverApiCallSystemAssets($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body']));
        }
    }

    /**
     * Resolve Customs Field Data from Vehicle Classes from API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallForCustomFields($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->data);
        }
    }

    public function resolveVehicleForm($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->data);
        }
    }

    /**
     * Resolve Locations Data from Workspot API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallForWorkspotLocations($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->data);
        }
    }

    /**
     * Resolve Locations Details from Workspot API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallForWorkspotLocationDetail($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->{'sheets-10'});
        }
    }

    /**
     * Resolve Gebouw Location Data from Workspot API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallForGebouwLocation($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->data);
        }
    }

    /**
     * Resolve Gebouw Location Units from Workspot API
     * @param $response
     * @return HQRentalsApiResponse
     */
    public function resolveApiCallForGebouwUnits($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body'])->data);
        }
    }

    public function resolveApiCallTenantsSettings($response)
    {
        if ($this->isErrorOnApiInteraction($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, HQRentalsTransformersSettings::transformDataFromApi(json_decode($response['body'])->data));
        }
    }
    public function resolveApiCallCarRentalSettings($response)
    {
        if ($this->isErrorOnApiInteraction($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, HQRentalsTransformersCarRentalSettings::transformDataFromApi(json_decode($response['body'])->data));
        }
    }

    public function resolveGoogleAutocomplete($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, HQRentalsTransformersGoogle::transformGoogleAutocompleteData(json_decode($response['body'])));
        }
    }

    public function resolveGooglePlaceDetails($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, HQRentalsTransformersGoogle::transformGooglePlaceData(json_decode($response['body'])));
        }
    }

    public function resolveActivation($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body']));
        }
    }

    public function resolveApiCallForAuth($response)
    {
        if (is_wp_error($response)) {
            return new HQRentalsApiResponse($this->resolveErrorMessageFromResponse($response), false, null);
        } else {
            return new HQRentalsApiResponse(null, true, json_decode($response['body']));
        }
    }
}