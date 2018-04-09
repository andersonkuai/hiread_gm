<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_topic".
 *
 * @property integer $ID
 * @property integer $SUnitId
 * @property string $Title
 * @property string $Image
 * @property string $Audio
 * @property string $QAudio
 * @property integer $Type
 * @property string $Video
 * @property string $Poster
 * @property string $PreviewIntro
 * @property string $SoundMark
 * @property string $CNMark
 * @property string $ENMark
 * @property string $Sample
 * @property string $SampleAudio
 * @property string $Correct
 * @property string $Analysis
 * @property string $AAudio
 * @property string $AVideo
 * @property string $Translate
 * @property string $Help
 * @property string $Matrix
 * @property integer $Gold
 * @property integer $IsTrain
 * @property string $Category
 * @property integer $VideoTime
 */
class HiConfTopic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_topic';
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
            [['SUnitId', 'Type', 'Gold', 'IsTrain', 'VideoTime'], 'integer'],
            [['Analysis', 'Translate'], 'string'],
            [['Title', 'Image', 'Audio', 'QAudio', 'Video', 'Poster', 'PreviewIntro', 'AAudio', 'AVideo', 'Help'], 'string', 'max' => 255],
            [['SoundMark', 'Correct'], 'string', 'max' => 50],
            [['CNMark'], 'string', 'max' => 30],
            [['ENMark', 'SampleAudio'], 'string', 'max' => 200],
            [['Sample'], 'string', 'max' => 100],
            [['Matrix', 'Category'], 'string', 'max' => 20],
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
            'Title' => '题目名称',
            'Image' => '题目图片',
            'Audio' => '音频文件',
            'QAudio' => '问题描述音频文件',
            'Type' => '题目类型(1:true/false2:单选题3:视频课4:单词卡5:填空-单词6:填空-句子7:造句8:图片记忆9:拖动对应文字图片10:开放性问题11:顺序拖动)',
            'Video' => '视频地址',
            'Poster' => '视频封面',
            'PreviewIntro' => '描述',
            'SoundMark' => '音标',
            'CNMark' => '中文注释',
            'ENMark' => '英文注释',
            'Sample' => '例句',
            'SampleAudio' => '例句音频',
            'Correct' => '正确答案',
            'Analysis' => '题目解析',
            'AAudio' => '解析音频',
            'AVideo' => '问题解析视频',
            'Translate' => '翻译',
            'Help' => '帮助',
            'Matrix' => '矩阵大小(行数_列数)',
            'Gold' => '奖励金币数',
            'IsTrain' => '是否是联系题目(0:否1:是)',
            'Category' => 'CCSS细项',
            'VideoTime' => '视频时长',
        ];
    }
}
