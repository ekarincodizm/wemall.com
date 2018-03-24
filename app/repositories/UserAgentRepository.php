<?php

use ScientiaMobile\WurflCloud\Config as WurflConfig;
use ScientiaMobile\WurflCloud\Cache\Null;
use ScientiaMobile\WurflCloud\Cache\Cookie;
use ScientiaMobile\WurflCloud\Client;

class UserAgentRepository implements UserAgentRepositoryInterface {
    protected $pcms;

    public function __construct(){
        $this->pcms = App::make("pcms");
    }

    /**
     * Description: try getting user agent data from PCMS first. If it doesn't then get form WURFL api.
     * @return array
     */
    public function getUserAgent() {

        $param = array(
            "user_agent" => Request::server('HTTP_USER_AGENT')
        );
        $agentInfo = $this->pcms->apiv2("user-agent", $param);

        if(!empty($agentInfo["code"]) && $agentInfo["code"] == 200 && !empty($agentInfo["data"])){
            return $agentInfo["data"];
        }else{
            $agentInfo = $this->_callWURFL();
            $agentInfo = $this->_saveUserAgent($agentInfo);
            return $agentInfo;
        }
    }

    /**
     * Description: try getting user agent width from PCMS first. If it doesn't then get form WURFL api.
     * @return float
     */
    public function getUserAgentWidth() {

        $param = array(
            "user_agent" => Request::server('HTTP_USER_AGENT')
        );
        // $method = 'GET', $nocache = false, $lifetime=6
        $agentInfo = $this->pcms->apiv2("user-agent", $param,'GET',false,10);
        if(!empty($agentInfo["code"]) && $agentInfo["code"] == 200 && !empty($agentInfo["data"]["screen_width"])){
            return (float)$agentInfo["data"]["screen_width"];
        }else{
            $agentInfo = $this->_callWURFL();
            $agentInfo = $this->_saveUserAgent($agentInfo);
            return (float)$agentInfo["screen_width"];
        }
    }

    /**
     * Description: try getting user agent width from Cache first. If it doesn't then get form WURFL api.
     * @return float
     */
    public function getUserAgentWidthCache() {

        $UACacheKey = "useragentcachekey";
        $userAgentKey = Request::server('HTTP_USER_AGENT');

        if( $UAbuffer = ElastiCache::getResult($UACacheKey) ){
            if(!empty($UAbuffer[$userAgentKey])){
                $deviceInfo = $UAbuffer[$userAgentKey];
                return (float)$deviceInfo["screen_width"];
            }
        }

        $agentInfo = $this->_callWURFL();

        $this->_saveUserAgent($agentInfo);
        $agentInfo = $this->pcms->apiv2("user-agent/all", array());

        if(!empty($agentInfo["code"]) && $agentInfo["code"] == 200 && !empty($agentInfo["data"])){
            $UAbuffer = array();
            foreach($agentInfo["data"] as $ua){
                $UAbuffer[$ua["user_agent"]] = $ua;
            }
            ElastiCache::save($UACacheKey, $UAbuffer, '', 60*24);
            if(!empty($UAbuffer[$userAgentKey])){
                $deviceInfo = $UAbuffer[$userAgentKey];
                return (!empty($deviceInfo["screen_width"]) && $deviceInfo["screen_width"] != 0)? (float)$deviceInfo["screen_width"]: null;
            }
        }

        return null;
    }

    private function _callWURFL() {
        require_once __DIR__ . '/../libraries/WurflCloudClient/src/autoload.php';

        try {
            // Create a WURFL Cloud Config
            $config = new WurflConfig();

            // Set your API Key here
            $config->api_key = Config::get("wurfl.apiKey");

            // Create a WURFL Cloud Client
            $client = new Client($config, new Null());

            // Detect the visitor's device
            $client->detectDevice();

            return $client->capabilities;
        } catch (Exception $e) {
            return null;
        }
    }

    private function _saveUserAgent($agentInfo = array()){
        $data = array();
        $data["os"] = !empty($agentInfo["device_os"])? $agentInfo["device_os"] : "";
        $data["brand"] = !empty($agentInfo["brand_name"])? $agentInfo["brand_name"]: "";
        $data["model"] = !empty($agentInfo["model_name"])? $agentInfo["model_name"] : "";
        $data["screen_width"] = !empty($agentInfo["physical_screen_width"])? $agentInfo["physical_screen_width"] : 0;
        $data["screen_height"] = !empty($agentInfo["physical_screen_height"])? $agentInfo["physical_screen_height"] : 0;
        $data["user_agent"] = Request::server('HTTP_USER_AGENT');

        $res = $this->pcms->apiv2("user-agent/create", $data, "POST");

        if(!empty($res["code"]) && $res["code"] == 200 && !empty($res["data"])){
            return $res["data"];
        }else{
            //In case of error. We have to convert mm. to cm. by these code.
            //$data["screen_width"] = $data["screen_width"]/10;
            //$data["screen_height"] = $data["screen_height"]/10;
            return $data;
        }

    }

}
