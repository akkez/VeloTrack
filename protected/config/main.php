<?php

Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');

$sensitiveDataConfig = include(dirname(__FILE__) . "/sensitiveData.php");

return CMap::mergeArray(array(
	'modules'    => array(
		'gii' => array(
			'class'          => 'system.gii.GiiModule',
			'ipFilters'      => array('127.0.0.1', '::1'),
			'generatorPaths' => array(
				'bootstrap.gii',
			),
		),
	),

	'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name'       => 'VeloTrack',

	'preload'    => array('log'),

	'import'     => array(
		'application.models.*',
		'application.components.*',
		'application.components.helpers.*',
	),

	'components' => array(
		'user'         => array(
			'allowAutoLogin' => true,
		),
		'bootstrap'    => array(
			'class' => 'bootstrap.components.Bootstrap',
		),
		'urlManager'   => array(
			'urlFormat'      => 'path',
			'showScriptName' => false,
			'rules'          => array(
				'<controller:\w+>/<id:\d+>'              => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>'          => '<controller>/<action>',
				'<action:(register|login|logout)>'       => 'site/<action>',
				'<action:(registered)>'                  => 'site/page/view/<action>'
			),
		),
		'errorHandler' => array(
			'errorAction' => 'site/error',
		),
		'log'          => array(
			'class'  => 'CLogRouter',
			'routes' => array(
				array(
					'class'  => 'CFileLogRoute',
					'levels' => 'error, warning',
				),
				array(
					'class'   => 'CWebLogRoute',
					'enabled' => 'false',
					'levels'  => 'trace, info, profile',
				),
			),
		),
		'clientScript' => array(
			'packages' => array(
				'jquery'    => array(
					'baseUrl' => '//yandex.st/jquery/1.11.0/',
					'js'      => array('jquery.min.js'),
				),
				'chart'    => array(
					'baseUrl' => '/js/',
					'js'      => array('Chart.min.js'),
				),
				'yandexmap' => array(
					'baseUrl' => '//api-maps.yandex.ru/2.1/', //api-ключ не нужен, спасибо яндексу за это
					'js'      => array('?load=package.full&lang=ru-RU'),
					'depends' => array('jquery'),
				),
			),
		),
	),

	'params'     => array(
		'adminEmail' => 'velotrack@akkez.ru',
	),
), $sensitiveDataConfig);