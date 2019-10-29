<?php

namespace HQRentalsPlugin\HQRentalsTransformers;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

abstract class HQRentalsTransformersBase
{
    abstract public static function transformDataFromApi($data);

    public static function resolveSingleObject($apiObject)
    {

    }

    public static function resolveSingleAttribute($propertyValue, $default = null)
    {
        return !empty($propertyValue) ? ($propertyValue) : (!empty($default) ? $default : '');
    }

    public static function resolveArrayOfObjects($arrayApiData, $callback = null)
    {
        if (is_array($arrayApiData) and !empty($callback)) {
            return array_map(function($item) use ($callback){
                return call_user_func($callback, $item);
            }, $arrayApiData);
        } else {
            return [ ];
        }
    }

    public static function extractDataFromApiObject($properties, $apiObject, $nestedObject = null)
    {
        $objectToReturn = new \stdClass();
        $setting = new HQRentalsSettings();
        foreach ($properties as $property) {
            if (empty($nestedObject)) {
                $objectToReturn->{$property} = HQRentalsTransformersBase::resolveSingleAttribute($apiObject->{$property});
            }
        }
        $coordinate = $setting->getLocationCoordinateField();
        if(!empty($coordinate)){
            $objectToReturn->coordinates = HQRentalsTransformersBase::resolveSingleAttribute($apiObject->{$coordinate});
        }
        $image = $setting->getLocationImageField();
        if(!empty($image)){
            $objectToReturn->image = HQRentalsTransformersBase::resolveSingleAttribute($apiObject->{$image});
        }
        $description = $setting->getLocationDescriptionField();
        if(!empty($description)){
            $objectToReturn->description = HQRentalsTransformersBase::resolveSingleAttribute($apiObject->{$description});
        }
        return $objectToReturn;
    }
}