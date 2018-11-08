<?php

namespace HQRentalsPlugin\HQRentalsQueries;



abstract class HQRentalsQueries
{
    abstract protected function all();
    abstract protected function find();
    abstract protected function findByHQId();
    abstract protected function findByPostId();
}