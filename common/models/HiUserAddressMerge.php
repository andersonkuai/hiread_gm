<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_user_address_merge".
 *
 * @property integer $ID
 * @property integer $Uid
 * @property string $Name
 * @property string $Mobile
 * @property integer $ProvinceId
 * @property integer $CityId
 * @property integer $AreaId
 * @property string $Province
 * @property string $City
 * @property string $Area
 * @property string $Address
 * @property integer $Default
 * @property integer $isMerge
 */
class HiUserAddressMerge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_user_address_merge';
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
            [['ID', 'Uid'], 'required'],
            [['ID', 'Uid', 'ProvinceId', 'CityId', 'AreaId', 'Default', 'isMerge'], 'integer'],
            [['Name'], 'string', 'max' => 180],
            [['Mobile'], 'string', 'max' => 12],
            [['Province', 'City', 'Area'], 'string', 'max' => 30],
            [['Address'], 'string', 'max' => 200],
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
            'Name' => '收货人姓名',
            'Mobile' => '手机号码',
            'ProvinceId' => '省',
            'CityId' => '市',
            'AreaId' => '地区',
            'Province' => '省份名称',
            'City' => '城市名称',
            'Area' => '地区名称',
            'Address' => '收货地址',
            'Default' => '是否是默认地址（0：不是1：是）',
            'isMerge' => '是否合并，1：是，0：否',
        ];
    }
}
