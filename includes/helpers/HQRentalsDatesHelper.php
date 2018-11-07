<?php
namespace HQRentalsPlugin\HQRentalsHelpers;


use HQRentalsPlugin\HQRentalsVendor\Carbon;

class HQRentalsDatesHelper
{
    public $systemSupportedDatesFormats = array(
        'iso'   =>  'Y-m-d H:i',
        'eu'    =>  'd-m-Y H:i',
        'us'    =>  'm/d/Y g:iA',
        'us_c'  =>  'm/d/Y g:i',
        'us_G'  =>  'm/d/Y G:i',
        've'    =>  'd/m/Y g:iA',
        'int'   =>  'd.m.Y g:iA',
        'id'    =>  'd-M-Y g:iA',
        'ch'    =>  'd.m.Y H:i',
        'ch_c'  =>  'Y-m-d G:i'
    );
    public function __construct()
    {
        $this->carbon = new Carbon();
    }
    public function getHtmlOptionForSettingPage()
    {
        $html = '';
        foreach ($this->systemSupportedDatesFormats as $datesFormat){
            $html .= '<option value="'. $datesFormat .'">'. $this->carbon->format($datesFormat) .'</option>';
        }
        return $html;
    }
}