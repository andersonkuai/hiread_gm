<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gl_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $mark
 * @property string $realname
 * @property string $mobile
 * @property integer $login_time
 * @property string $login_ip
 * @property integer $status
 * @property string $auth_key
 * @property integer $modified
 * @property integer $created
 * @property integer $type
 */
class GlUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gl_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login_time', 'status', 'modified', 'created', 'type'], 'integer'],
            [['username', 'mark', 'realname', 'mobile', 'login_ip', 'auth_key'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password' => '密码',
            'mark' => '备注',
            'realname' => '真实姓名',
            'mobile' => '手机号',
            'login_time' => '最后登陆时间',
            'login_ip' => '最后登陆IP',
            'status' => '用户状态',
            'auth_key' => 'cookie登陆认证',
            'modified' => '编辑时间',
            'created' => '创建时间',
            'type' => '账户类型：1机构',
        ];
    }
}
