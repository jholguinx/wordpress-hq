<?php

namespace HQRentalsPlugin\HQRentalsModels;

abstract class HQRentalsBaseModel
{
    abstract protected function create();
    abstract protected function find( $caag_id  );
    abstract protected function all();
}