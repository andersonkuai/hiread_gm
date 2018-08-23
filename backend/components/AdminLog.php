<?php
namespace backend\components;

use function GuzzleHttp\Psr7\str;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

class AdminLog
{
    public static function write($event)
    {
        // 排除日志表自身,没有主键的表不记录（没想到怎么记录。。每个表尽量都有主键吧，不一定非是自增id）
        if($event->sender instanceof \common\models\AdminLog || !$event->sender->primaryKey()) {
            return;
        }
        // 显示详情有待优化,不过基本功能完整齐全
        if ($event->name == ActiveRecord::EVENT_AFTER_INSERT) {
            $action = 'insert';
            $description = "%s新增了表%s %s:%s的%s";
        } elseif($event->name == ActiveRecord::EVENT_AFTER_UPDATE) {
            $action = 'update';
            $description = "%s修改了表%s %s:%s的%s";
        } else {
            $action = 'delete';
            $description = "%s删除了表%s %s:%s%s";
        }
        if (!empty($event->changedAttributes)) {
            $desc = '';
            foreach($event->changedAttributes as $name => $value) {
                $desc .= $name . ' : ' . $value . '=>' . $event->sender->getAttribute($name) . ',';
            }
            $desc = substr($desc, 0, -1);
        } else {
            $desc = '';
        }
        $userName = Yii::$app->user->identity->username;
        $tableName = $event->sender->tableSchema->name;
        $str = is_array($event->sender->getPrimaryKey()) ? json_encode($event->sender->getPrimaryKey()) : $event->sender->getPrimaryKey();
        $description = sprintf($description, $userName, $tableName, $event->sender->primaryKey()[0], $str, $desc);

        $route = Url::to();
        $userId = Yii::$app->user->id;
        $ip = Yii::$app->request->userIP;
        $data = [
            'action' => $action,
            'route' => $route,
            'table' => $tableName,
            'user_name' => $userName,
            'description' => $description,
            'user_id' => $userId,
            'ip' => $ip,
            'created_at'   => time(),
        ];
        $model = new \common\models\AdminLog();
        $model->setAttributes($data);
        $model->save();
    }
}
