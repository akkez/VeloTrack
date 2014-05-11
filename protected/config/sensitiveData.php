<?php

return array(
	'modules'    => array(
		'gii' => array(
			'password' => 'veryStrongPassword',
		),
	),
	'components' => array(
		'db' => array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=dbname',
			'emulatePrepare'   => true,
			'username'         => 'user',
			'password'         => 'veryStrongPassword',
			'charset'          => 'utf8',
		),
	),

	'params'     => array(
		'passwordSalt' => 'verySecretSalt',
	),
);