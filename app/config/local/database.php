<?php

return array(
	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => '127.0.0.1',
			'database'  => 'larabooster',
			'username'  => 'root',
			'password'  => 'root',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

	),

	'redis' => array(

		'cluster' => false,

		'default' => array(
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0,
		),

	),

);
