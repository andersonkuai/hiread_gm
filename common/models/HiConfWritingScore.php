<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_writing_score".
 *
 * @property integer $id
 * @property integer $level
 * @property integer $type
 * @property string $item
 * @property integer $point
 * @property string $name
 * @property string $score
 * @property double $weight
 */
class HiConfWritingScore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_writing_score';
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
            [['level', 'type', 'point'], 'integer'],
            [['name'], 'string'],
            [['weight'], 'number'],
            [['item', 'score'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'level' => '等级',
            'type' => '类型，0：informational 1:argument',
            'item' => '得分项目',
            'point' => '得分点',
            'name' => '得分项名称',
            'score' => '得分项分值',
            'weight' => '权重',
        ];
    }
}
