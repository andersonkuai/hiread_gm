<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_user_coupon_merge".
 *
 * @property integer $ID
 * @property integer $Uid
 * @property integer $Coupon
 * @property integer $Expire1
 * @property integer $Expire2
 * @property integer $Time
 * @property integer $isMerge
 * @property string $OrderId
 */
class HiUserCouponMerge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_user_coupon_merge';
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
            [['Uid', 'Coupon', 'Expire1', 'Expire2', 'Time', 'isMerge'], 'integer'],
            [['OrderId'], 'string', 'max' => 50],
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
            'Expire1' => '有效期',
            'Expire2' => '有效期',
            'Time' => '优惠券获得时间',
            'isMerge' => '是否合并',
            'OrderId' => '订单ID',
        ];
    }
}
