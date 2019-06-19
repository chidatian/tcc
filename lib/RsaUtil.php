<?php

namespace App\Services;

class RsaUtil
{
    private static $pubpath   = '../storage/app/public/cert_public.key';
    private static $privpath  = '../storage/app/public/cert_private.pem';
    private static $config    = array(
        "digest_alg" => "sha512",
        "private_key_bits" => 4096,
        "private_key_type" => OPENSSL_KEYTYPE_RSA,
    );
    /**
     * 生成，私钥，公钥, 执行一次就可以
     */
    public static function init()
    {
        $res = openssl_pkey_new(self::$config);
        openssl_pkey_export($res, $privKey);
        $pubKey = openssl_pkey_get_details($res);
        $pubKey = $pubKey["key"];
        file_put_contents(self::$pubpath, $pubKey);
        file_put_contents(self::$privpath, $privKey);
    }
    /**
     * 获取公钥
     */
    public static function getPublicKey()
    {
        $text= file_get_contents(self::$pubpath);
        return $text;
    }
    /**
     * 解密
     */
    public static function DE($encrypted, $isJS = false)
    {
        $privKey = self::getPrivKey();
        $encrypted = $isJS ? base64_decode($encrypted) : $encrypted;
        // Decrypt the data using the private key and store the results in $decrypted
        openssl_private_decrypt($encrypted, $decrypted, $privKey);
        return $decrypted;
    }
    /**
     * 加密
     */
    public static function EN($data)
    {
        $pubKey = self::getPubKey();
        // Encrypt the data to $encrypted using the public key
        openssl_public_encrypt($data, $encrypted, $pubKey);
        return $encrypted;
    }
    
    private static function getPubKey()
    {
        if(file_exists(self::$pubpath)) {
            $text= file_get_contents(self::$pubpath);
            $res = openssl_pkey_get_public($text);
            if($res !== false) {
                return $res;
            }
        }
        return false;
    }
    /**
     * 获取私钥
     */
    private static function getPrivKey()
    {
        if(file_exists(self::$privpath)) {
            $text= file_get_contents(self::$privpath);
            $res = openssl_pkey_get_private($text);
            if($res !== false) {
                return $res;
            }
        }
        return false;
    }
    
}