<?php

return array(

	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'pcmsdb-rw.itruemart-dev.ph',
			'database'  => 'itruemart_db',
			'username'  => 'itruemart_rw',
			'password'  => 'VkdkL#456',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

	),

    'redis' => array(
        'cluster' => false,
        'default' => array(
            'host'     => 'elasticache-rw.itruemart-dev.ph',
            'port'     => 6379,
            'database' => 0,
        ),

    ),

);
