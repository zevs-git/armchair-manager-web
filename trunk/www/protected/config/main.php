<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'MagicRest monitoring',
    'language' => 'ru',
    //'theme' => 'abound',
    // preloading 'log' component
    'preload' => array('log'),
    'defaultController' => 'DeviceStatus/admin',
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.helpers.*',
        'application.extensions.EGeoNameService.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.modules.rights.components.dataproviders.*',
        'application.modules.rights.*',
        'application.modules.rights.models.*',
        'application.modules.rights.components.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'qwertyqwerty',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'bootstrap.gii',),
        ),
        'user',
        'rights',
    ),
    // application components
    'components' => array(
        'user' => array(
            'class' => 'RWebUser',
            'allowAutoLogin' => true,
        ),
        'email' => array(
            'class' => 'application.extensions.email.Email',
            'delivery' => 'php',
        ),
        'authManager' => array(
            'class' => 'RDbAuthManager',
            'defaultRoles' => array('Guest'),
        ),
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                'settings' => 'settings/index',
                'settings/<device_imei:\d+>\.bin' => 'settings/device',
            ),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=chair.teletracking.ru;dbname=collector',
            'emulatePrepare' => true,
            'username' => 'collector',
            'password' => 'W5mxr50P475t50s',
            'charset' => 'utf8',
            'tablePrefix' => '',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
        'clientScript' => array(
            'class' => 'ext.NLSClientScript',
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'v.zelensky@ubki.ua',
    ),
);
