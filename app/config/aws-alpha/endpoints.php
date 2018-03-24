<?php

return array(

    'pcms' => array(
        'url'    => 'http://alpha-pcms.itruemart-dev.ph/api',
        'apiPcms' => 'http://alpha-pcms.itruemart-dev.ph/api',
        'appKey' => '45311375168544'
    ),

    'itruemart' => array(
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
        'agentUrl' => 'http://tma.truelife.com/tma/truecrm_agent/agent.aspx',
        'endpoint' => 'http://truecardbn.truelife.com/truecardsrv/services/api.aspx'
    ),

    'itruemartFront' => 'http://www.dev.itruemart.ph',

    //use in thankyou page.
    'basePrefixUrlWeb' => "www\.dev\.",
    'basePrefixUrlMobile' => "m.dev.",

    /** SeletedSiteFilter */
    "mobilePrefixRegex" => "/alpha-m\./",
    "webPrefixRegex" => "/alpha-www\./",
    "mobilePrefix" => "alpha-m.",
    "webPrefix" => "alpha-www.",

    "support_itruemart" => array(
        "url" => "//support.itruemart.com"
    )
);