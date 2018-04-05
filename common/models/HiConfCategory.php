<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_category".
 *
 * @property integer $ID
 * @property string $Name
 * @property integer $Pid
 */
class HiConfCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_category';
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
            [['Pid'], 'integer'],
            [['Name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Name' => 'Name',
            'Pid' => 'Pid',
        ];
    }
}
