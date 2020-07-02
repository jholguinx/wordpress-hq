<?php

namespace HQRentalsPlugin\HQRentalsTemplates;

class HQRentalsTemplateHandler
{
    public function __construct()
    {
        add_filter('template_include', array($this, 'addingTemplates'),3);
    }

    public function addingTemplates($defaultTemplate)
    {
        global $post;
        // add theme route
        if($post->post_type === 'hqwp_veh_classes' and is_single()){
            $defaultTemplate = load_template(dirname( __FILE__ ) . '/gcar/single-hqwp_veh_classes.php');

        }else if (is_page('quotes')) {
            load_template(__DIR__ . '/page-quotes.php');
        }else if (is_page('payments')) {
            load_template(__DIR__ . '/page-payments.php');
        }else{
            return $defaultTemplate;
        }
        /*
         * else if(){
            load_template(dirname( __FILE__ ) . '/gcar/page.php');
        }
         * */
    }
}