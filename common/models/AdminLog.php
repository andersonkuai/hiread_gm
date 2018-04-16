<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "admin_log".
 *
 * @property integer $id
 * @property string $route
 * @property string $description
 * @property integer $created_at
 * @property integer $user_id
 * @property string $ip
 * @property string $table
 * @property string $user_name
 * @property string $action
 */
class AdminLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['created_at', 'user_id'], 'integer'],
            [['route', 'ip', 'table', 'user_name'], 'string', 'max' => 255],
            [['action'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route' => '操作通道',
            'description' => '具体描述',
            'created_at' => '创建时间',
            'user_id' => '操作人id',
            'ip' => 'Ip',
            'table' => '表名',
            'user_name' => '用户账号',
            'action' => '操作类型',
        ];
    }
}
