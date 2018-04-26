<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_order_merge".
 *
 * @property integer $ID
 * @property string $OrderId
 * @property integer $Uid
 * @property integer $Type
 * @property string $Trade
 * @property double $Price
 * @property integer $RecvId
 * @property string $Message
 * @property integer $PayType
 * @property double $RefundPrice
 * @property integer $Status
 * @property integer $SendStatus
 * @property integer $PayTime
 * @property integer $Time
 * @property string $PaymentInfo
 * @property integer $RefundTime
 * @property string $Mark
 * @property integer $isMerge
 */
class HiOrderMerge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_order_merge';
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
            [['ID', 'OrderId', 'Time'], 'required'],
            [['ID', 'Uid', 'Type', 'RecvId', 'PayType', 'Status', 'SendStatus', 'PayTime', 'Time', 'RefundTime', 'isMerge'], 'integer'],
            [['Price', 'RefundPrice'], 'number'],
            [['Message', 'PaymentInfo', 'Mark'], 'string'],
            [['OrderId'], 'string', 'max' => 50],
            [['Trade'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'OrderId' => '订单ID',
            'Uid' => '用户ID',
            'Type' => '订单类型(1:普通课程2:拼团3:营销)',
            'Trade' => '第三方交易单号',
            'Price' => '订单价格',
            'RecvId' => '收货地址ID',
            'Message' => '买家留言',
            'PayType' => '支付类型（0：未知1：微信2：支付宝）',
            'RefundPrice' => '退款金额',
            'Status' => '订单状态（0:未支付1：已支付2：支付失败3：全部退款4：部分退款）',
            'SendStatus' => '发货状态(0:未发货1:已发货2:已签收）',
            'PayTime' => '订单支付时间',
            'Time' => '订单生成时间',
            'PaymentInfo' => '支付相关信息',
            'RefundTime' => '退款时间',
            'Mark' => '备注信息',
            'isMerge' => '是否合并，1：是，0：否',
        ];
    }
    /**
     * 关联查询子订单
     */
    public function getOrderDetail()
    {
        return $this->hasMany(HiOrderDetailMerge::className(),['OrderId' => 'OrderId']);
    }
}
