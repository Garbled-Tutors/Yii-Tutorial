<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=tutorial',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'sqlpass',
			'charset' => 'utf8',
		),
		'testdb'=>array(
			// When adding multiple databases this line is nessisary. Yii assumes the class name when 'db'
			// is the connectionID, otherwise the class must be specified
			'class'=>'system.db.CDbConnection',  

			'connectionString' => 'mysql:host=localhost;dbname=testtutorial',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'sqlpass',
			'charset' => 'utf8',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);
