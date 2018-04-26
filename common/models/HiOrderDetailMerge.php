<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_order_detail_merge".
 *
 * @property integer $ID
 * @property integer $Uid
 * @property string $OrderId
 * @property integer $Oid
 * @property integer $CourseId
 * @property string $Group
 * @property double $Price
 * @property double $DiscountPrice
 * @property integer $IsTry
 * @property integer $Count
 * @property integer $Time
 * @property integer $isMerge
 */
class HiOrderDetailMerge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_order_detail_merge';
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
            [['ID', 'Oid', 'Count'], 'required'],
            [['ID', 'Uid', 'Oid', 'CourseId', 'IsTry', 'Count', 'Time', 'isMerge'], 'integer'],
            [['Price', 'DiscountPrice'], 'number'],
            [['OrderId'], 'string', 'max' => 50],
            [['Group'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Uid' => '用户Id',
            'OrderId' => '订单id',
            'Oid' => '订单自增ID',
            'CourseId' => '课程ID',
            'Group' => '团购信息',
            'Price' => '购买时原价',
            'DiscountPrice' => '购买时折扣价',
            'IsTry' => '是否试听',
            'Count' => '购买数量',
            'Time' => '购买时间',
            'isMerge' => '是否合并，1：是，0：否',
        ];
    }
}
