<?php

return array(

    'pcms' => array(
        'url'    => 'http://www.pcms.local/api',
        'apiPcms' => 'http://webapi.itruemart.ph/api',
        'appKey' => '45311375168544'
    ),
    
    'itruemart' => array(
        'endpointUrl' => 'http://api.itruemart.ph/rest'
    ),
//
//    'sso' => array(
//        'app_id'      => '96',
//        'secret_key'  => '69dfc3a28ab47f71ee27f50e23354edd',
//        'url_auth'    => 'https://auth-platform.truelife.com',
//        'url_profile' => 'https://profile-platform.truelife.com',
//        'url_member'  => 'https://memberservice.truelife.com/api/proxyAPI.php',
//        'url_login'   => 'https://loginservice.truelife.com',
//        "avartar" => "//core-data.trueid.net/{true_id}/avatar?key=1&w=78&h=78"
//    ),

    'truecard' => array(
        'agentUrl' => 'http://tma.truelife.com/tma/truecrm_agent/agent.aspx',
        'endpoint' => 'http://truecardbn.truelife.com/truecardsrv/services/api.aspx'
    ),

    'itruemartFront' => 'http://itruemart.ph',
    'weloveshipping_url' => "http://www.weloveshopping.com/",
    'truestore_url' => "http://store.truecorp.co.th/",
    "cybersource_url" => "http://www.cybersource.com/",
    "dragonpay_url" => "http://www.dragonpay.ph/",

    //use in thankyou page.
    'basePrefixUrlWeb' => "www\.",
    'basePrefixUrlMobile' => "m.",
    
    /** SeletedSiteFilter */
    "mobilePrefixRegex" => "/m\./",
    "webPrefixRegex" => "/www\./",
    "mobilePrefix" => "m.",
    "webPrefix" => "www."
     
);



