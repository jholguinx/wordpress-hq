<?php

namespace HQRentalsPlugin\HQRentalsTransformers;

class HQRentalsTransformersSettings extends HQRentalsTransformersBase
{
    protected static $singleSettingsProperties = [
        'date_format'
    ];

    public static function transformDataFromApi($apiData)
    {
        return HQRentalsTransformersSettings::transformSettings($apiData);
    }

    public static function transformSettings($apiSettings)
    {
        return HQRentalsTransformersSettings::extractDataFromApiObject(HQRentalsTransformersSettings::$singleSettingsProperties, $apiSettings);
    }
}