<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
	'language' => 'de-DE',
	'modules' => [
		'gridview' =>  [
			'class' => '\kartik\grid\Module'
		]
	],
    'timeZone' => 'Europe/Vienna',
    'components' => [
        'request' => [
			'baseUrl' => '/erp',
            'cookieValidationKey' => 'sdhfdsjf df$%^$^cdsfsdffd',
        ],
		'view' => [
			'theme' => [
				'pathMap' => [
					'@app/views' => '@app/themes/yellow'
				],
			],
		],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		'urlManager' => [
			'baseUrl' => '/erp',
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
				'login' => 'site/login',
                'site/questionnaire/<bezeichnung:.+>/<groupId:\d+>/<langId:\w+>' => 'site/questionnaire',
				'question/<id:\d+>/aliases' => 'question/aliases',
				'question/<id:\d+>/delete-alias/<alid:\d+>' => 'question/delete-alias',
				'bank/<bankId:\w+>/codes' => 'bank/codes',
				'bank/<bankId:\w+>/lock' => 'bank/lock',
				'bank/<bankId:\w+>/lock-unlock' => 'bank/lock-unlock',
				'bank/<bankId:\w+>/statistic' => 'bank/statistic',
				'bank/<bankId:\w+>/delete-code/<cid:\d+>' => 'bank/delete-code',
				'bank/placeholders/set-alias' => 'bank/set-alias',
				'user-text/index/<type:\w+>' => 'user-text/index',
				'user-text/create/<type:\w+>' => 'user-text/create',
				'user-text/update/<type:\w+>' => 'user-text/update',
                'language/<langId:\d+>/translations' => 'language/translations',
			]
		],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;