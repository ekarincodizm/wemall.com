<?php

class ServiceProvider{

    protected $config;
    public static $CURL_OPTS = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => 1,
        //CURLOPT_CONNECTTIMEOUT => 10,
        //CURLOPT_TIMEOUT        => 15,
        //CURLOPT_USERAGENT      => 'pcms-0.1',
        //CURLOPT_ENCODING       => ''
    );

    public function __construct($config){
        $this->config = $config;
    }

    public function callPCMSByPkey(){
        $profiler = new Profiler();
        $profiler->start();

        $pkey = !empty($_GET["pkey"])? $_GET["pkey"] : "2631396112433";

        $baseUrl = $this->config["pcmsUrl"];
        $uri = "/api/45311375168544/products/".$pkey;
        $res = $this->makeRequest($baseUrl.$uri, array(), "GET");

        $profiler->stop();
        if(!empty($res["code"]) && $res["code"] == 200){
            return $profiler->show();
        }else{
            return 0;
        }
    }

    public function callSCMbyInventoryId(){

        $profiler = new Profiler();
        $profiler->start();

        $invId = !empty($_GET["inventory_id"])? $_GET["inventory_id"] : "36759";
        $baseUrl = $this->config["scmUrl"];
        $uri = "/api_v2/check_stock?inventory_id=" . $invId;

        $res = $this->makeRequest($baseUrl.$uri, array(), "GET");

        $profiler->stop();
        if(!empty($res["jsonData"]["statusCode"]) && $res["jsonData"]["statusCode"] == 200){
            return $profiler->show();
        }else{
            return 0;
        }
    }

    public function callItmFront(){
        $profiler = new Profiler();
        $profiler->start();

        $pkey = !empty($_GET["pkey"])? $_GET["pkey"] : "2631396112433";
        $baseUrl = $this->config["itmUrl"];
        $uri = "/products/".$pkey.".html";
        $res = $this->makeRequest($baseUrl.$uri, array(), "GET", true);

        $profiler->stop();
        if(!empty($res["http_code"]) && $res["http_code"] == 200){
            return $profiler->show();
        }else{
            return 0;
        }
    }

    public function doQueryToDatabase(){

        try{
            $profiler = new Profiler();
            $profiler->start();

            $db = new PDO($this->config["mysql"]["host"],
                $this->config["mysql"]["username"],
                $this->config["mysql"]["password"],
                array(
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );

            $stmt = $db->prepare("SELECT * FROM carts LIMIT 1");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            $stmt = null;
            $db = null;

            $profiler->stop();
            return $profiler->show();
        }catch(Exception $e){
            echo $e->getMessage()."<br/>";
            return 0;
        }

    }

    public function getConcurrentUserOnDb(){
        try{
            $res = array();

            $db = new PDO($this->config["mysql"]["host"],
                $this->config["mysql"]["username"],
                $this->config["mysql"]["password"],
                array(
                    PDO::ATTR_EMULATE_PREPARES => false,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );

            $stmt = $db->prepare("SELECT user, db, count(*) AS numb FROM information_schema.processlist WHERE db='".$this->config["mysql"]["dbname"]."' group by user,db;");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $res["processlist_user_db"] = array();
            if(!empty($rows[0])){
                $res["processlist_user_db"] = $rows[0];
            }

            $stmt = $db->prepare("select count(*) AS numb from information_schema.processlist;");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $res["processlist_all"] = array();
            if(!empty($rows[0])){
                $res["processlist_all"] = $rows[0];
            }

            $stmt = $db->prepare("show variables like '%max_connections%';");
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $res["max_connection"] = array();
            if(!empty($rows[0])){
                $res["max_connection"] = $rows[0];
            }

            $stmt->closeCursor();
            $stmt = null;
            $db = null;

            return $res;
        }catch(Exception $e){
            echo $e->getMessage();
        }
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
    protected function makeRequest($url, array $args, $method="GET", $returnCurlInfo = false)
    {

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

        if($returnCurlInfo){
            return $info;
        }

        // Decode json data.
        if ($info['content_type'] == 'application/json')
        {
            $response = json_decode($response, true);
        }

        curl_close($ch);

        return $response;
    }

    public function alert($data){
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        die();
    }

}