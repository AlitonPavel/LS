<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	
        'name'=>'Корпоративный портал',
    
        'language'=>'ru',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
                
                'authManager' => array(
                    // Будем использовать свой менеджер авторизации
                    'class' => 'LSPhpAuthManager',
                    // Роль по умолчанию. Все, кто не админы, модераторы и юзеры — гости.
                    'defaultRoles' => array('guest'),
                ),
            
		'user'=>array(
                    'class' => 'WebUser',
                    'allowAutoLogin'=>true,
		),
            
                'errorManager' => array(
                    'class' => 'application.components.LSErrorManager',
                ),
            
                'security' => array(
                    'class' => 'application.components.LSSecurity',
                ),

		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
                        'showScriptName' => false,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
            
                'clientScript' => array(
                    'coreScriptPosition' => CClientScript::POS_HEAD,
                    'packages' => array(
                        'ls_libs' => array(
                            'baseUrl' => Yii::app()->request->basePath . '/js',
                            'js' => array(
                                'jquery-3.3.1.min.js',
                                'jqwidgets/localization.js',
                                'ls.js',
                                'jqwidgets/jqx-all.js',
                                'jqwidgets/globalization/globalize.js',
                                'jqwidgets/globalization/globalize.culture.ru-RU.js',
                            ),
                            'css' => array(
                                'jqwidgets/styles/jqx.base.css',
//                                'jqwidgets/styles/jqx.ui-sunny.css',
                            ),
                        ),
                    ),
                ),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'pasha-rogov@yandex.ru',
	),
);
