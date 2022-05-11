<?php

namespace HQRentalsPlugin\HQRentalsTransformers;

class HQRentalsTransformersCarRentalSettings extends HQRentalsTransformersBase
{
    protected static $singleSettingsProperties = [
        'car_rental_default_pick_up_time',
        'car_rental_default_return_time',
        'car_rental_default_currency'

    ];

    public static function transformDataFromApi($apiData)
    {
        return HQRentalsTransformersCarRentalSettings::transformSettings($apiData);
    }

    public static function transformSettings($apiSettings)
    {
        return (array)HQRentalsTransformersCarRentalSettings::extractDataFromApiObject(HQRentalsTransformersCarRentalSettings::$singleSettingsProperties, $apiSettings);
    }
}