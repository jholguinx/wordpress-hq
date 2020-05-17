<?php

namespace HQRentalsPlugin\HQRentalsWebhooks;

use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesBrands;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesFeatures;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesLocations;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector;
use Unirest\Exception;

class HQRentalsWebsiteEndpoints
{

    public function __construct()
    {
        $this->featuresQuery = new HQRentalsQueriesFeatures();
        $this->vehicleClassQuery = new HQRentalsQueriesVehicleClasses();
        $this->brandQuery = new HQRentalsQueriesBrands();
        add_action('rest_api_init', array($this, 'setEndpoints'));
    }

    public function setEndpoints()
    {
        //baseURl/wp-json/hqrentals/brands/
        register_rest_route('hqrentals', '/brands/', array(
            'methods' => 'GET',
            'callback' => array($this, 'brands'),
        ));
        register_rest_route('hqrentals', '/brand/', array(
            'methods' => 'GET',
            'callback' => array($this, 'brand'),
        ));
        register_rest_route('hqrentals', '/shortcodes/bookingform', array(
            'methods' => 'GET',
            'callback' => array($this, 'bookingform'),
        ));
        register_rest_route('hqrentals', '/shortcodes/vehicle-types', array(
            'methods' => 'GET',
            'callback' => array($this, 'vehicleTypes'),
        ));
        register_rest_route('hqrentals', '/google/autocomplete', array(
            'methods' => 'GET',
            'callback' => array($this, 'googleAutocomplete'),
        ));
        register_rest_route('hqrentals', '/google/place', array(
            'methods' => 'GET',
            'callback' => array($this, 'googlePlace'),
        ));
        register_rest_route('hqrentals', '/shortcodes/availability', array(
            'methods' => 'GET',
            'callback' => array($this, 'availability'),
        ));
    }

    public function brand()
    {
        $id = $_GET['id'];
        try {
            if (empty($id)) {
                return $this->resolveResponse("Brand id Empty", false);
            } else {
                $query = new HQRentalsQueriesBrands();
                return $this->resolveResponse($query->singleBrandPublicInterface($id), true);
            }
        } catch (Exception $e) {
            return $this->resolveResponse($e, false);
        }

    }

    public function brands()
    {
        try {
            $query = new HQRentalsQueriesBrands();
            $brands = $query->brandsPublicInterface();
            return $this->resolveResponse($brands, true);
        } catch (Exception $e) {
            return $this->resolveResponse($e, false);
        }

    }

    public function resolveResponse($data, $status)
    {
        if (!empty($data) and $status) {
            $response = new \WP_REST_Response($this->resolveResponseData($data), true);
            $response->status = 200;
            return $response;
        } else {
            $response = new \WP_REST_Response($this->resolveResponseData([]), false);
            $response->status = 404;
            return $response;
        }
    }

    public function resolveResponseData($data, $success = true)
    {
        return array(
            'success' => !empty($success),
            'data' => $data
        );
    }

    public function bookingform()
    {
        try {
            $query = new HQRentalsQueriesBrands();
            $queryLocation = new HQRentalsQueriesLocations();
            $brands = $query->brandsPublicInterface();
            $locations = $queryLocation->locationsPublicInterface();
            $responseData = new \stdClass();
            $responseData->locations = $locations;
            $responseData->brands = $brands;
            return $this->resolveResponse($responseData, true);
        } catch (Exception $e) {
            return $this->resolveResponse($e, false);
        }
    }

    public function vehicleTypes()
    {
        $brandID = $_GET['brand_id'];
        $customField = $_GET['custom_field'];
        $customFieldValue = $_GET['custom_field_value'];
        try {
            //fix later - no two querys
            $query = new HQRentalsQueriesVehicleClasses();
            $vehicles = $query->getVehicleClassesByBrand($brandID);
            $vehiclesForResponse = empty($customFieldValue) ? $query->vehiclesPublicInterface($brandID) : $query->vehiclesPublicInterfaceFiltered($brandID, $customField, $customFieldValue);
            $types = array();
            foreach ($vehicles as $vehicle) {
                $type = $vehicle->getCustomField($customField);
                if (!in_array($type, $types)) {
                    $types[] = $type;
                }
            }
            $data = array(
                'vehicles' => $vehiclesForResponse,
                'types' => $types
            );
            return $this->resolveResponse($data, true);
        } catch (Exception $e) {
            return $this->resolveResponse($e, false);
        }
    }

    public function googleAutocomplete()
    {
        try {
            //fix later - no two querys
            $input = $_GET['input'];
            $connector = new HQRentalsApiConnector();
            $data = $connector->getGooglePlacesOnAutocomplete($input);
            $data = array(
                'predictions' => $data->data
            );
            return $this->resolveResponse($data, true);
        } catch (Exception $e) {
            return $this->resolveResponse($e, false);
        }
    }

    public function googlePlace()
    {
        try {
            $placeId = $_GET['place_id'];
            $connector = new HQRentalsApiConnector();
            $data = $connector->getGooglePlaceDetailsData($placeId);
            $data = array(
                'place' => $data->data
            );
            return $this->resolveResponse($data, true);
        } catch (Exception $e) {
            return $this->resolveResponse($e, false);
        }
    }

    public function availability()
    {
        try {
            $connector = new HQRentalsApiConnector();
            $response = $connector->getHQRentalsAvailability(HQRentalsApiClientAdapter::adaptDataForAvailability($_GET));
            if ($response->success) {
                foreach ($response->data as $availableVehicle) {
                    $availableVehicle->vehicle_class = (object)array_merge(
                        (array)$availableVehicle->vehicle_class,
                        ['features' => $this->featuresQuery->featuresPublicInterfaceWithLocale($this->featuresQuery->getVehicleClassFeatures($availableVehicle->vehicle_class->id))],
                        ['rate' => $this->vehicleClassQuery->getVehicleClassBySystemId($availableVehicle->vehicle_class->id)->rate()->getDailyRateObject()],
                        ['brand' => $this->brandQuery->singleBrandPublicInterface($availableVehicle->vehicle_class->brand_id)]
                    );
                }
            }
            return $response;
        } catch (Exception $e) {
            return $this->resolveResponse($e, false);
        }

    }
}