<?php

return array(

    'connections' => array(

        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'pcmsdb-rw.itruemart.ph',
            'database'  => 'itruemart_db',
            'username'  => 'itruemart_rw',
            'password'  => 'EsxcgU65Mb',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

    ),

        'redis' => array(
            'cluster' => false,
            /*'default' => array('host' => '192.168.120.160', 'port' => 6382, 'database' => 0),*/
            'default' => array(
                'host'     => 'elasticache-rw.itruemart.ph',
                'port'     => 6379,
                'database' => 0,
            ),
        ),
);