<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_unit".
 *
 * @property integer $ID
 * @property integer $CourseId
 * @property string $Name
 * @property integer $Type
 * @property integer $OpenDay
 */
class HiConfUnit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_unit';
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
            [['CourseId', 'Type', 'OpenDay'], 'integer'],
            [['Name'], 'string', 'max' => 50],
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
            'Name' => '单元名称',
            'Type' => '单元类型',
            'OpenDay' => '开放时间',
        ];
    }
    /**
     * 批量插入数据
     */
    public function insertAll($data)
    {
        self::getDb()->createCommand()->batchInsert(self::tableName(),['CourseId','Name','OpenDay'],$data)->execute();
        return $data;
    }
    /**
     * 关联查询子单元
     */
    public function getSubUnit()
    {
        return $this->hasMany(HiConfSubUnit::className(),['UnitId' => 'ID']);
    }
}
