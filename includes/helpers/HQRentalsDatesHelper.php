<?php

namespace HQRentalsPlugin\HQRentalsHelpers;


use HQRentalsPlugin\HQRentalsVendor\Carbon;
use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;

class HQRentalsDatesHelper
{
    public function __construct()
    {
        $this->carbon = new Carbon();
        $this->settings = new HQRentalsSettings();
    }

    public $systemSupportedDatesFormats = array(
        'iso' => 'Y-m-d H:i',
        'eu' => 'd-m-Y H:i',
        'us' => 'm/d/Y g:iA',
        'us_c' => 'm/d/Y g:i',
        'us_G' => 'm/d/Y G:i',
        've' => 'd/m/Y g:iA',
        'int' => 'd.m.Y g:iA',
        'id' => 'd-M-Y g:iA',
        'ch' => 'd.m.Y H:i',
        'ch_c' => 'Y-m-d G:i',
        'wp_c' => 'd-m-Y G:i'
    );

    public function getHtmlOptionForFrontEndDateSettingOption()
    {
        $html = '';
        foreach ($this->systemSupportedDatesFormats as $datesFormat) {
            if ($this->settings->getFrontEndDatetimeFormat() == $datesFormat) {
                $html .= '<option value="' . $datesFormat . '" selected="selected">' . $this->carbon->format($datesFormat) . '</option>';
            } else {
                $html .= '<option value="' . $datesFormat . '">' . $this->carbon->format($datesFormat) . '</option>';
            }

        }
        return $html;
    }
    public function getHtmlOptionForSystemDateSettingOption()
    {
        $html = '';
        foreach ($this->systemSupportedDatesFormats as $datesFormat) {
            if ($this->settings->getHQDatetimeFormat() == $datesFormat) {
                $html .= '<option value="' . $datesFormat . '" selected="selected">' . $this->carbon->format($datesFormat) . '</option>';
            } else {
                $html .= '<option value="' . $datesFormat . '">' . $this->carbon->format($datesFormat) . '</option>';
            }

        }
        return $html;
    }
}