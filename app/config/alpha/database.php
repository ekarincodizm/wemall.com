<?php

return array(

    'connections' => array(

        'mysql' => array(
            'driver'    => 'mysql',
            'host'      => '192.168.225.12',
            'database'  => 'itruemart_db',
            'username'  => 'itruemart_rw',
            'password'  => 'HM84qF12345',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ),

    ),

    'redis' => array(
        'cluster' => false,
        'default' => array('host' => '192.168.225.2', 'port' => 6379, 'database' => 0),
    ),

);