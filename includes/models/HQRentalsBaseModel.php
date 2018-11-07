<?php

namespace HQRentalsPlugin\HQRentalsModels;

abstract class HQRentalsBaseModel
{
    abstract protected function create();
    abstract protected function save();
    abstract protected function update();
    abstract protected function delete();
    abstract protected function find( $caag_id  );
    abstract protected function first();
    abstract protected function all();

}