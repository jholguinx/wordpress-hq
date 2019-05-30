<?php

namespace HQRentalsPlugin\HQRentalsHelpers;

use HQRentalsPlugin\HQRentalsSettings\HQRentalsSettings;
use HQRentalsPlugin\HQRentalsVendor\Carbon;

class HQRentalsShortcodeHelper
{
    public function __construct()
    {
        $this->settings = new HQRentalsSettings();
        $this->dateHelper = new HQRentalsDatesHelper();
    }

    public function resolvesSafariIssue($is_safari, $post_data, $iframeBaseUrl)
    {
        if ($is_safari and $this->noDNSConfig($iframeBaseUrl)) {
            $this->setForSafariBrowser($post_data, esc_url($iframeBaseUrl));
        } else {
            $this->setForNotSafariBrowser($post_data, esc_url($iframeBaseUrl));
        }
    }

    public function setForSafariBrowser($postData, $urlFirstStep)
    {
        if (empty($postData)) {
            $metaDataSafari = array(
                'urlRedirect' => $urlFirstStep ,
                'isSafari' => 1
            );
        } else {
            try {
                if ($postData['pick_up_date']) {
                    if ($postData['pick_up_time']) {
                        $pickup_date = Carbon::createFromFormat($this->settings->getFrontEndDatetimeFormat(), $postData['pick_up_date'] . ' ' . $postData['pick_up_time']);
                        $return_date = Carbon::createFromFormat($this->settings->getFrontEndDatetimeFormat(), $postData['return_date'] . ' ' . $postData['return_time']);
                    } else {
                        $pickup_date = Carbon::createFromFormat($this->settings->getFrontEndDatetimeFormat(), $postData['pick_up_date']);
                        $return_date = Carbon::createFromFormat($this->settings->getFrontEndDatetimeFormat(), $postData['return_date']);
                    }
                    $metaDataSafari = array(
                        'urlRedirect' => $urlFirstStep. $this->getQueryStringForStep2OnSafari($postData, $pickup_date,$return_date),
                        'isSafari' => 1
                    );
                }
            } catch (Exception $e) {
                $metaDataSafari = array(
                    'urlRedirect' => $urlFirstStep,
                    'isSafari' => 1
                );    
            }
        }
        wp_localize_script('hq-resize-script', 'hqSafariData', $metaDataSafari);
    }

    public function setForNotSafariBrowser($postData, $urlFirstStep)
    {
        $metaDataSafari = array(
            'urlRedirect' => $urlFirstStep,
            'isSafari' => 0
        );
        wp_localize_script('hq-resize-script', 'hqSafariData', $metaDataSafari);
    }

    public function noDNSConfig($urlFirstStep)
    {
        return (strpos($urlFirstStep, 'caagcrm') !== false) or
            (strpos($urlFirstStep, 'hqrentals') !== false);
    }

    public function getQueryStringForStep2OnSafari($post_data, $pickUpDate, $returnDate)
    {
        $queryString = '';
        foreach($post_data as $key => $value){
            if(($key !== 'pick_up_date' and $key !== 'pick_up_time' and $key !== 'return_date' and $key !== 'return_time')){
                $queryString .= '&' . $key . '=' . $value;
            }
        }
        $queryString .= '&pick_up_date=' . $pickUpDate->format($this->dateHelper->getDateFormatFromCarbon($this->settings->getHQDatetimeFormat())) . ' ' . $pickUpDate->format($this->dateHelper->getTimeFormatFromCarbon($this->settings->getHQDatetimeFormat()));
        $queryString .= '&return_date=' . $returnDate->format($this->dateHelper->getDateFormatFromCarbon($this->settings->getHQDatetimeFormat())) . ' ' . $returnDate->format($this->dateHelper->getTimeFormatFromCarbon($this->settings->getHQDatetimeFormat()));
        $queryString .= '&target_step=2';
        return $queryString;
    }
}