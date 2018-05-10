<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_admin_order".
 *
 * @property integer $ID
 * @property string $OrderId
 * @property double $Coupon
 * @property string $PayLink
 * @property string $UserName
 * @property integer $Uid
 * @property integer $CreateTime
 * @property integer $CourseId
 * @property double $Price
 */
class HiAdminOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_admin_order';
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
            [['Coupon', 'Price'], 'number'],
            [['Uid', 'CreateTime', 'CourseId'], 'integer'],
            [['OrderId'], 'string', 'max' => 50],
            [['PayLink', 'UserName'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'OrderId' => '订单号',
            'Coupon' => '优惠券',
            'PayLink' => '支付链接',
            'UserName' => '用户名',
            'Uid' => '用户id',
            'CreateTime' => '生成时间',
            'CourseId' => '课程id',
            'Price' => '订单支付价格',
        ];
    }
}
