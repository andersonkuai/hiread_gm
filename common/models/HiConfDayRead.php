<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_day_read".
 *
 * @property integer $ID
 * @property integer $UnitID
 * @property string $Name
 * @property integer $Chapter
 * @property integer $Page
 * @property string $Segment
 * @property string $AudioUrl
 * @property string $Content
 */
class HiConfDayRead extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_day_read';
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
            [['UnitID', 'Chapter', 'Page'], 'integer'],
            [['Content'], 'string'],
            [['Name'], 'string', 'max' => 255],
            [['Segment'], 'string', 'max' => 10],
            [['AudioUrl'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'UnitID' => '子单元ID',
            'Name' => '名称',
            'Chapter' => '章节',
            'Page' => '页码',
            'Segment' => '段',
            'AudioUrl' => '音频地址',
            'Content' => '原文内容',
        ];
    }
}
