<?php

namespace HQRentalsPlugin\HQRentalsHelpers;

class HQRentalsLocaleHelper
{
    private static $langDir = '/langs/';

    public function __construct()
    {
        $this->locale = get_locale();
        $this->language = explode('_', $this->locale)[0];
        $this->country = explode('_', $this->locale)[1];
    }
    public static function translate($key) : void
    {
        echo HQRentalsLocaleHelper::resolveTranslation($key);
    }
    public static function resolveTranslation($key): string
    {
        try {
            $langs = HQRentalsLocaleHelper::resolveLangFile();
            if ($langs and  isset($langs[$key])) {
                return $langs[$key];
            }
            return $key;
        } catch (\Exception $e) {
            return $key;
        }

    }

    public static function filePath($locale): string
    {
        return dirname(__DIR__) . HQRentalsLocaleHelper::$langDir . $locale . '.php';
    }

    public static function resolveLangFile()
    {
        try {
            $lang = explode('_', get_locale())[0];
            $locale = empty($lang) ? 'en' : $lang;
            return include(HQRentalsLocaleHelper::filePath($locale));
        } catch (\Exception $e) {
            return false;
        }
    }
}