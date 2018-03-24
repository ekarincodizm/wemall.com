<?php

class PcmsClient {

    /**
     * Const user.
     */
    const USER = 'user';

    /**
     * Const non-user.
     */
    const GUEST = 'non-user';

    /**
     * PCMS endpoint.
     *
     * @var string
     */
    protected $url;

    /**
     * PCMS endpoint.
     *
     * @var string
     */
    protected $apiPcms;

    /**
     * PCMS Application key.
     *
     * @var [string]
     */
    protected $appKey;

    /**
     * Reduce double request per page.
     *
     * @var array
     */
    public $objectCache = array(
        'checkout' => array(),
        'cart'     => array(),
        "checkoutv2" => array()
    );

    /**
     * CURL default options.
     *
     * @var array
     */
    public static $CURL_OPTS = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_USERAGENT      => 'pcms-0.1',
        CURLOPT_FOLLOWLOCATION => 0,
        CURLOPT_ENCODING       => ''
    );


    public $lifetime = 6;

    /**
     * Construct.
     *
     * @param  array $config
     * @return void
     */
    public function __construct(array $config)
    {
        $this->initialize($config);
    }

    /**
     * Initialize config.
     *
     * @param  array $config [description]
     * @return void
     */
    protected function initialize($config)
    {
        foreach ($config as $key => $val)
        {
            $this->{$key} = $val;
        }
    }

    /**
     * Request PCMS api.
     *
     * @param  string $path
     * @param  arary  $params
     * @param  string $method
     * @return array
     */
    public function api($path, $params = array(), $method = 'GET', $nocache = false, $curl_opts_input = NULL)
    {
        // Add lang to any request.
        $params['lang'] = Lang::getLocale();

        // Full URL to request pcms.
        $requestUrl = $this->url.'/'.$this->appKey.'/'.$path;

        // Get method should add traling query string.
        if (strcasecmp($method, 'GET') == 0)
        {
            $real_params = $params;
            $params = http_build_query($params);

            if ( ! empty($params))
            {
                if (strpos($requestUrl, '?') !== false)
                {
                    $requestUrl .= '&'.$params;
                }
                else
                {
                    $requestUrl .= '?'.$params;
                }
            }

            //For check quota in level D
            if(!empty($real_params['check_quota']))
            {
                $params = array(
                    'check_quota' => 'Y'
                );

            }
            else
            {
                $params = array();
            }

        }

        $response = $this->makeRequest($requestUrl, $params, $method, $nocache, $curl_opts_input);

        if ( ! isset($response['data']) && is_array($response))
        {
            $response['data'] = array();
        }

        return $response;
    }

     public function apiV5($path, $params = array(), $method = 'GET', $nocache = false, $curl_opts_input = NULL)
    {
        // Add lang to any request.
        $params['lang'] = Lang::getLocale();

        if(Input::has('no-cache')){
            $params['no-cache'] = Input::get('no-cache');
        }
        
        $appKey = Config::get('endpoints.pcms.appKey');

        // Full URL to request pcms.
        $requestUrl = $this->apiPcms.'/v5/'.$appKey.'/'.$path;

        // Get method should add traling query string.
        if (strcasecmp($method, 'GET') == 0)
        {
            $real_params = $params;
            $params = http_build_query($params);

            if ( ! empty($params))
            {
                if (strpos($requestUrl, '?') !== false)
                {
                    $requestUrl .= '&'.$params;
                }
                else
                {
                    $requestUrl .= '?'.$params;
                }
            }

            //For check quota in level D
            if(!empty($real_params['check_quota']))
            {
                $params = array(
                    'check_quota' => 'Y'
                );

            }
            else
            {
                $params = array();
            }

        }

        $response = $this->makeRequest($requestUrl, $params, $method, $nocache, $curl_opts_input);

        if ( ! isset($response['data']) ) {
            $response['data'] = array();
        }

        return $response;
    }

    public function pcmsApiV5($path, $params = array(), $method = 'GET', $nocache = false, $curl_opts_input = NULL)
    {
        // Add lang to any request.
        $params['lang'] = Lang::getLocale();

        if(Input::has('no-cache')){
            $params['no-cache'] = Input::get('no-cache');
        }

        $appKey = Config::get('endpoints.pcms.webApiKey');

        // Full URL to request pcms.
        $requestUrl = $this->apiPcmsWeb.'/'.$appKey.'/'.$path;

        // Get method should add traling query string.
        if (strcasecmp($method, 'GET') == 0)
        {
            $real_params = $params;
            $params = http_build_query($params);

            if ( ! empty($params))
            {
                if (strpos($requestUrl, '?') !== false)
                {
                    $requestUrl .= '&'.$params;
                }
                else
                {
                    $requestUrl .= '?'.$params;
                }
            }

            //For check quota in level D
            if(!empty($real_params['check_quota']))
            {
                $params = array(
                    'check_quota' => 'Y'
                );

            }
            else
            {
                $params = array();
            }

        }

        $response = $this->makeRequest($requestUrl, $params, $method, $nocache, $curl_opts_input);

        if ( ! isset($response['data']) ) {
            $response['data'] = array();
        }

        return $response;
    }

    /**
     * Alias of api method cart.
     *
     * @return array
     */
    public function getCart()
    {
        $user = ACL::getUser();

        $params['customer_type']   = (ACL::isLoggedIn()) ? self::USER : self::GUEST;
        $params['customer_ref_id'] = $user['user_id'];

        // $that = $this;

        // $okey = 'cart:'.json_encode($params);

        // $response = array_get($this->objectCache, 'cart.'.$okey, function() use ($that, $okey, $params)
        // {
        //     $response = $that->api('cart/customer-cart/'.$params['customer_ref_id'].'/'.$params['customer_type']);

        //     array_set($that->objectCache, 'cart.'.$okey, $response);

        //     return $response;
        // });

        // return $response;

        return $this->api('cart/customer-cart/'.$params['customer_ref_id'].'/'.$params['customer_type']);
    }

    /**
     * Alias of api method cart.
     *
     * @return array
     */
    public function getCartV2()
    {

        $user = ACL::getUser();

        $params['customer_type']   = (ACL::isLoggedIn()) ? self::USER : self::GUEST;
        $params['customer_ref_id'] = $user['user_id'];

        // $that = $this;

        // $okey = 'cart:'.json_encode($params);

        // $response = array_get($this->objectCache, 'cart.'.$okey, function() use ($that, $okey, $params)
        // {
        //     $response = $that->api('cart/customer-cart/'.$params['customer_ref_id'].'/'.$params['customer_type']);

        //     array_set($that->objectCache, 'cart.'.$okey, $response);

        //     return $response;
        // });

        // return $response;

        return $this->apiv2('cart/customer-cart/'.$params['customer_ref_id'].'/'.$params['customer_type'], array(), "GET", true, 0, 2);
    }
    
    /**
     * Alias of api method checkout.
     *
     * This method using object cache to reduce double requests.
     *
     * @return array
     */
    public function getCheckout()
    {
        $user = ACL::getUser();

        $params['customer_type']   = ACL::isLoggedIn() ? self::USER : self::GUEST;
        $params['customer_ref_id'] = $user['user_id'];

        $okey = 'checkout:'.json_encode($params);

        $that = $this;

        // Reduce many request for single page.
        $response = array_get($this->objectCache, 'checkout.'.$okey, function() use ($that, $okey, $params)
        {
            $response = $that->api('checkout', $params);

            array_set($that->objectCache, 'checkout.'.$okey, $response);

            return $response;
        });

        return $response;
    }

    /**
     * Alias of api method checkout v2.
     *
     * This method using object cache to reduce double requests.
     *
     * @return array
     */
    public function getCheckoutV2()
    {
        $user = ACL::getUser();

        $params['customer_type']   = ACL::isLoggedIn() ? self::USER : self::GUEST;
        $params['customer_ref_id'] = $user['user_id'];

        $okey = 'checkout:'.json_encode($params);

        $that = $this;

        // Reduce many request for single page.
        $response = array_get($this->objectCache, 'checkoutv2.'.$okey, function() use ($that, $okey, $params)
        {
            //apiv2($path, $params, $method, $nocache, $lifetime, $api_version).
            $response = $that->apiv2('checkout', $params, "GET", true, 0, 2);

            array_set($that->objectCache, 'checkoutv2.'.$okey, $response);

            return $response;
        });

        return $response;
    }

    /**
     * Alias of api method customer.
     *
     * @return array
     */
    public function getCustomerAddresses()
    {
        $user = ACL::getUser();

        $params['customer_type']   = ACL::isLoggedIn() ? self::USER : self::GUEST;
        $params['customer_ref_id'] = $user['user_id'];

        return $this->api('customers/address', $params);
    }

    /**
     * Alias of api method cart apply.
     *
     * @return array
     */
    public function postApplyCoupon($code)
    {
        $user = ACL::getUser();

        $params['customer_type']   = ACL::isLoggedIn() ? self::USER : self::GUEST;
        $params['customer_ref_id'] = $user['user_id'];
        $params['code'] = $code;

        return $this->api('cart/apply-coupon', $params, 'POST');
    }

    /**
     * Alias of api method collection.
     *
     * @return array
     */
    public function getVertical()
    {
        return $this->api('collections?is_category=1&depth=2');
    }

    /**
     * Alias of api method customer trueyou.
     *
     * @return array
     */
    public function getCheckTrueyouByIdCard($id_card)
    {
        $args = array(
            'thai_id' => $id_card
        );

        return $this->api('customers/trueyou', $args, 'GET');
    }

    /**
     * Alias of api method apply trueyou (member).
     *
     * @return array
     */
    public function postApplyTrueyouCard($id_card)
    {
        if ( ! ACL::isLoggedIn())
        {
            return false;
        }

        $user = ACL::getUser();

        $params = array(
            'customer_ref_id' => $user['ssoId'],
            'customer_type'   => ACL::isLoggedIn() ? self::USER : self::GUEST,
            'thai_id'         => $id_card
        );

        return $this->api('members/apply-trueyou', $params, 'POST');
    }

    /**
     * Alias of api apply trueyou (cart).
     *
     * @return array
     */
    public function applyTrueyouToCart($id_card)
    {
        $user = \ACL::getUser();
        $params = array(
            'customer_ref_id' => $user['ssoId'],
            'customer_type'   => ACL::isLoggedIn() ? self::USER : self::GUEST,
            'thai_id'         => $id_card
        );

        return $this->api('cart/apply-trueyou', $params, 'POST');
    }

    /**
     * Delete cart.
     */
    public function deleteCart(){
        $user = \ACL::getUser();
        $params = array(
            'customer_ref_id' => $user['ssoId'],
            'customer_type'   => ACL::isLoggedIn() ? self::USER : self::GUEST
        );

        return $this->api('cart/destroy', $params, 'POST', true);
    }

    /**
     * Alias of api method member activate.
     *
     * @return array
     */
    public function activateUser($uid)
    {
        $params = array(
            'ssoId' => $uid,
        );
        return $this->api('members/activate', $params, 'POST');
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
    protected function makeRequest($url, array $args, $method, $nocache = false,$curl_opts_input)
    {

        // Using cache for specific request api.
        $keyCurl = md5($url.json_encode($args).$method);

        if (($response = CachePage::getResult($keyCurl, $url)) && ! $nocache)
        {
            return $response;
        }

        static $ch, $totaltimeExec = 0;

        // CURL is exists.
        if ( ! is_resource($ch))
        {
            $ch = curl_init();
        }

        if(is_null($curl_opts_input))
        {
            $opts = self::$CURL_OPTS;
        }else{
            $opts = $curl_opts_input;
        }

        // POST request.
        if (strcasecmp($method, 'POST') == 0)
        {
            $opts[CURLOPT_POST] = true;
            $opts[CURLOPT_POSTFIELDS] = http_build_query($args, null, '&');
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

        // Decode json data.
        if ($info['content_type'] == 'application/json')
        {
            $response = json_decode($response, true);
        }

        // Fire event to get log.
        Event::fire('api.request.pcms', array($method, $url, $args, $info));

        curl_close($ch);

        if ( !empty($args['check_quota']))
        {
            // not save cache when have check_quota params
        }
        else
        {
            // We accept cache only GET.
            CachePage::save($keyCurl, $response, $url, $this->lifetime);
        }

        return $response;
    }

    /**
     * Request PCMS api.
     *
     * @param  string $path
     * @param  arary  $params
     * @param  string $method
     * @return array
     */
    public function apiv2($path, $params = array(), $method = 'GET', $nocache = false, $lifetime=6, $api_version=1)
    {
        // Add lang to any request.
        $params['lang'] = Lang::getLocale();

        // Full URL to request pcms.
        // K.Mol do customize request url to get data from PCMS V2 api.
        if ($api_version == 2)
        {
            $requestUrl = $this->url.'/v2/'.$this->appKey.'/'.$path;
        }
        else
        {
            $requestUrl = $this->url.'/'.$this->appKey.'/'.$path;
        }

        // Get method should add traling query string.
        if (strcasecmp($method, 'GET') == 0)
        {
            $params = http_build_query($params);

            if ( ! empty($params))
            {
                if (strpos($requestUrl, '?') !== false)
                {
                    $requestUrl .= '&'.$params;
                }
                else
                {
                    $requestUrl .= '?'.$params;
                }
            }

            $params = array();
        }

        $response = $this->makeRequestV2($requestUrl, $params, $method, $nocache,$lifetime, $path);

        if ( ! isset($response['data']) && is_array($response))
        {
            $response['data'] = array();
        }

        return $response;
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
    public  function makeRequestV2($url, array $args, $method, $nocache = false,$lifetime=6, $path)
    {
        // Using cache for specific request api.

        $keyCurl = Request::server('SERVER_NAME').'-'. preg_replace('/[^a-zA-Z\']/','', $path).'-'. md5( $url. json_encode($args) . $method);
        $keyCurl = preg_replace('/_/','',strtolower($keyCurl));

        $chk_cache = Input::get('chk_cache');
        if (($response = ElastiCache::getResult($keyCurl, $url)) && ! $nocache && strtolower($method) == 'get')
        {
            if (!empty($chk_cache)) {
                echo 'From Cache <br>';
                echo 'keyCurl = ' . $keyCurl . ' <br>';
                echo 'Method = ' . $method . ' <br>';
                //s($response);
            }
            return $response;
        }

        if (!empty($chk_cache)) {
            echo 'From API <br>';
            echo 'keyCurl = ' . $keyCurl . ' <br>';
            echo 'Method = ' . $method . ' <br>';
        }

        if(strtolower($method) == 'get')
        {
            $curl = new Curl();
            $curl->create($url.http_build_query($args, null, '&'));
            $curl->option(CURLOPT_BUFFERSIZE, 20);
            $response = $curl->execute();
            $info = $curl->info;
            if ($info['content_type'] == 'application/json')
            {
                $response = json_decode($response, true);
            }

            Event::fire('api.request.pcms', array($method, $url, $args, $info));

            if (!isset($response['code']) && $response['code'] != 200) {
                $response['code'] = 500;
                $response['status'] = 500;
                $response['message'] = 'Can not Connect API';
            }
        }else{


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

            $opts[CURLOPT_BUFFERSIZE] = 20;
            // Requesting.
            curl_setopt_array($ch, $opts);
            $response = curl_exec($ch);

            // Returned information.
            $info = curl_getinfo($ch);

            // Include all curel progress.
            $totaltimeExec = $totaltimeExec + $info['total_time'];
            $info['total_time_execute'] = $totaltimeExec;

            // Decode json data.
            if ($info['content_type'] == 'application/json')
            {
                $response = json_decode($response, true);
            }

            // Fire event to get log.
            Event::fire('api.request.pcms', array($method, $url, $args, $info));

            curl_close($ch);
        }

        // We accept cache only GET.
        if(strtolower($method) == 'get')
        {
            ElastiCache::save($keyCurl, $response, $url, $lifetime);
        }

        return $response;
    }


}
