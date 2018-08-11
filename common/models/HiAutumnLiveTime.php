<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_autumn_live_time".
 *
 * @property integer $id
 * @property integer $level
 * @property integer $week
 * @property string $time
 * @property integer $count
 */
class HiAutumnLiveTime extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_autumn_live_time';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('hiread');
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'week', 'count'], 'integer'],
            [['time'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => '等级',
            'week' => '周几',
            'time' => '外教直播时间段',
            'count' => '人数上限',
        ];
    }
}
