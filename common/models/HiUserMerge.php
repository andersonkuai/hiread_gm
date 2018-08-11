<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_user_merge".
 *
 * @property integer $ID
 * @property integer $Uid
 * @property string $UserName
 * @property string $MUserName
 * @property string $Password
 * @property string $Mobile
 * @property integer $Type
 * @property integer $Time
 * @property string $UnionId
 * @property string $MUnionId
 * @property string $AccessToken
 * @property integer $ExpireTime
 * @property string $RefreshToken
 * @property string $SuggesterMobile
 * @property integer $Channel
 * @property string $InviteCode
 * @property integer $isMerge
 * @property integer $refreshExpireTime
 * @property string $open_id
 */
class HiUserMerge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_user_merge';
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
            [['Uid'], 'required'],
            [['Uid', 'Type', 'Time', 'ExpireTime', 'Channel', 'isMerge', 'refreshExpireTime'], 'integer'],
            [['UserName', 'UnionId', 'MUnionId', 'open_id'], 'string', 'max' => 50],
            [['MUserName', 'Password'], 'string', 'max' => 32],
            [['Mobile'], 'string', 'max' => 11],
            [['AccessToken', 'RefreshToken'], 'string', 'max' => 200],
            [['SuggesterMobile'], 'string', 'max' => 20],
            [['InviteCode'], 'string', 'max' => 10],
            [['MUserName'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Uid' => '玩家ID',
            'UserName' => '用户名',
            'MUserName' => 'MD5后的用户名',
            'Password' => '用户密码',
            'Mobile' => '绑定手机号',
            'Type' => '用户类型(1:普通用户2:微信用户)',
            'Time' => '注册时间',
            'UnionId' => '微信用户统一标识',
            'MUnionId' => 'MD5后的微信用户统一标识',
            'AccessToken' => '微信token',
            'ExpireTime' => '过期时间',
            'RefreshToken' => '微信刷新用token',
            'SuggesterMobile' => '推荐人手机号',
            'Channel' => '推广链接渠道号',
            'InviteCode' => '邀请码',
            'isMerge' => '是否合并，1：是，0：否',
            'refreshExpireTime' => '过期时间',
            'open_id' => '用户微信open_id',
        ];
    }
}
