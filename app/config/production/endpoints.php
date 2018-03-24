<?php

return array(

    'pcms' => array(
        'url'    => 'http://pcms.itruemart.ph/api',
        'appKey' => '45311375168544',
        /*'apiPcms' => 'http://webapi.itruemart.com/api',
        'webApiKey' => 'gCX5lMv0ZlulP-Oy_6TDMMDBfA_gliX3c5ITy1-ERWM',*/
        'apiPcms'    => 'http://pcms.itruemart.ph/api',
        'webApiKey' => '45311375168544',
    ),


    'itruemart' => array(
        // 'endpointUrl' => 'http://api.dev.itruemart.com/rest',
        'endpointUrl' => 'http://api.itruemart.ph/rest'
    ),

    'sso' => array(
        'app_id'      => '96',
        'secret_key'  => '69dfc3a28ab47f71ee27f50e23354edd',
        'url_auth'    => 'https://auth-platform.truelife.com',
        'url_profile' => 'https://profile-platform.truelife.com',
        'url_member'  => 'https://memberservice.truelife.com/api/proxyAPI.php',
        'url_login'   => 'https://loginservice.truelife.com',
    ),

    'truecard' => array(
        'agentUrl' => null,
        'endpoint' => 'http://truecardbn.truelife.com/truecardsrv/services/api.aspx'
    ),

    'itruemartFront' => 'http://itruemart.ph',

    //use in thankyou page.
    'basePrefixUrlWeb' => "www\.",
    'basePrefixUrlMobile' => "m.",

    /** SeletedSiteFilter */
    "mobilePrefixRegex" => "/m\./",
    "webPrefixRegex" => "/www\./",
    "mobilePrefix" => "m.",
    "webPrefix" => "www.",

    "support_itruemart" => array(
        "url" => "//support.itruemart.ph"
    )
);