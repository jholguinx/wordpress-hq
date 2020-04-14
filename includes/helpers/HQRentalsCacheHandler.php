<?php

namespace HQRentalsPlugin\HQRentalsHelpers;
require_once ABSPATH . 'wp-includes/class-wp-object-cache.php';

use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;

class HQRentalsCacheHandler extends \WP_Object_Cache
{
    private static $vehiclesQueryKey = 'hq_vehicles_classes_cache';
    private static $cacheExpiration = 1 * 3600;
    private static $cacheGroup = 'hq_rentals_plugins_group';


    public function __construct()
    {
        parent::__construct();
        $this->vehiclesQuery = new HQRentalsQueriesVehicleClasses();
    }

    public function addDataToCache($key, $data)
    {
        $this->add($key, $data, HQRentalsCacheHandler::$cacheGroup, HQRentalsCacheHandler::$cacheExpiration);
    }
    public function addVehiclesClassesToCache()
    {
        $this->addDataToCache(HQRentalsCacheHandler::$vehiclesQueryKey, $this->vehiclesQuery->allVehicleClasses());
    }
    public function existsKeyOnCache($key)
    {
        return $this->_exists($key, HQRentalsCacheHandler::$cacheGroup);
    }
    public function existsVehicleClassOnCache()
    {
        return $this->existsKeyOnCache(HQRentalsCacheHandler::$vehiclesQueryKey);
    }
    public function getDataFromCache($key)
    {
        return $this->get($key, HQRentalsCacheHandler::$cacheGroup);
    }
    public function getVehicleClassesFromCache()
    {
        return $this->getDataFromCache(HQRentalsCacheHandler::$vehiclesQueryKey);
    }
}