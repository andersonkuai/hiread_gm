<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_course_package".
 *
 * @property integer $ID
 * @property integer $CourseId
 * @property string $FileName
 * @property string $FileSize
 */
class HiConfCoursePackage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_course_package';
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
            [['CourseId'], 'integer'],
            [['FileName'], 'string', 'max' => 50],
            [['FileSize'], 'string', 'max' => 10],
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
            'FileName' => '文件名称',
            'FileSize' => '文件大小',
        ];
    }
    /**
     * 批量插入数据
     */
    public function insertAll($data)
    {
        self::getDb()->createCommand()->batchInsert(self::tableName(),['CourseId','FileName','FileSize'],$data)->execute();
        return $data;
    }
}
