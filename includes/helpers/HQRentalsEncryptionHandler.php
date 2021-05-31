<?php

namespace HQRentalsPlugin\HQRentalsHelpers;


class HQRentalsEncryptionHandler
{

    static protected $secretKey = AUTH_KEY;
    static protected $secretVI = SECURE_AUTH_KEY;
    static protected $encryptMethod = "AES-256-CBC";

    public static function encrypt($string)
    {
        $key = hash('sha256', static::$secretKey);
        $iv = substr(hash('sha256', static::$secretVI), 0, 16);
        return base64_encode(openssl_encrypt($string, static::$encryptMethod, $key, 0, $iv));
    }

    public static function decrypt($string)
    {
        $key = hash('sha256', static::$secretKey);
        $iv = substr(hash('sha256', static::$secretVI), 0, 16);
        return openssl_decrypt(base64_decode($string), static::$encryptMethod, $key, 0, $iv);
    }
}