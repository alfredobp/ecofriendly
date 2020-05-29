<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$log = require __DIR__ . '/log.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        // '@uploads' => '@app/web/uploads',
        // '@uploadsUrl' => '/uploads',
        '@uploads' => 'https://s3.eu-west-3.amazonaws.com/ecofriendly/',
        '@img' => '@app/web/img',
        '@imgUrl' => '/img',
        '@perfil' => 'index.php?r=usuarios/%2Fview&id='
    ],
    'language' => 'es-ES',
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    // 'authUrl'=>'https://www.facebook.com/dialog/oauth?display-popup',
                    'clientId' => '1084329348614527',
                    'clientSecret' => '5e6d9158d0b287efb6e5267ca81827a0',
                    'attributeNames' => ['email'],
                ],
            ],

        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '3oC7MNI1jvr_ayRVzGm1ykvnKATTOmTL',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Usuarios',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,

            // comment the following array to send mail using php's mail function:
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => $params['smtpUsername'],
                'password' => getenv('SMTP_PASS'),
                'port' => '587',
                'encryption' => 'tls',
            ],

        ],

        'log' => $log,
        'db' => $db,
        'formatter' => [
            'timeZone' => 'Europe/Madrid',
        ],

        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => false,
            'rules' => [

                'usuarios/resetpass' => 'usuarios/resetpass',
                'usuarios/view/<id>' => 'usuarios/view',
                'acciones-retos/view/<id>' => 'accionesretos/view',
                
            ],
        ],

    ],
    'container' => [
        'definitions' => [
            'yii\grid\ActionColumn' => ['header' => 'Acciones'],
            'yii\widgets\LinkPager' => 'yii\bootstrap4\LinkPager',
            'yii\grid\DataColumn' => 'app\widgets\DataColumn',
            'yii\grid\GridView' => ['filterErrorOptions' => ['class' => 'invalid-feedback']],
        ],
    ],
    'modules' => [
        'social' => [
            // the module class
            'class' => 'kartik\social\Module',

            // the global settings for the disqus widget
            'disqus' => [
                'settings' => ['shortname' => 'DISQUS_SHORTNAME'] // default settings
            ],

            // the global settings for the facebook plugins widget
            'facebook' => [
                'appId' => 'FACEBOOK_APP_ID',
                'secret' => 'FACEBOOK_APP_SECRET',
            ],

            // the global settings for the google plugins widget
            'google' => [
                'pageId' => 'UA-162197120-1',
                'clientId' => '865243706455-moll7c8b0nacm8h6s7o42mgufrff05hj.apps.googleusercontent.com',
            ],

            // the global settings for the google analytic plugin widget
            'googleAnalytics' => [
                'id' => 'TRACKING_ID',
                'domain' => 'TRACKING_DOMAIN',
            ],

            // the global settings for the twitter plugins widget
            'twitter' => [
                'screenName' => 'elpais'
            ],
        ],
        // your other modules
    ],

    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
        'generators' => [
            'crud' => [ // generator name
                'class' => 'yii\gii\generators\crud\Generator', // generator class
                'templates' => [ // setting for out templates
                    'default' => '@app/templates/crud/default', // template name => path to template
                ],
            ],
        ],
    ];
}

return $config;
