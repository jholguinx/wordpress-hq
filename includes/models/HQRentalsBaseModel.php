<?php

namespace HQRentalsPlugin\HQRentalsModels;

abstract class HQRentalsBaseModel
{
    abstract protected function create();
    abstract protected function all();
    public function getUpdatedAt() : string
    {
        try {
            $date = $this->updated_at;
            return $date;
        }catch (\Exception $e){
            return 'N/A';
        }

    }
}