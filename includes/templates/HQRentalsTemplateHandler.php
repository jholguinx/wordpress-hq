<?php

namespace HQRentalsPlugin\HQRentalsTemplates;

class HQRentalsTemplateHandler
{
    public function __construct()
    {
        //add_filter('template_include', array($this, 'addingTemplatesPage'),1);
        //add_filter('template_include', array($this, 'addingTemplatesQuote'),2);
        add_filter('template_include', array($this, 'addingTemplatesSingleGCar'),3);
        //add_filter('template_include', array($this, 'addingPageTemplates'),4);
    }
    public function addingTemplatesPage($defaultTemplate)
    {
        if (is_page('quotes')) {
            load_template(__DIR__ . '/page-quotes.php');
        }
    }
    public function addingTemplatesQuote($defaultTemplate)
    {
        if (is_page('payments')) {
            load_template(__DIR__ . '/page-payments.php');
        }
    }
    public function addingTemplatesSingleGCar($defaultTemplate)
    {
        global $post;
        // add theme route
        if($post->post_type === 'hqwp_veh_classes' and is_single()){
            $defaultTemplate = load_template(dirname( __FILE__ ) . '/gcar/single-hqwp_veh_classes.php');
            return $defaultTemplate;

        }
    }
    public function addingPageTemplates($defaultTemplate)
    {
        load_template(dirname( __FILE__ ) . '/gcar/page.php');
    }
}