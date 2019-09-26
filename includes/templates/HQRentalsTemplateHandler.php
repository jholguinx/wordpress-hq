<?php

namespace HQRentalsPlugin\HQRentalsTemplates;

class HQRentalsTemplateHandler{
    public function __construct()
    {
        add_filter( 'template_include', array( $this, 'addingTemplates') );
    }
    public function addingTemplates($defaultTemplate)
    {
        if( is_page('quote') ){
            load_template( __DIR__ . '/page-quote.php' );
        }
    }
}