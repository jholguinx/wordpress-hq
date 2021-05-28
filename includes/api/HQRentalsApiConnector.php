<?php

namespace HQRentalsPlugin\HQRentalsApi;

use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;


class HQRentalsApiConnector
{

    /*
     * Constructor
     */
    public function __construct()
    {
        $this->endpoints = new HQRentalsApiEndpoint();
        $this->configuration = new HQRentalsApiConfiguration();
        $this->resolver = new HQRentalsApiCallResolver();
    }

    public function getHQRentalsAvailability($data)
    {
        $response = wp_remote_get($this->endpoints->getAvailabilityEndpoint(), $this->configuration->getBasicApiConfiguration($data));
        return $this->resolver->resolveApiCallAvailability($response);
    }

    public function getHQRentalsBrands()
    {
        $response = wp_remote_get($this->endpoints->getBrandsApiEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolver->resolveApiCallBrands($response);
    }

    public function getHQRentalsVehicleClasses()
    {
        $response = wp_remote_get($this->endpoints->getVehicleClassesApiEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolver->resolveApiCallVehicleClasses($response);
    }

    public function getHQRentalsLocations()
    {
        $filter = array(
            'filters' => json_encode(
                array(
                    array(
                        'type'  => 'boolean',
                        'column' => 'show_on_website',
                        'operator' => 'equals',
                        'value' => true
                    )
                )
            )
        );
        $response = wp_remote_get($this->endpoints->getLocationsApiEndpoint(), $this->configuration->getBasicApiConfiguration($filter));
        return $this->resolver->resolveApiCallLocations($response);
    }

    public function getHQRentalsVehicleTypes()
    {
        $response = wp_remote_get($this->endpoints->getVehicleTypesEndpoint(), $this->configuration->getBasicApiConfiguration());

        return json_decode($response['body'])->fleets_vehicle_types;
    }

    public function getHQRentalsAdditionalCharges()
    {
        $response = wp_remote_get($this->endpoints->getAdditionalChargesEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolver->resolveApiCallAdditionalCharges($response);
    }

    public function getHQRentalsSystemAssets()
    {
        $response = wp_remote_get($this->endpoints->getHQAssetsEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolver->resolverApiCallSystemAssets($response);
    }

    public function getHQVehicleClassCustomFields()
    {
        $response = wp_remote_get($this->endpoints->getVehicleClassCustomFields(), $this->configuration->getBasicApiConfiguration());
        return $this->resolver->resolveApiCallForCustomFields($response);
    }

    public function getWorkspotLocations()
    {
        $response = wp_remote_get($this->endpoints->getWorkspotLocationsEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolver->resolveApiCallForWorkspotLocations($response);
    }

    public function getWorkspotLocationDetail($location)
    {
        $response = wp_remote_get($this->endpoints->getWorkspotLocationDetailEndpoint($location), $this->configuration->getBasicApiConfiguration());
        return $this->resolver->resolveApiCallForWorkspotLocationDetail($response);
    }

    public function getWorkspotGebouwLocationDetail()
    {
        $response = wp_remote_get($this->endpoints->getGebouwFloorDetailEndpoint(), $this->configuration->getBasicApiConfigurationForGebouwWorkspotLocation());
        return $this->resolver->resolveApiCallForGebouwLocation($response);
    }

    public function getWorkspotGebouwUnits()
    {
        $response = wp_remote_get($this->endpoints->getGebouwUnitsEndpoint(), $this->configuration->getBasicApiConfigurationForGebouwWorkspotLocation());
        return $this->resolver->resolveApiCallForGebouwUnits($response);
    }

    public function getWorkspotRegions()
    {
        $response = wp_remote_get($this->endpoints->getWorkspotRegionsEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolver->resolveApiCallForGebouwLocation($response);
    }

    public function getHQRentalsTenantsSettings()
    {
        $response = wp_remote_get($this->endpoints->getTenantsSettingsEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolver->resolveApiCallTenantsSettings($response);
    }

    public function getGooglePlacesOnAutocomplete($input)
    {
        $response = wp_remote_get($this->endpoints->getGoogleAutocompleteEndpoint($input));
        return $this->resolver->resolveGoogleAutocomplete($response);
    }

    public function getGooglePlaceDetailsData($placeId)
    {
        $response = wp_remote_get($this->endpoints->getGooglePlaceDetailsEndpoint($placeId));
        return $this->resolver->resolveGooglePlaceDetails($response);
    }

    public function notifyOnActivation()
    {
        $response = wp_remote_post($this->endpoints->getWebsiteRegistrationEndpoint());
        return $this->resolver->resolveActivation($response);
    }

    public function login($email, $password)
    {
        $data = array(
            'email' => $email,
            'password' => $password,
        );
        $response = wp_remote_post($this->endpoints->getAuthEndpoint(), $this->configuration->authApiConfiguration($data));
        $cleanResponse = $this->resolver->resolveApiCallForAuth($response);
        if ($cleanResponse->success) {
            $settings = new HQRentalsSettings();
            $settings->updateEmail($email);
            $settings->resolveSettingsOnAuth($cleanResponse);
        }
        return $cleanResponse;
    }

    public function getVehicleClassesForm()
    {
        $response = wp_remote_get($this->endpoints->getVehicleClassFormEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolver->resolveVehicleForm($response);
    }

    public function getVehiclesAvailabilityDates($data)
    {
        $response = wp_remote_post($this->endpoints->getAvailabilityDatesEndpoint(), $this->configuration->getBasicApiConfiguration($data));
        return $this->resolver->resolveVehicleForm($response);
    }
}
