<?php

namespace HQRentalsPlugin\HQRentalsTransformers;

class HQRentalsTransformersSettings extends HQRentalsTransformersBase
{
    protected static $singleSettingsProperties = [
        'date_format',
        'tenant_link',
        'default_pick_up_time',
        'default_return_time'
    ];

    public static function transformDataFromApi($apiData)
    {
        //dd($apiData);
        return HQRentalsTransformersSettings::transformSettings($apiData);
    }

    public static function transformSettings($apiSettings)
    {
        return HQRentalsTransformersSettings::extractDataFromApiObject(HQRentalsTransformersSettings::$singleSettingsProperties, $apiSettings);
    }
}