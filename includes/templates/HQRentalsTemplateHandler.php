<?php

namespace HQRentalsPlugin\HQRentalsTemplates;

class HQRentalsTemplateHandler{
    public function __construct()
    {
        add_filter( 'template_include', array($this, 'addingTemplates') );
    }
    public function addingTemplates($template)
    {
        if( is_page('quote') ){
            return 'page-quote.php';
        }
    }

}