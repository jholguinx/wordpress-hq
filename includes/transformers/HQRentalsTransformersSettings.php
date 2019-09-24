<?php

namespace HQRentalsPlugin\HQRentalsTransformers;

class HQRentalsTransformersSettings extends HQRentalsTransformersBase
{
    public static function transformDataFromApi($apiData)
    {
        $dataToReturn = new \stdClass();
        $dataToReturn->date_format = HQRentalsTransformersSettings::resolveSingleAttribute($apiData->date_format);
        return $dataToReturn;
    }
    pub
}