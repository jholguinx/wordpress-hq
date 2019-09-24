<?php

namespace HQRentalsPlugin\HQRentalsTransformers;

abstract class HQRentalsTransformersBase
{
    abstract public static function transformDataFromApi($data);

    public static function resolveSingleObject($apiObject){

    }
    public static function resolveSingleAttribute($propertyValue, $default = null)
    {
        return empty($propertyValue) ? ($propertyValue) : (empty($default) ? $default : '');
    }
    public static function resolveArrayOfObjects($arrayApiData, $callback = null)
    {
        if( is_array($arrayApiData) ){
            return array_map(function($singleApiObject) use ($callback) {
                if(!empty($callback)){
                    return call_user_func($callback, $singleApiObject);
                } else {
                    return $singleApiObject;
                }
            }, $arrayApiData);
        }else{
            return [];
        }
    }
}