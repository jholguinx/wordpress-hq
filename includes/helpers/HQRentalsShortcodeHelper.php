<?php

namespace HQRentalsPlugin\HQRentalsHelpers;

class HQRentalsShortcodeHelper
{


    public function resolvesSafariIssue($is_safari, $post_data, $iframeBaseUrl)
    {
        if ($is_safari and $this->noDNSConfig(esc_url($iframeBaseUrl))) {
            $this->setForSafariBrowser($post_data, esc_url($iframeBaseUrl));
        } else {
            $this->setForNotSafariBrowser($post_data, esc_url($iframeBaseUrl));
        }
    }

    public function setForSafariBrowser($postData, $urlFirstStep)
    {
        if (empty($postData)) {
            $metaDataSafari = array(
                'urlRedirect' => $urlFirstStep,
                'isSafari' => 1
            );
        } else {
            $metaDataSafari = array(
                'urlRedirect' => $urlFirstStep . '&' . http_build_query($postData),
                'isSafari' => 1
            );
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
}