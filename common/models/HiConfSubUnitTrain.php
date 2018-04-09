<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_sub_unit_train".
 *
 * @property integer $ID
 * @property integer $SUnitId
 * @property string $Questions
 * @property integer $Min
 * @property integer $Sec
 */
class HiConfSubUnitTrain extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_sub_unit_train';
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
            [['SUnitId', 'Min', 'Sec'], 'integer'],
            [['Questions'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'SUnitId' => '子单元ID',
            'Questions' => '跳出题目ID',
            'Min' => '分',
            'Sec' => '秒',
        ];
    }
}
