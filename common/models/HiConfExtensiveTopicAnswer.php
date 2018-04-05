<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_extensive_topic_answer".
 *
 * @property integer $ID
 * @property integer $Tid
 * @property string $Name
 * @property string $Image
 * @property integer $Show
 * @property string $Pair1Text
 * @property string $Pair1Audio
 * @property string $Pair1Img
 * @property string $Pair2Text
 * @property string $Pair2Audio
 * @property string $Pair2Img
 */
class HiConfExtensiveTopicAnswer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_extensive_topic_answer';
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
            [['Tid', 'Show'], 'integer'],
            [['Name', 'Pair1Text', 'Pair1Audio', 'Pair1Img', 'Pair2Text', 'Pair2Audio', 'Pair2Img'], 'string', 'max' => 255],
            [['Image'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Tid' => '所属题目ID',
            'Name' => '答案描述',
            'Image' => '图片',
            'Show' => '是否显示该选项（0:不显示1:显示)',
            'Pair1Text' => '配对文字1',
            'Pair1Audio' => '配对音频1',
            'Pair1Img' => '配对图片1',
            'Pair2Text' => '配对文字2',
            'Pair2Audio' => '配对音频2',
            'Pair2Img' => '配对图片2',
        ];
    }
}
