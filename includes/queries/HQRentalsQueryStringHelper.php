<?php

namespace HQRentalsPlugin\HQRentalsQueries;

use HQRentalsPlugin\HQRentalsQueries\HQRentalsQueriesVehicleClasses;


class HQRentalsQueryStringHelper
{
    public function __construct()
    {
        $this->queryVehicles = new HQRentalsQueriesVehicleClasses();
    }

    public function getVehicleClassesQueryString($dbColumn, $vehicleClassFilterValue)
    {
        if (empty($dbColumn) or empty($vehicleClassFilterValue)) {
            return '';
        } else {
            $query_string_passenger = '&vehicle_classes_filter=';
            $counter = 0;
            $vehicleClassesIds = $this->queryVehicles->getVehiclesIdsFromCustomField($dbColumn, $vehicleClassFilterValue);
            foreach ($vehicleClassesIds as $id) {
                $counter = $counter + 1;
                if ($counter == count($vehicleClassesIds)) {
                    $query_string_passenger .= $id;
                } else {
                    $query_string_passenger .= $id . ',';
                }
            }
            return $query_string_passenger;
        }
    }
}