<?php
class Commons
{
	public static function curl($url, $params=array(), $xml=FALSE)
	{
		$ch = curl_init();
		$opts[CURLOPT_CONNECTTIMEOUT] = 10;
		$opts[CURLOPT_RETURNTRANSFER] = true;
		$opts[CURLOPT_TIMEOUT] = 3000;
		if($params)
		{
			if ($xml === TRUE) $opts[CURLOPT_HTTPHEADER] = array('Content-Type: text/xml');
			$opts[CURLOPT_POST] = true;
			$opts[CURLOPT_POSTFIELDS] = $params;
		}
		$opts[CURLOPT_URL] = $url;
		curl_setopt_array($ch, $opts);
		$result = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//echo "status=".$http_status;
		//echo $params;
		if($result === false)
		{
			//$msgError = "Can't access web service. (".$url.")";
			curl_close($ch);
			//throw new Exception($msgError, 100);
		}
		else
		{
			curl_close($ch);
		}
		return $result;
	}

    public static function globalXssClean($array)
    {
        $result = array();
        foreach ($array as $key => $value) {
            $key = strip_tags($key);

            if (is_array($value)) {
                $result[$key] = static::globalXssClean($value);
            } else {
                $result[$key] = trim(strip_tags($value));
            }
        }

        return $result;
    }

}
