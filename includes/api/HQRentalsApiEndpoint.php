<?php
namespace HQRentalsPlugin\HQRentalsApi;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;

class HQRentalsApiEndpoint{
    private static $authURL = 'https://api.caagcrm.com/api/auth?check_other_regions=true';

    public function __construct()
    {
        $this->settings = new HQRentalsSettings();

    }

    public function getAvailabilityEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'car-rental/availability';
    }

    /*
     * Get Brand Api Endpoint
     */
    public function getBrandsApiEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'fleets/brands';
    }

    public function getVehicleClassesApiEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'fleets/vehicle-classes?only_available_on_website=1&minified_response=1';
    }

    public function getLocationsApiEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'fleets/locations';
    }
    public function getAdditionalChargesEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'fleets/additional-charges';
    }
    public function getHQAssetsEndpoint()
    {
        return 'https://api.caagcrm.com/api/assets/files';
    }
    public function getVehicleClassCustomFields()
    {
        return $this->settings->getApiBaseUrl() . 'fields/?item_type=fleets.vehicle_classes&limit=100';
    }
    public function getWorkspotLocationsEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'sheets/10/items?limit=100';
    }
    public function getWorkspotLocationDetailEndpoint( $location )
    {
        return $this->settings->getApiBaseUrl() . 'workspot/locations/' . $location->id;
    }
    public function getGebouwFloorDetailEndpoint(){
        return $this->settings->getApiBaseUrl() . 'sheets/37/items/?limit=100';
    }
    public function getGebouwUnitsEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'sheets/11/items/?limit=100';
    }
    public function getWorkspotRegionsEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'sheets/49/items/?limit=100';
    }
    public function getTenantsSettingsEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'tenants/current';
    }
    public function getGoogleAutocompleteEndpoint($input)
    {
        $args = array(
            'key'           =>  'AIzaSyAodJ3h4T6uXjUJZ0q8aLk9rEz21m_kWqE',
            'input'         =>  $input,
            'components'    =>  'country:gbr',
            'lang'          =>  'en'
        );
        return 'https://maps.googleapis.com/maps/api/place/autocomplete/json?' . http_build_query($args);
    }
    public function getGooglePlaceDetailsEndpoint($placeId)
    {
        $args = array(
            'key'           =>  'AIzaSyAodJ3h4T6uXjUJZ0q8aLk9rEz21m_kWqE',
            'place_id'         =>  $placeId,
        );
        return 'https://maps.googleapis.com/maps/api/place/details/json?' . http_build_query($args);
    }
    public function getWebsiteRegistrationEndpoint()
    {
        $args = array(
            'site'      =>  get_site_url(),
            'version'   => HQ_RENTALS_PLUGIN_VERSION
        );
        return $this->settings->getApiBaseUrl() . 'car-rental/websites/register?' . http_build_query($args);
    }
    public function getAuthEndpoint()
    {
        return HQRentalsApiEndpoint::$authURL;
    }
    public function getVehicleClassFormEndpoint()
    {
        $query = new HQRentalsQueriesVehicleClasses();
        $vehicles = $query->allVehicleClasses();
        $vehicle = $vehicles[0];
        // fleets/vehicle-classes/form -> replace
        return $this->settings->getApiBaseUrl() . 'fleets/vehicle-classes/'. $vehicle->id .'/form';
    }
    public function getAvailabilityDatesEndpoint()
    {
        return $this->settings->getApiBaseUrl() . 'car-rental/reservations/dates';
    }
}