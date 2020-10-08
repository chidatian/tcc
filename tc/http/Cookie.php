<?php

namespace Tc\Http;

class Cookie {
    public function set($key, $value, $expire=0, $path = "", $domain = "", $secure = false, $httponly = true) {
        setcookie($key, $value, $expire, $path, $domain, $secure, $httponly);
    }

    public function get($key = '') {
        return $key == '' ? $_COOKIE : (isset($_COOKIE[$key]) ? $_COOKIE[$key] : null);
    }
}