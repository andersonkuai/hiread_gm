<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_user_info_merge".
 *
 * @property integer $ID
 * @property integer $Uid
 * @property string $UserName
 * @property string $NickName
 * @property string $Icon
 * @property integer $Sex
 * @property string $EnName
 * @property integer $Birthday
 * @property integer $SchoolType
 * @property integer $Integral
 * @property integer $RegTime
 * @property integer $Gold
 * @property string $RIp
 * @property integer $LastLogin
 * @property string $LIp
 * @property integer $SurveyScore
 * @property integer $SurveyTime
 * @property integer $isMerge
 * @property integer $school_type
 * @property integer $birth
 */
class HiUserInfoMerge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_user_info_merge';
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
            [['Uid', 'Sex', 'Birthday', 'SchoolType', 'Integral', 'RegTime', 'Gold', 'LastLogin', 'SurveyScore', 'SurveyTime', 'isMerge', 'school_type', 'birth'], 'integer'],
            [['UserName', 'NickName'], 'string', 'max' => 100],
            [['Icon'], 'string', 'max' => 200],
            [['EnName'], 'string', 'max' => 20],
            [['RIp', 'LIp'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Uid' => '用户ID',
            'UserName' => '用户名',
            'NickName' => '昵称',
            'Icon' => '头像链接',
            'Sex' => '性别(1:男2:女)',
            'EnName' => '英文名',
            'Birthday' => '孩子生日',
            'SchoolType' => '学校类型（学前：0，一年级:1)',
            'Integral' => '用户积分',
            'RegTime' => '注册时间',
            'Gold' => '金币数量',
            'RIp' => '注册IP',
            'LastLogin' => '最后一次登录',
            'LIp' => '最后一次登录IP',
            'SurveyScore' => '问卷调查分数',
            'SurveyTime' => '问卷调查时间',
            'isMerge' => '是否合并，1：是，0：否',
            'school_type' => '学校类型 1:公立学校  2:私立学校  3:双语学校  4:国际学校',
            'birth' => '记录年龄',
        ];
    }
}
