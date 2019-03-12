<?php

namespace HQRentalsPlugin\HQRentalsWorkspot;

class HQRentalsWorkspotBootstrap
{
    public function __construct()
    {
        add_action( 'init', array( $this, 'lightsOn' ) );
    }
    public function lightsOn()
    {

    }
}