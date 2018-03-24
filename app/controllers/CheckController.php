<?php set_time_limit(0);

class CheckController extends BaseController {

    public function getEnv()
    {
        return App::environment();
    }

    public function getResolve()
    {
        $services = array(
            'pcms' => array(
                'name'   => 'PCMS',
                'url'    => Config::get('endpoints.pcms.url'),
                'method' => 'ping'
            ),
            'itruemart' => array(
                'name'   => 'iTruemart',
                'url'    => Config::get('endpoints.itruemart.endpointUrl'),
                'method' => 'ping'
            ),
            'truecard-agent' => array(
                'name'   => 'True Card Agent API',
                'url'    => Config::get('endpoints.truecard.agentUrl'),
                'method' => 'ping'
            ),
            'truecard-api' => array(
                'name'   => 'True Card Endpoint',
                'url'    => Config::get('endpoints.truecard.endpoint'),
                'method' => 'ping'
            ),
            'sso-auth' => array(
                'name'   => 'SSO Authenticate',
                'url'    => Config::get('endpoints.sso.url_auth').'/online/getAll',
                'method' => 'curl'
            ),
            'sso-profile' => array(
                'name'   => 'SSO Profile',
                'url'    => Config::get('endpoints.sso.url_profile').'/filter',
                'method' => 'curl'
            ),
            'sso-member' => array(
                'name'   => 'SSO Member',
                'url'    => Config::get('endpoints.sso.url_member'),
                'method' => 'curl'
            ),
            // 'sso-login' => array(
            //     'name'   => 'SSO Login',
            //     'url'    => Config::get('endpoints.sso.url_login'),
            //     'method' => 'curl'
            // ),
        );

        // foreach ($services as $key => $service)
        // {
        //     $hostname = parse_url($service['url'], PHP_URL_HOST);

        //     $pingtime = static::ping($hostname);

        //     $services[$key]['status'] = ($pingtime >= 0) ? 'OK' : 'FAILED';
        //     $services[$key]['time']   = $pingtime;
        // }

        foreach ($services as $key => $service)
        {

            if($service['method'] == 'ping')
            {
                $hostname = parse_url($service['url'], PHP_URL_HOST);
                $pingtime = static::ping($hostname);

                $services[$key]['status'] = ($pingtime >= 0) ? 'OK' : 'FAILED';
                $services[$key]['time']   = $pingtime;

            }else{

                $curlInfo = static::call($service['url']);
                $services[$key]['status'] = ($curlInfo['http_code'] >= 200 AND $curlInfo['http_code'] < 300 ) ? 'OK' : 'FAILED';
                $services[$key]['time']   = $curlInfo['total_time'];

            }


        }

        return View::make('check.resolve', compact('services'));
    }

    public static function ping($domain, $port = 80, $timeout = 30)
    {
        $starttime = microtime(true);
        $file      = @fsockopen ($domain, $port, $errno, $errstr, $timeout);
        $stoptime  = microtime(true);
        $status    = 0;

        if ( ! $file) $status = -1;  // Site is down
        else
        {
            fclose($file);
            $status = ($stoptime - $starttime) * 1000;
            $status = floor($status);
        }

        return $status;
    }

    public static function call($url, $data = array(), $method = 'POST')
    {
        $ch = curl_init($url);

        $data = http_build_query($data);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_exec($ch);

        //$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $info = curl_getinfo($ch);
        curl_close($ch);

        return $info;
        //return ($httpCode >= 200 && $httpCode < 300);
    }

}