<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_course_catalog".
 *
 * @property integer $ID
 * @property integer $CourseId
 * @property integer $SUnitId
 * @property string $Name
 * @property integer $Min
 * @property integer $Sec
 */
class HiConfCourseCatalog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_course_catalog';
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
            [['CourseId', 'SUnitId', 'Min', 'Sec'], 'integer'],
            [['Name'], 'string', 'max' => 255],
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
            'SUnitId' => '子单元ID',
            'Name' => '目录名称',
            'Min' => '分',
            'Sec' => '秒',
        ];
    }
}
