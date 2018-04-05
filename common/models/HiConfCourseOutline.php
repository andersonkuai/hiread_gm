<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_course_outline".
 *
 * @property integer $ID
 * @property integer $CourseId
 * @property string $Name
 * @property string $Desc
 */
class HiConfCourseOutline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_course_outline';
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
            [['Name', 'Desc'], 'string', 'max' => 255],
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
            'Name' => '章节名称',
            'Desc' => '单元描述',
        ];
    }
    /**
     * 批量插入数据
     */
    public function insertAll($data)
    {
        Yii::$app->hiread->createCommand()->batchInsert(self::tableName(),['CourseId','Name','Desc'],$data)->execute();
        return $data;
    }
}
