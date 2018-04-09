<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_sub_unit".
 *
 * @property integer $ID
 * @property integer $UnitId
 * @property integer $Type
 * @property string $Name
 * @property integer $Force
 */
class HiConfSubUnit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_sub_unit';
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
            [['UnitId', 'Type', 'Force'], 'integer'],
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
            'UnitId' => '单元ID',
            'Type' => '子单元类型[用于导入不同页面](1:习题2:FreeTalk3:课前听读4:课前单词5:英文导读视频6:课后作业7:习题8:Free Talk)',
            'Name' => '单元名称',
            'Force' => '是否强制',
        ];
    }
    /**
     * 批量插入数据
     */
    public function insertAll($data)
    {
        Yii::$app->hiread->createCommand()->batchInsert(self::tableName(),['UnitId','Type','Name','Force'],$data)->execute();
        return $data;
    }
}
