<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_extensive_topic_list".
 *
 * @property integer $ID
 * @property integer $ExtId
 * @property string $Questions
 * @property integer $Min
 * @property integer $Sec
 */
class HiConfExtensiveTopicList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_extensive_topic_list';
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
            [['ExtId', 'Min', 'Sec'], 'integer'],
            [['Questions'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ExtId' => '泛读ID',
            'Questions' => '跳出题目ID',
            'Min' => '分',
            'Sec' => '秒',
        ];
    }
    /**
     * 批量插入数据
     */
    public function insertAll($data)
    {
        self::getDb()->createCommand()->batchInsert(self::tableName(),['ExtId','Questions','Min','Sec'],$data)->execute();
        return $data;
    }
}
