<?php
class ElastiCache
{

    protected $_aws_cache;
    protected $config = array();

    public static function save($key = NULL, $value = NULL, $url, $lifetime = 10)
    {
        $debug_cache = Input::get('debug_cache');
        try {
            Cache::put($key, $value, $lifetime);
            if (!empty($debug_cache)) {
                echo '<b>Debug Cache</b><br/>Save cache key = ' . $key . ' <br>';
                echo 'url = ' . $url . ' <br>';
            }
            return true;
        } catch (Exception $e) {
            if (!empty($debug_cache)) {
                echo 'Error <br>';
                echo 'url = ' . $url . ' <br>';
                s($e->getMessage());
            }
            return NULL;
        }
    }

    public static function getResult($key = NULL, $url='')
    {

        try {
            $nocache = Input::get('no-cache', null);
            $debug_cache = Input::get('debug_cache');
            if (Cache::has($key) && is_null($nocache)) {
                $response = Cache::get($key);
                if (!empty($debug_cache)) {
                    echo '<b>Debug Cache</b><br/>Get Data From Cache key = ' . $key . ' <br>';
                    echo 'url = ' . $url . ' <br>';

                }
                return $response;
            }
            return NULL;
        } catch (Exception $e) {
            return NULL;
        }
    }

    public static function getResultV2($key = NULL, $url='', $nocache = false)
    {

        try {
            if (Cache::has($key) && !$nocache) {
                $response = Cache::get($key);
                return $response;
            }
            return null;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function remove($key = NULL)
    {
        try {
            Cache::forget($key);
            return TRUE;
        } catch (Exception $e) {
            return NULL;
        }
    }

    /**
     * This method can't use with aws elasticache
     *
     * @return array
     */
    public static function getAllKeys(){

        $keys = array();
        try{
            $host = Config::get("cache.memcached.0.host", "");
            $port = Config::get("cache.memcached.0.port", "");
            if(!empty($host) && !empty($port)) {
                $memcached = new Memcached;
                $memcached->addServer($host, $port);
                $keys = $memcached->getAllKeys();
            }
        }catch (Exception $e){
            $keys = array();
        }

        return $keys;
    }
}