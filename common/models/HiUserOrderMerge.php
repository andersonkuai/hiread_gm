<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_user_order_merge".
 *
 * @property integer $ID
 * @property string $OrderId
 * @property integer $Uid
 * @property string $Trade
 * @property double $Price
 * @property integer $RecvId
 * @property string $Message
 * @property integer $PayType
 * @property integer $Status
 * @property integer $SendStatus
 * @property integer $PayTime
 * @property integer $Time
 * @property string $PaymentInfo
 * @property integer $isMerge
 */
class HiUserOrderMerge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_user_order_merge';
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
            [['ID', 'OrderId', 'Uid', 'Time'], 'required'],
            [['ID', 'Uid', 'RecvId', 'PayType', 'Status', 'SendStatus', 'PayTime', 'Time', 'isMerge'], 'integer'],
            [['Price'], 'number'],
            [['Message', 'PaymentInfo'], 'string'],
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
            'OrderId' => 'Order ID',
            'Uid' => 'Uid',
            'Trade' => 'Trade',
            'Price' => 'Price',
            'RecvId' => 'Recv ID',
            'Message' => 'Message',
            'PayType' => 'Pay Type',
            'Status' => 'Status',
            'SendStatus' => 'Send Status',
            'PayTime' => 'Pay Time',
            'Time' => 'Time',
            'PaymentInfo' => 'Payment Info',
            'isMerge' => 'Is Merge',
        ];
    }
}
