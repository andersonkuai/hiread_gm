<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_user_writing_img".
 *
 * @property integer $id
 * @property integer $uid
 * @property integer $tid
 * @property string $image
 * @property integer $time
 */
class HiUserWritingImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_user_writing_img';
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
            [['uid', 'tid', 'time'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户id',
            'tid' => '题目id',
            'image' => '上传的图片',
            'time' => '图片上传时间',
        ];
    }
}
