<?php

return [
	/*
	  Default connection name
	*/

	  'default' => env('RESTTEST_CONNECTION', 'default'),

	  'connections' => [
	  	'default' => [
	  		'hosts' => [env('RESTTEST_HOST', '127.0.0.1')],
	  		'port' => [env('RESTTEST_PORT', 8080)],
	  		'use_ssl' => [env('RESTTEST_USESSL', false)],
	  		'username' => [env('RESTTEST_USERNAME', 'demo')],
	  		'password' => [env('RESTTEST_PASSWORD', 'secret')],
	  	],
	  ],

	/*
		Logging
	*/

		'logging' => env('RESTTEST_LOGGING', true),

];