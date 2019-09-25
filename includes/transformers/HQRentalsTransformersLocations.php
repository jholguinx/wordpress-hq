<?php

namespace HQRentalsPlugin\HQRentalsTransformers;

class HQRentalsTransformersLocations extends HQRentalsTransformersBase
{
    protected static $singleBrandProperties = [
        'id',
        'name',
        'brand_id',
        'name',
        'is_airport',
        'is_office',
        'coordinates',
        'active',
        'order'
    ];
    
    public static function transformDataFromApi($apiData)
    {
        return HQRentalsTransformersLocations::resolveArrayOfObjects($apiData, function($apiSingleLocation) {
           return HQRentalsTransformersLocations::transformSingleLocation($apiSingleLocation);
        });
    }
    public static function transformSingleLocation($location)
    {
        return HQRentalsTransformersLocations::extractDataFromApiObject(HQRentalsTransformersLocations::$singleBrandProperties, $location);
    }
}