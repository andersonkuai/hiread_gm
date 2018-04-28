<?php

namespace common\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "hi_user_info_0".
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
 */
class HiUserInfo extends \yii\db\ActiveRecord
{
    public static $table = '';
    public function __construct($table,$config = [])
    {
        self::$table = $table;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::$table;
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
            [['Uid', 'Sex', 'Birthday', 'SchoolType', 'Integral', 'RegTime', 'Gold', 'LastLogin', 'SurveyScore', 'SurveyTime', 'isMerge'], 'integer'],
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
        ];
    }
    /**
     * @param $table
     * @param $condition
     * @return mixed
     * @throws InvalidConfigException
     */
    public static function findOnex($table, $condition)
    {
        return static::findByConditionx($table, $condition)->one();
    }
    /**
     * @param $table
     * @return object
     * @throws InvalidConfigException
     */
    public static function findx($table)
    {
        if (self::$table != $table) {
            self::$table = $table;
        }
        return Yii::createObject(ActiveQuery::className(), [get_called_class(), ['from' => [static::tableName()]]]);
    }
    /**
     * @param $table
     * @param $condition
     * @return mixed
     * @throws InvalidConfigException
     */
    protected static function findByConditionx($table, $condition)
    {
        $query = static::findx($table);

        if (!ArrayHelper::isAssociative($condition)) {
            // query by primary key
            $primaryKey = static::primaryKey();
            if (isset($primaryKey[0])) {
                $condition = [$primaryKey[0] => $condition];
            } else {
                throw new InvalidConfigException('"' . get_called_class() . '" must have a primary key.');
            }
        }

        return $query->andWhere($condition);
    }
    /**
     * @param array $row
     * @return static
     */
    public static function instantiate($row)
    {
        return new static(static::tableName());
    }
}
