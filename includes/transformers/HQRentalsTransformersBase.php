<?php

namespace HQRentalsPlugin\HQRentalsTransformers;

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
        foreach ($properties as $property) {
            if (empty($nestedObject)) {
                $objectToReturn->{$property} = HQRentalsTransformersBase::resolveSingleAttribute($apiObject->{$property});
            }
        }
        return $objectToReturn;
    }
}