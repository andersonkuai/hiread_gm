<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_coupon".
 *
 * @property integer $ID
 * @property string $Name
 * @property integer $Type
 * @property integer $Price
 * @property integer $Expire
 */
class HiConfCoupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_coupon';
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
            [['Type', 'Price', 'Expire'], 'integer'],
            [['Name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '代金券ID',
            'Name' => '代金券名称',
            'Type' => '代金券类型(1:现金券)',
            'Price' => '代金券面值',
            'Expire' => '代金券有效期',
        ];
    }
}
