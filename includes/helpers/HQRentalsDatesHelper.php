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
        'iso'   => 'Y-m-d H:i',
        'eu'    => 'd-m-Y H:i',
        'eu_a'  => 'd-m-Y g:iA',
        'us'    => 'm/d/Y g:iA',
        'us_c'  => 'm/d/Y g:i',
        'us_G'  => 'm/d/Y G:i',
        've'    => 'd/m/Y g:iA',
        'int'   => 'd.m.Y g:iA',
        'id'    => 'd-M-Y g:iA',
        'ch'    => 'd.m.Y H:i',
        'ch_c'  => 'Y-m-d G:i',
        'wp_c'  => 'd-m-Y G:i',
        'wp_d'  => 'Y-m-d G:i',
        'wp_e'  => 'd/m/Y G:i'
    );
    public function getHtmlOptionForFrontEndDateSettingOption()
    {
        $html = '';
        foreach ($this->systemSupportedDatesFormats as $datesFormat) {
            if ($this->settings->getFrontEndDatetimeFormat() == $datesFormat) {
                $html .= '<option value="' . esc_attr($datesFormat) . '" selected="selected">' . esc_attr($this->carbon->format($datesFormat)) . '</option>';
            } else {
                $html .= '<option value="' . esc_attr($datesFormat) . '">' . esc_attr($this->carbon->format($datesFormat)) . '</option>';
            }

        }
        return $html;
    }
    public function getHtmlOptionForSystemDateSettingOption()
    {
        $html = '';
        foreach ($this->systemSupportedDatesFormats as $datesFormat) {
            if ($this->settings->getHQDatetimeFormat() == $datesFormat) {
                $html .= '<option value="' . esc_attr($datesFormat) . '" selected="selected">' . esc_attr($this->carbon->format($datesFormat)) . '</option>';
            } else {
                $html .= '<option value="' . esc_attr($datesFormat) . '">' . esc_attr($this->carbon->format($datesFormat)) . '</option>';
            }

        }
        return $html;
    }
    public function getDateFormatFromCarbon($format)
    {
        return explode(' ', $format)[0];
    }
    public function getTimeFormatFromCarbon($format)
    {
        return explode(' ', $format)[1];
    }
}