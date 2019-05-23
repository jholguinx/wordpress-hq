<?php
namespace HQRentalsPlugin\HQRentalsHelpers;

class HQRentalsShortcodeHelper{

    public function __construct()
    {

    }

    public function setForSafariBrowser($postData, $urlFirstStep)
    {
        if(empty($postData)){
            $metaDataSafari = array(
                'urlRedirect'   =>  $urlFirstStep,
                'isSafari'      =>  1
            );
        }else{
            $metaDataSafari = array(
                'urlRedirect'   =>  $urlFirstStep . '&' . http_build_query($postData),
                'isSafari'      =>  1
            );
        }
        wp_localize_script('hq-resize-script', 'hqSafariData', $metaDataSafari);
    }
    public function setForNotSafariBrowser($postData, $urlFirstStep)
    {
        $metaDataSafari = array(
            'urlRedirect'   =>  $urlFirstStep,
            'isSafari'      =>  0
        );
        wp_localize_script('hq-resize-script', 'hqSafariData', $metaDataSafari);
    }

    public function noDNSConfig($urlFirstStep)
    {
        return (strpos($urlFirstStep, 'caagcrm') !== false) or
            (strpos($urlFirstStep, 'hqrentals') !== false);
    }
}