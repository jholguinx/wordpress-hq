<?php

namespace HQRentalsPlugin\HQRentalsHelpers;

class HQRentalsLocaleHelper
{
    public function __construct()
    {
        $this->locale = get_locale();
        $this->language = explode('_', $this->locale)[0];
        $this->country = explode('_', $this->locale)[1];
    }
}