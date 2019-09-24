<?php

namespace HQRentalsPlugin\HQRentalsTransformers;

class HQRentalsTransformersBrands extends HQRentalsTransformersBase
{
    protected static $singleBrandProperties = [
        'id',
        'name',
        'website_link',
        'public_reservations_link_full',
        'public_packages_link_full',
        'public_reservations_first_step_link',
        'public_packages_first_step_link',
        'public_reservation_packages_first_step_link',
        'my_reservation_link',
        'my_packages_reservation_link',
        'public_calendar_link'
    ];
    public static function transformDataFromApi($apiData)
    {
        return HQRentalsTransformersBrands::resolveArrayOfObjects($apiData, HQRentalsTransformersBrands::transformSingleBrand($data));
    }
    public static function transformSingleBrand($apiBrand)
    {
        $object = new \stdClass();
        foreach (HQRentalsTransformersBrands::$singleBrandProperties as $property) {
            return $object{$property} = HQRentalsTransformersBrands::resolveSingleAttribute($property);
        }
        return $object;
    }
}