<?php

namespace HQRentalsPlugin\HQRentalsHelpers;

class HQRentalsFrontHelper
{

    public function getTimesForDropdowns ( $begining, $end, $default = '12:00', $interval = '+15 minutes' )
    {
        $output = '';
        $current = strtotime( $begining );
        $end = strtotime( $end   );
        while( $current <= $end ) {
            $time = date( 'H:i', $current );
            $sel = ( $time == $default ) ? ' selected' : '';

            $output .= "<option value=\"{$time}\"{$sel}>" . date( 'H:i', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        }

        return $output;
    }
    public function sanitizeInput($postData)
    {
        foreach ($postData as $key => $value){
            $postData[$key] = sanitize_text_field($value);
        }
        return $postData;
    }
}