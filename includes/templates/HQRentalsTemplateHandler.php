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
        if (is_page('quotes')) {
            load_template(__DIR__ . '/page-quotes.php');
        }
        if (is_page('payments')) {
            load_template(__DIR__ . '/page-payments.php');
        }
    }
}