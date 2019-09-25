<?php

namespace HQRentalsPlugin\HQRentalsApi;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiEndpoint;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConfiguration;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiResponse as ApiResponse;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;


class HQRentalsApiConnector{

    /*
     * Constructor
     */
    public function __construct()
    {
        $this->endpoints = new HQRentalsApiEndpoint();
        $this->configuration = new HQRentalsApiConfiguration();
        $this->resolver = new HQRentalsApiCallResolver();
        $this->settings = new HQRentalsSettings();
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
        $response = wp_remote_get( $this->endpoints->getVehicleClassesApiEndpoint(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolver->resolveApiCallVehicleClasses( $response );
    }
    public function getHQRentalsLocations()
    {
        $response = wp_remote_get($this->endpoints->getLocationsApiEndpoint(), $this->configuration->getBasicApiConfiguration());
        return $this->resolver->resolveApiCallLocations( $response );
    }
    public function getHQRentalsAdditionalCharges()
    {
        $response = wp_remote_get( $this->endpoints->getAdditionalChargesEndpoint(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolver->resolveApiCallAdditionalCharges( $response );
    }
    public function getHQRentalsSystemAssets()
    {
        $response = wp_remote_get( $this->endpoints->getHQAssetsEndpoint(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolver->resolverApiCallSystemAssets( $response );
    }
    public function getHQVehicleClassCustomFields()
    {
        $response = wp_remote_get( $this->endpoints->getVehicleClassCustomFields(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolver->resolveApiCallForCustomFields( $response );
    }
    public function getWorkspotLocations()
    {
        $response = wp_remote_get( $this->endpoints->getWorkspotLocationsEndpoint(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolver->resolveApiCallForWorkspotLocations( $response );
    }
    public function getWorkspotLocationDetail($location)
    {
        $response = wp_remote_get( $this->endpoints->getWorkspotLocationDetailEndpoint($location), $this->configuration->getBasicApiConfiguration() );
        return $this->resolver->resolveApiCallForWorkspotLocationDetail( $response );
    }
    public function getWorkspotGebouwLocationDetail()
    {
        $response = wp_remote_get( $this->endpoints->getGebouwFloorDetailEndpoint(), $this->configuration->getBasicApiConfigurationForGebouwWorkspotLocation() );
        return $this->resolver->resolveApiCallForGebouwLocation( $response );
    }
    public function getWorkspotGebouwUnits()
    {
        $response = wp_remote_get( $this->endpoints->getGebouwUnitsEndpoint(), $this->configuration->getBasicApiConfigurationForGebouwWorkspotLocation() );
        return $this->resolver->resolveApiCallForGebouwUnits( $response );
    }
    public function getWorkspotRegions()
    {
        $response = wp_remote_get( $this->endpoints->getWorkspotRegionsEndpoint(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolver->resolveApiCallForGebouwLocation( $response );
    }
    public function getHQRentalsTenantsSettings()
    {
        $response = wp_remote_get( $this->endpoints->getTenantsSettingsEndpoint(), $this->configuration->getBasicApiConfiguration() );
        return $this->resolver->resolveApiCallTenantsSettings( $response );
    }


}