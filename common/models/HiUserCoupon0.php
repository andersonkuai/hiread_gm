<?php

namespace common\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "hi_user_coupon_0".
 *
 * @property integer $ID
 * @property integer $Uid
 * @property integer $Coupon
 * @property integer $Expire
 * @property integer $Time
 */
class HiUserCoupon0 extends \yii\db\ActiveRecord
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
            [['Uid', 'Coupon', 'Expire', 'Time'], 'integer'],
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
            'Coupon' => '优惠券ID',
            'Expire' => '有效期',
            'Time' => '优惠券获得时间',
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
