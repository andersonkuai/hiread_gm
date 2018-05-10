<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_course_price".
 *
 * @property integer $CourseId
 * @property double $Price
 * @property integer $STime
 * @property integer $ETime
 */
class HiConfCoursePrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_course_price';
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
            [['CourseId', 'STime', 'ETime'], 'integer'],
            [['Price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CourseId' => '课程ID',
            'Price' => '价格',
            'STime' => '开始时间',
            'ETime' => '结束时间',
        ];
    }
}
