<?php namespace TrueCard;

use Event, Input, CachePage;

class TrueCard {

    /**
     * Agent URL.
     *
     * @var string
     */
    protected $agentUrl = 'http://tma.truelife.com/tma/truecrm_agent/agent.aspx';

    /**
     * Endpoint of agent api.
     *
     * @var string
     */
    protected $endpoint = 'http://truecardbn.truelife.com/truecardsrv/services/api.aspx';

    /**
     * CURL default options.
     *
     * @var array
     */
    public static $CURL_OPTS = array(
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,
        CURLOPT_USERAGENT      => 'truecard-0.1',
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

    public function setAgentUrl($url)
    {
        $this->agentUrl = $url;
    }

    public function setEndpoint($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function api($method, $params = array())
    {
        $params = http_build_query($params);

        if ($this->agentUrl)
        {
            $url = $this->agentUrl.'?apiUrl='.$this->endpoint.'&method='.$method.'&'.$params;
        }
        else
        {
            $url = $this->endpoint.'?method='.$method.'&'.$params;
        }

        return $this->makeRequest($url, array(), 'GET');
    }

    public function getInfoByThaiId($thaiId)
    {
        return $this->api('get_card_information', array(
            'thaiid' => $thaiId
        ));
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

        if ($response = CachePage::getResult($keyCurl, $url))
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
        CachePage::save($keyCurl, $response, $url, 6);

        // Decode json data.
        if ($info['content_type'] == 'application/json')
        {
            $response = json_decode($response, true);
        }

        // Fire event to get log.
        Event::fire('api.request.truecard', array($method, $url, $args, $info));

        return new Process($response, $info['content_type']);
    }

}