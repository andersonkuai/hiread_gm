<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%payment}}".
 *
 * @property string $id
 * @property string $appid
 * @property integer $amount
 * @property integer $amount_refunded
 * @property integer $paid
 * @property integer $refunded
 * @property integer $reversed
 * @property string $channel
 * @property string $transaction_no
 * @property string $extra
 * @property string $order_type
 * @property string $order_no
 * @property string $client_ip
 * @property string $subject
 * @property string $body
 * @property string $failure_code
 * @property string $failure_msg
 * @property string $metadata
 * @property string $description
 * @property integer $time_expire
 * @property integer $time_paid
 * @property integer $created
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%payment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['amount', 'amount_refunded', 'paid', 'refunded', 'reversed', 'time_expire', 'time_paid', 'created'], 'integer'],
            [['extra', 'failure_msg', 'metadata'], 'string'],
            [['id'], 'string', 'max' => 19],
            [['appid', 'channel', 'order_type', 'order_no', 'client_ip', 'failure_code'], 'string', 'max' => 50],
            [['transaction_no', 'subject', 'pingpp_chargeid'], 'string', 'max' => 100],
            [['body', 'description'], 'string', 'max' => 255],
            [['order_type', 'order_no'], 'unique', 'targetAttribute' => ['order_type', 'order_no'], 'message' => 'The combination of 商家订单类型 and 商家订单号 has already been taken.'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appid' => '平台',
            'amount' => '订单金额，分',
            'amount_refunded' => '已退款总金额，分',
            'paid' => '是否已付款',
            'refunded' => '是否有退款',
            'reversed' => '是否撤销',
            'channel' => '支付渠道',
            'transaction_no' => '支付渠道返回交易号',
            'extra' => '支付渠道额外参数，json格式',
            'order_type' => '商家订单类型',
            'order_no' => '商家订单号',
            'client_ip' => '客户端IP',
            'subject' => '商品标题',
            'body' => '商品描述',
            'failure_code' => '订单错误码',
            'failure_msg' => '订单错误消息描述',
            'metadata' => '元数据，json格式',
            'description' => '订单附加说明',
            'time_expire' => '订单失效时间',
            'time_paid' => '支付完成时间',
            'created' => '创建时间',
            'pingpp_chargeid' => 'ping++ charghe ID'
        ];
    }

    public function generateId(){

        return 'pa' . uniqid() . rand(1000, 9999);
    }
}
