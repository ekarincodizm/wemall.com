<?php

class CachePage
{

    /**
     * Swicthing enable filter.
     *
     * Default is true, to caching all content set false.
     *
     * @var boolean
     */
    public static $enableFiltering = true;

    /**
     * Get cache page.
     *
     * @param  string $key
     * @param  string $url
     * @return mixed
     */
    public static function get($key, $url)
    {
        if (static::$enableFiltering and !is_null($url)) {
            if (!static::urlForceAllow($url)) {
                if (!self::urlAllow($url)) return false;
                if (!self::urlExcept($url)) return false;
            }
        }

        // Cache returned.
        if (Cache::tags('super-cache')->has($key) and !Input::has('no-cache')) {

            $value = Cache::tags('super-cache')->get($key);
            if (!empty($value)) {
                return $value;
            }
        }

        return false;
    }

    /**
     * Alias to get only result from key.
     *
     * @param  string $key
     * @param  string $url
     * @return mixed
     */
    public static function getResult($key, $url)
    {
        $value = static::get($key, $url);

        if (is_array($value) and isset($value['result'])) {
            return $value['result'];
        }

        return false;
    }

    /**
     * Save cache page.
     *
     * @param  string $key
     * @param  mixed $value
     * @param  string $url
     * @param  integer $minutes
     * @return mixed
     */
    public static function save($key, $value, $url, $minutes = 10)
    {
        if (static::$enableFiltering and !is_null($url)) {
            if (!static::urlForceAllow($url)) {
                if (!self::urlAllow($url)) return false;
                if (!self::urlExcept($url)) return false;
            }
        }

        $value = array('requestUrl' => $url, 'result' => $value, 'timestamp' => time());

        return Cache::tags('super-cache')->put($key, $value, $minutes);
    }

    /**
     * Force allow cache by pattern.
     *
     * @param  string $url
     * @return boolean
     */
    public static function urlForceAllow($url)
    {
        switch (true) {
            // Do not cache relate products.
            case (preg_match('/search/', $url) and preg_match('/relate/', $url)) :
                return true;
        }

        return false;
    }

    /**
     * URLs cache allow.
     *
     * @param  string $url
     * @return boolean
     */
    public static function urlAllow($url)
    {
        $list = array('brands', 'collections', 'products', 'banners', 'seo', 'provices');

        foreach ($list as $key => $value) {
            if (mb_strpos($url, $value) !== false) return true;
        }

        return false;
    }

    /**
     * URLs cache exception.
     * @param  string $url
     * @return boolean
     */
    public static function urlExcept($url)
    {
        $list = array('flash-sale', 'trueyou', 'discount', 'search');

        foreach ($list as $key => $value) {
            if (mb_strpos($url, $value) !== false) return false;
        }

        return true;
    }

}