<?php

return array(

	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'alpha-pcmsdb-rw.itruemart-dev.ph',
			'database'  => 'itruemart_db',
			'username'  => 'itruemart_rw',
			'password'  => 'Ygvedc98',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

	),


    'redis' => array(

        'cluster' => false,

        'default' => array(
            'host'     => 'alpha-elasticache-rw.itruemart-dev.ph',
            'port'     => 6379,
            'database' => 0,
        ),

    ),

);
