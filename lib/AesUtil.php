<?php

namespace App\Services;

class AesUtil
{
    private static $key = 'Msi@a*l;Msi@a*l;';
    private static $iv  = '';
    private static $cipher = 'aes-128-cbc';

    public static function getKeyIv()
    {
        return self::$key;
    }
    /**
     * 加密
     */
    public static function EN71($plaintext)
    {
        if (in_array(self::$cipher, openssl_get_cipher_methods())) {
            $ivlen = openssl_cipher_iv_length(self::$cipher);
            $iv = openssl_random_pseudo_bytes($ivlen);
            $ciphertext = openssl_encrypt($plaintext, self::$cipher, self::$key, OPENSSL_ZERO_PADDING, $iv);
            //store $cipher, $iv, and $tag for decryption later
            return array($ciphertext, $iv);
        }
        return false;
    }
    /**
     * PHP 7.1+ 下 GCM 模式的 AES 解密 
     */
    public static function DE71($ciphertext)
    {
        if (in_array(self::$cipher, openssl_get_cipher_methods())) {
            $original_plaintext = openssl_decrypt($ciphertext[0], self::$cipher, self::$key, OPENSSL_ZERO_PADDING, $ciphertext[1]);
            return $original_plaintext;
        }
        return false;
    }
    /**
     * 加密
     */
    public static function EN56($plaintext)
    {
        $ivlen = openssl_cipher_iv_length(self::$cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $ciphertext_raw = openssl_encrypt($plaintext, self::$cipher, self::$key, $options=OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $ciphertext_raw, self::$key, $as_binary=true);
        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
        return array($ciphertext, $ivlen);
    }
    /**
     * PHP 5.6+ 的 AES 解密 
     */
    public static function DE56($ciphertext)
    {
        $c = base64_decode($ciphertext[0]);
        $iv = substr($c, 0, $ciphertext[1]);
        $hmac = substr($c, $ciphertext[1], $sha2len=32);
        $ciphertext_raw = substr($c, $ciphertext[1]+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, self::$cipher, self::$key, $options=OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, self::$key, $as_binary=true);
        if (hash_equals($hmac, $calcmac))//PHP 5.6+ timing attack safe comparison
        {
            return $original_plaintext;
        }
        return false;
    }
}