<?php

// Production
if($_SERVER['HTTP_HOST'] == 'www.itruemart.com')
{

    return array(
        "curlRequest" => 5,
        "itmUrl" => "www.itruemart.com",
        "pcmsUrl" => "http://pcms.itruemart.com",
        "scmUrl" => "http://supplychain.itruemart.com",
        "mysql" => array(
            "username" => "itm_monitor",
            "password" => "jufoe6Tyh#",
            "host" => 'mysql:host=localhost;dbname=information_schema;charset=utf8',
            "dbname" => "information_schema"
        )

    );
}
// Development
elseif($_SERVER['HTTP_HOST'] == 'www.dev.itruemart.com')
{

    return array(
        "curlRequest" => 5,
        "itmUrl" => "www.dev.itruemart.com",
        "pcmsUrl" => "http://pcms.dev.itruemart.com",
        "scmUrl" => "http://supplychain.dev.itruemart.com",
        "mysql" => array(
            "username" => "itruemart2014_rw",
            "password" => "Ybkpl86703",
            "host" => 'mysql:host=192.168.224.11;dbname=information_schema;charset=utf8',
            "dbname" => "information_schema"
        )

    );
}
// Alpha
elseif($_SERVER['HTTP_HOST'] == 'www.alpha.itruemart.com' || $_SERVER['HTTP_HOST'] == "alpha.itruemart.com")
{

    return array(
        "curlRequest" => 5,
        "itmUrl" => "http://www.alpha.itruemart.com",
        "pcmsUrl" => "http://pcms.alpha.itruemart.com",
        "scmUrl" => "http://supplychain.alpha.itruemart.com",
        "mysql" => array(
            "username" => "itm_monitor",
            "password" => "jufoe6Tyh#",
            "host" => 'mysql:host=192.168.225.2;dbname=information_schema;charset=utf8',
            "dbname" => "information_schema"
        )

    );
}else{
    // Default Neng PC
    return array(
        "curlRequest" => 5,
        "itmUrl" => "http://www.itruemart-2014.loc",
        "pcmsUrl" => "http://pcms.dev.itruemart.com",
        "scmUrl" => "http://supplychain.dev.itruemart.com",
        "mysql" => array(
            "username" => "root",
            "password" => "root",
            "host" => 'mysql:host=localhost;dbname=pcms3;charset=utf8',
            "dbname" => "pcms3"
        )

    );
}