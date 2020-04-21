<?php

namespace HQRentalsPlugin\HQRentalsTasks;


abstract class HQRentalsBaseTask{
    protected $response;

    /*Get data from api and set response*/
    public abstract function tryToRefreshSettingsData();

    /*Validate that the response have no errors*/
    public abstract function dataWasRetrieved();

    /*Populate WP Database*/
    public abstract function setDataOnWP();


}