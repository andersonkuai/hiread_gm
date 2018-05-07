<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_coupon".
 *
 * @property integer $ID
 * @property string $Name
 * @property integer $Type
 * @property double $Price
 * @property double $MinLimit
 * @property string $CourseId
 * @property integer $EffectiveWay
 * @property integer $EffectiveTime1
 * @property integer $EffectiveTime2
 * @property integer $EffectiveDay
 * @property integer $SingleLimit
 * @property integer $Count
 * @property integer $state
 * @property integer $AlCount
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
            [['Type', 'EffectiveWay', 'EffectiveTime1', 'EffectiveTime2', 'EffectiveDay', 'SingleLimit', 'Count', 'state', 'AlCount'], 'integer'],
            [['Price', 'MinLimit'], 'number'],
            [['Name'], 'string', 'max' => 20],
            [['CourseId'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '代金券ID',
            'Name' => '优惠券名称',
            'Type' => '优惠券类型(1:现金券)',
            'Price' => '面额',
            'MinLimit' => '最低限额',
            'CourseId' => '适用课程范围，0：通用',
            'EffectiveWay' => '生效方式,1设定区间，2领取生效',
            'EffectiveTime1' => '有效时长（开始）',
            'EffectiveTime2' => '有效时长（截止）',
            'EffectiveDay' => '生效时间（天数）',
            'SingleLimit' => '单账号限制，0：无限制',
            'Count' => '券数',
            'state' => '优惠券状态，1：创建，2：生效，3：失效',
            'AlCount' => '已发券数',
        ];
    }
}
