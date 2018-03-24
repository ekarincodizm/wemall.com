<?php namespace ItruemartClient;

use Config, Event, ACL, Log, Input, Request,ElastiCache;

class ItruemartClient {

    /**
     * Prefix with caching.
     *
     * @var string
     */
    protected $prefix = 'itruemart-client';

    /**
     * API endpoint.
     *
     * @var string
     */
    protected $endpointUrl;

    /**
     * CURL default options.
     *
     * @var array
     */
    public static $CURL_OPTS = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_USERAGENT      => 'itruemart-0.1',
        CURLOPT_FOLLOWLOCATION => 0,
        CURLOPT_ENCODING       => ''
    );

    /**
     * SDK construct.
     *
     * @param array $params
     */
    public function __construct($params = array())
    {
        $this->initialize($params);
    }

    /**
     * Intialize config.
     *
     * @param  array $params
     * @return void
     */
    public function initialize($params)
    {
        if (count($params)) foreach ($params as $key => $val)
        {
            $method = 'set'.ucfirst($key);

            $this->$method($val);
        }
    }

    public function setEndpointUrl($val)
    {
        $this->endpointUrl = $val;
    }

    /**
     * Push data to endpoint.
     *
     * @param  string $path
     * @param  array  $args
     * @return mixed
     */
    public function api($path, $args = array(), $method = 'GET')
    {
        $uri = $this->endpointUrl.'/'.ltrim($path, '/');

        // $args = array_merge(array(
        //     'appId'  => $this->appId,
        //     'secret' => $this->secret
        // ), $args);

        return $this->makeRequest($uri, $args, $method);
    }

    public function getSeoEssay($page)
    {
        $params = array(
            'format' => 'json',
            'page'   => $page
        );

//        $query = http_build_query($params);

//        $that = $this;

//        return \Cache::remember($this->getKeyCache($query), 60, function() use ($that, $query)
//        {
//            return $that->api('seo?'.$query);
//        });

        return $this->api('seo', $params);
    }

    public function getSeoFooter()
    {
        $params = array(
            'format' => 'json'
        );

//        $query = http_build_query($params);
//
//        $that = $this;
//
//        return \Cache::remember($this->getKeyCache($query), 60, function() use ($that, $query)
//        {
//            return $that->api('seo/footer_link?'.$query);
//        });
        return $this->api('seo/footer_link', $params);
    }

    public function subscribe($params = array())
    {
        $defaults = array(
            'format' => 'json',
            'email'  => null,
            'locale' => 1, // 1 = en, 2 = th
        );

        $params = array_merge($defaults, $params);

        return $this->api('/news/subscribe/save', $params, 'POST');

    }

    public function getProductListing($params = array())
    {
        $defaults = array(
            'condition' => null,
            'format' => 'json'
        );

        $params = array_merge($defaults, $params);

//        $query = http_build_query($params);
//
//        $that = $this;

//        return \Cache::remember($this->getKeyCache($query), 60, function() use ($that, $query)
//        {
//            return $this->api('/product/listing?'.$query);
//        });
        return $this->api('/product/listing', $params);
    }

    protected function getKeyCache($string)
    {
        if ( ! is_string($string))
        {
            $string = json_encode($string);
        }

        $key = md5($string);

        return $this->prefix.'-'.$key;
    }

    /**
     * Makes an HTTP request. This method can be overridden by subclasses if
     * developers want to do fancier things or use something other than curl to
     * make the request.
     *
     * @param  string $url
     * @param  array  $args
     * @param  CURL   $ch
     * @return string
     */
    public static function makeRequest($url, array $args, $method)
    {
        // Using cache for specific request api.
        $keyCurl = md5($url.json_encode($args).$method);

        if ($response = ElastiCache::getResult($keyCurl, $url))
        {
            return new Process($response, 'application/json');
        }

        static $ch, $totaltimeExec = 0;

        // CURL is exists.
        if ( ! is_resource($ch))
        {
            $ch = curl_init();
        }

        $opts = self::$CURL_OPTS;

        // POST request.
        if (strcasecmp($method, 'POST') == 0)
        {
            $opts[CURLOPT_POST] = true;
            $opts[CURLOPT_POSTFIELDS] = http_build_query($args, null, '&');
        }else{
            $url .= "?" . http_build_query($args, null, '&');
        }

        // URL to request.
        $opts[CURLOPT_URL] = $url;

        // disable the 'Expect: 100-continue' behaviour. This causes CURL to wait
        // for 2 seconds if the server does not support this header.
        if (isset($opts[CURLOPT_HTTPHEADER]))
        {
            $existing_headers = $opts[CURLOPT_HTTPHEADER];
            $existing_headers[] = 'Expect:';
            $opts[CURLOPT_HTTPHEADER] = $existing_headers;
        }
        else
        {
            $opts[CURLOPT_HTTPHEADER] = array('Expect:');
        }

        $opts[CURLOPT_CUSTOMREQUEST] = strtoupper($method);

        // Requesting.
        curl_setopt_array($ch, $opts);
        $response = curl_exec($ch);

        // Returned information.
        $info = curl_getinfo($ch);

        // Include all curel progress.
        $totaltimeExec = $totaltimeExec + $info['total_time'];
        $info['total_time_execute'] = $totaltimeExec;

        curl_close($ch);

        // We accept cache only GET.
        ElastiCache::save($keyCurl, $response, $url, 6);

        // Fire event to get log.
        Event::fire('api.request.itruemart', array($method, $url, $args, $info));

        return new Process($response, $info['content_type']);
    }

    /**
     * Excec CURL.
     *
     * Calling iTruemart API is too slow, to increase performance you can disable
     * this function.
     *
     * @param  string  $url
     * @param  mixed   $post
     * @param  string  $method_type
     * @param  boolean $debug
     * @param  integer $timeout
     * @return mixed
     */
    public static function execCurl($url = NULL, $post = NULL, $method_type = 'get', $debug = false, $timeout = 10)
    {
        $url    = $url;
        $args   = $post;
        $method = $method_type;

        // Using cache for specific request api.
        $keyCurl = Request::server('SERVER_NAME').'_'. preg_replace('/\//','_',$url).'_'.md5($url.json_encode($args).$method);

        $debug = Input::get('chk_cache');
        $nocache = Input::get('no-cache');
        if (($response = ElastiCache::getResult($keyCurl, $url)) && ! $nocache && strtolower($method) == 'get')
        {
            if (!empty($debug)) {
                echo 'From Cache <br>';
                echo 'keyCurl = ' . $keyCurl . ' <br>';
                //s($response);
            }
            return $response;
        }
        if (!empty($debug)) {
            echo 'From API <br>';
            echo 'keyCurl = ' . $keyCurl . ' <br>';
        }

        static $ch, $totaltimeExec = 0;

        // CURL is exists.
        if ( ! is_resource($ch))
        {
            $ch = curl_init();
        }

        $opts = self::$CURL_OPTS;

        // POST request.
        if (strcasecmp($method, 'POST') == 0)
        {
            $opts[CURLOPT_POST] = true;
            $opts[CURLOPT_POSTFIELDS] = http_build_query($args, null, '&');
        }else{
            $url .= "?" . http_build_query($args, null, '&');
        }

        // URL to request.
        $opts[CURLOPT_URL] = $url;

        // disable the 'Expect: 100-continue' behaviour. This causes CURL to wait
        // for 2 seconds if the server does not support this header.
        if (isset($opts[CURLOPT_HTTPHEADER]))
        {
            $existing_headers = $opts[CURLOPT_HTTPHEADER];
            $existing_headers[] = 'Expect:';
            $opts[CURLOPT_HTTPHEADER] = $existing_headers;
        }
        else
        {
            $opts[CURLOPT_HTTPHEADER] = array('Expect:');
        }

        $opts[CURLOPT_CUSTOMREQUEST] = strtoupper($method);

        // Requesting.
        curl_setopt_array($ch, $opts);
        $response = curl_exec($ch);

        // Returned information.
        $info = curl_getinfo($ch);

        curl_close($ch);

        // Include all curel progress.
        $totaltimeExec = $totaltimeExec + $info['total_time'];
        $info['total_time_execute'] = $totaltimeExec;

        // We accept cache only GET.
        ElastiCache::save($keyCurl, $response, $url, 6);

        // Fire event to get log.
        Event::fire('api.request.itruemart.exec', array($method, $url, $args, $info));

        return $response;
    }

}