<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
// defined('YII_ENV') or define('YII_ENV', '1');//本地
// defined('YII_ENV') or define('YII_ENV', '2');//测试服
defined('YII_ENV') or define('YII_ENV', '3');//正式服

require(__DIR__ . '/../../vendor/autoload.php');
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(__DIR__ . '/../../common/config/main.php'),
    require(__DIR__ . '/../../common/config/main-local.php'),
    require(__DIR__ . '/../config/main.php'),
    require(__DIR__ . '/../config/main-local.php')
);
$config['language'] = isset($_COOKIE['language']) ? $_COOKIE['language'] : 'zh-CN';
(new yii\web\Application($config))->run();
