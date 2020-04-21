<?php

namespace HQRentalsPlugin\HQRentalsTasks;

use HQRentalsPlugin\HQRentalsModels\HQRentalsModelsBrand as HQBrand;
use HQRentalsPlugin\HQRentalsApi\HQRentalsApiConnector as Connector;

class HQRentalsBrandsTask extends HQRentalsBaseTask
{
    public function __construct()
    {
        $this->connector = new Connector();
    }
    public function tryToRefreshSettingsData()
    {
        $this->response = $this->connector->getHQRentalsBrands();
    }
    public function setDataOnWP()
    {
        if ( $this->response->success and !empty($this->response->data)) {
            foreach ( $this->response->data as $brand ) {
                $newBrand = new HQBrand();
                $newBrand->setBrandFromApi( $brand );
                $newBrand->create();
            }
        }
    }
    public function dataWasRetrieved()
    {
        return $this->response->success;
    }
}
