<?php

namespace HQRentalsPlugin\HQRentalsTemplates;

class HQRentalsTemplateHandler
{
    public function __construct()
    {
        add_filter('template_include', array($this, 'addingTemplates'));
    }

    public function addingTemplates($defaultTemplate)
    {
        global $post;
        if (is_page('quotes')) {
            load_template(__DIR__ . '/page-quotes.php');
        }
        if (is_page('payments')) {
            load_template(__DIR__ . '/page-payments.php');
        }
        if($post->post_type === 'hqwp_veh_classes' and is_single()){
            load_template(dirname( __FILE__ ) . '/gcar/single-hqwp_veh_classes.php');
        }
        return $defaultTemplate;
    }
}