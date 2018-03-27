<?php
return  DIRECTORY_SEPARATOR=='\\' ? [
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.1.19;dbname=management',
            'username' => 'ylmg',
            'password' => 'ylmg@1qazxsw2',
            'charset' => 'utf8',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=management',
            'username' => 'root',
            'password' => 'Kuai920706',
            'charset' => 'utf8',
        ],
        'hiread' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=hiread',
            'username' => 'root',
            'password' => 'Kuai920706',
            'charset' => 'utf8',
        ],
        'wnmall' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=192.168.1.19;dbname=wnmall',
            'username' => 'ylmg',
            'password' => 'ylmg@1qazxsw2',
            'charset' => 'utf8',
        ],
    ],
]:[
    'components' => [
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
