<?php

namespace HQRentalsPlugin\HQRentalsCustomPosts;

class HQRentalsCustomPostsHandler
{
    public function __construct()
    {
        add_action( 'init', array( $this, 'registerAllHQRentalsCustomPosts' ));
    }
    public function registerAllHQRentalsCustomPosts(){

    }
}