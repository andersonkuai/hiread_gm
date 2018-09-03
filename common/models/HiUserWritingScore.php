<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_user_writing_score".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $tid
 * @property integer $score_id
 */
class HiUserWritingScore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_user_writing_score';
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
            [['uid', 'tid', 'score_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'tid' => '题目id',
            'score_id' => '得分点id',
        ];
    }
}
