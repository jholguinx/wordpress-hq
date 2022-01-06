<?php

namespace HQRentalsPlugin\HQRentalsHelpers;
use HQRentalsPlugin\HQRentalsQueries\HQRentalsDBQueriesLocations;

class HQRentalsFrontHelper
{

    public function getTimesForDropdowns($begining, $end, $default = '12:00', $interval = '+15 minutes')
    {
        $output = '';
        $current = strtotime($begining);
        $end = strtotime($end);
        while ($current <= $end) {
            $time = date('H:i', $current);
            $sel = ($time == $default) ? ' selected' : '';

            $output .= "<option value=\"{$time}\"{$sel}>" . date('H:i', $current) . '</option>';
            $current = strtotime($interval, $current);
        }

        return $output;
    }

    public function sanitizeTextInputs($postData)
    {
        foreach ($postData as $key => $value) {
            $postData[$key] = sanitize_text_field($value);
        }
        return $postData;
    }

    public function escapeAttributes($data)
    {
        foreach ($data as $key => $value) {
            $data[$key] = esc_attr($value);
        }
        return $data;
    }

    public static function resolveFontAwesomeIcon($icon)
    {
        if ((strpos($icon, 'fas fa') !== false) or (strpos($icon, 'fab fa') !== false)) {
            return $icon;
        } else {
            return 'fas fa-' . $icon;
        }
    }

    public function resolveUrlQueryParam($getData, $paramName)
    {
        return (empty($getData[$paramName])) ? '' : ('?' . $paramName . '=' . $getData[$paramName]);
    }

    public function resolveUrlOnQuotes($baseUrl, $quoteId)
    {
        return $baseUrl . 'public/car-rental/reservations/step3' . $quoteId;
    }

    public function resolveUrlOnPayments($baseUrl, $paymentId)
    {
        return $baseUrl . 'public/car-rental/all-payments/' . $paymentId . '/request/resolve';
    }

    public function filterElementsBYId($array, $itemId)
    {
        return array_values(array_filter($array, function ($car) use ($itemId) {
            return (string)$car->id == (string)$itemId;
        }))[0];
    }
    public function getLocationOptions($locations = null)
    {
        $html = "";
        if(is_array($locations) and count($locations)){
            foreach ($locations as $location){
                $html .= "<option value='{$location->getId()}'>{$location->getName()}</option>";
            }
        }else{
            $query = new HQRentalsDBQueriesLocations();
            $dbLocations = $query->allLocations();
            foreach ($dbLocations as $location){
                $html .= "<option value='{$location->getId()}'>{$location->getName()}</option>";
            }
        }
        return $html;
    }
    static public function getTranslatedContent($object)
    {
        if($object instanceof \stdClass) {

            $lang = explode("_", get_locale())[0];
            if(isset($object->label_for_website)){
                return empty($object->label_for_website->{$lang}) ? "" : $object->label_for_website->{$lang};
            }else{
                return "";
            }
        }else{
            return "";
        }
    }
}