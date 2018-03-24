<?php

class ThorCookie
{
    public static function set($name, $value, $expire = 0)
    {
        self::make($name, $value, $expire);
        return true;
    }

    public static function get($name)
    {
        if(isset($_COOKIE[$name])){
            $data = self::decodeData($_COOKIE[$name]);
        }else{
            $data = null;
        }

        return $data;
    }

    public static function forget($name)
    {
        self::make($name, null, time() - 36000);
        unset($_COOKIE[$name]);
        
        return true;
    }

    private static function make($name, $value, $expire = 0, $path = "/", $domain = null, $secure = false, $httpOnly = true)
    {
        $time = ($expire == 0) ? 0 : time() + ($expire * 60);

        $encode_data = null;
        if($value){
            $encode_data = self::encodeData($value);
        }

        if(!$domain){
            $domain = Config::get('session.domain');
        }

        setcookie($name, $encode_data, $time, $path, $domain, $secure, $httpOnly);

        return true;
    }

    private static function encodeData($str)
    {
        $str = json_encode($str);
        return base64_encode($str);
    }

    private static function decodeData($str)
    {
        $str = base64_decode($str);
        $str = json_decode($str, true);
        return $str;
    }
}