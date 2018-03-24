<?php

/**
* Perform parallel cURL request.
*
* @param array $urls Array of URLs to make request.
* @param array $options (Optional) Array of additional cURL options.
* @return mixed Results from the request (if any).
*/
function curlMultiRequest($urls, $options = array()) {
    $ch = array();
    $results = array();
    $mh = curl_multi_init();
    foreach($urls as $key => $val) {
        $ch[$key] = curl_init();
        if ($options) {
            curl_setopt_array($ch[$key], $options);
        }
        curl_setopt($ch[$key], CURLOPT_URL, $val);
        curl_multi_add_handle($mh, $ch[$key]);
    }
    $running = null;
    do {
        curl_multi_exec($mh, $running);
    }
    while ($running > 0);
    // Get content and remove handles.
    foreach ($ch as $key => $val) {
        $results[$key] = curl_multi_getcontent($val);
        curl_multi_remove_handle($mh, $val);
    }
    curl_multi_close($mh);
    return $results;
}

$result = curlMultiRequest(array('http://www.itruemart.com/', 'http://laravel.com/docs/cache'));

var_dump($result);