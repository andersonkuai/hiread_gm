<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_extensive".
 *
 * @property integer $ID
 * @property integer $CourseId
 * @property integer $UnitId
 * @property string $Title
 * @property string $Video
 * @property string $Poster
 * @property integer $OpenDay
 */
class HiConfExtensive extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_extensive';
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
            [['CourseId', 'UnitId', 'OpenDay'], 'integer'],
            [['Title'], 'string', 'max' => 180],
            [['Video', 'Poster'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CourseId' => '课程ID',
            'UnitId' => '课程单元ID',
            'Title' => '泛读视频标题',
            'Video' => '视频名称',
            'Poster' => '泛读视频封面',
            'OpenDay' => 'Open Day',
        ];
    }
    /**
     * 批量插入数据
     */
    public function insertAll($data)
    {
        self::getDb()->createCommand()->batchInsert(self::tableName(),['CourseId','Title','Video','Poster','OpenDay'],$data)->execute();
        return $data;
    }
    /**
     * 关联查询泛读视频题目列表
     */
    public function getExtensiveTopicList()
    {
        return $this->hasMany(HiConfExtensiveTopicList::className(),['ExtId' => 'ID']);
    }
}
