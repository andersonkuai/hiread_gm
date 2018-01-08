<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        'db' => [
//            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=192.168.1.19;dbname=management',
//            'username' => 'ylmg',
//            'password' => 'ylmg@1qazxsw2',
//            'charset' => 'utf8',
//        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=management',
            'username' => 'root',
            'password' => 'WjCn0hAe8BDddB08',
            'charset' => 'utf8',
        ],
        'wnmall' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.1.19;dbname=wnmall',
            'username' => 'ylmg',
            'password' => 'ylmg@1qazxsw2',
            'charset' => 'utf8',
        ],
        'ylmgSupport' => [
            'class' => 'common\classes\ylmg\YlmgSupportDb',
        ],
    ],
    'language' => 'zh-CN',
];
