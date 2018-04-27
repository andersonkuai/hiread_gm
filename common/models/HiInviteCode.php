<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_invite_code".
 *
 * @property integer $ID
 * @property string $Code
 * @property integer $Uid
 * @property string $UserName
 */
class HiInviteCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_invite_code';
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
            [['Uid'], 'integer'],
            [['Code'], 'string', 'max' => 10],
            [['UserName'], 'string', 'max' => 255],
            [['Code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Code' => '邀请码',
            'Uid' => '用户ID',
            'UserName' => '用户名(微信unionId或手机号)',
        ];
    }
}
