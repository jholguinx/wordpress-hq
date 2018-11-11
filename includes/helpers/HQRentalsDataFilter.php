<?php
namespace HQRentalsPlugin\HQRentalsHelpers;

class HQRentalsDataFilter
{
    /*
     * Check is Data its a Wordpress Post
     */
    public function isPost($data)
    {
        return gettype($data) == 'object' and $this->getClassName($data) == 'WP_Post';
    }

    /*
     * Check if its an id
     */
    public function isId($data)
    {
        return gettype($data) == 'integer' or gettype($data) == 'string';
    }

    /*
     * Retrieve Class Name
     */
    public function getClassName($object)
    {
        return get_class($object);
    }
}