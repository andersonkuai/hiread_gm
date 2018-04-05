<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_conf_course".
 *
 * @property integer $ID
 * @property integer $Level
 * @property integer $Category
 * @property string $ProdName
 * @property string $Name
 * @property string $CoverImg
 * @property integer $CouponID
 * @property integer $Integral
 * @property double $Price
 * @property double $DiscountPrice
 * @property double $TryPrice
 * @property string $Desc
 * @property string $Description
 * @property string $Lexile
 * @property string $Atos
 * @property integer $MinAge
 * @property integer $MaxAge
 * @property integer $WordsCount
 * @property string $ImportWords
 * @property string $DetailImg
 * @property integer $Expire
 * @property string $Suggest
 * @property string $Author
 * @property string $AuthorAbout
 * @property string $Harvest
 * @property integer $CourseTime
 * @property string $Tech
 * @property integer $UnitCount
 * @property integer $SUnitCount
 * @property integer $OpenDay
 */
class HiConfCourse extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_conf_course';
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
            [['Level', 'Category', 'CouponID', 'Integral', 'MinAge', 'MaxAge', 'WordsCount', 'Expire', 'CourseTime', 'UnitCount', 'SUnitCount', 'OpenDay'], 'integer'],
            [['Price', 'DiscountPrice', 'TryPrice'], 'number'],
            [['Desc', 'Description', 'Suggest', 'AuthorAbout', 'Harvest', 'Tech'], 'string'],
            [['ProdName'], 'string', 'max' => 50],
            [['Name', 'CoverImg', 'DetailImg', 'Author'], 'string', 'max' => 200],
            [['Lexile', 'Atos', 'ImportWords'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Level' => 'Level',
            'Category' => 'Category',
            'ProdName' => 'Prod Name',
            'Name' => 'Name',
            'CoverImg' => 'Cover Img',
            'CouponID' => 'Coupon ID',
            'Integral' => 'Integral',
            'Price' => 'Price',
            'DiscountPrice' => 'Discount Price',
            'TryPrice' => 'Try Price',
            'Desc' => 'Desc',
            'Description' => 'Description',
            'Lexile' => 'Lexile',
            'Atos' => 'Atos',
            'MinAge' => 'Min Age',
            'MaxAge' => 'Max Age',
            'WordsCount' => 'Words Count',
            'ImportWords' => 'Import Words',
            'DetailImg' => 'Detail Img',
            'Expire' => 'Expire',
            'Suggest' => 'Suggest',
            'Author' => 'Author',
            'AuthorAbout' => 'Author About',
            'Harvest' => 'Harvest',
            'CourseTime' => 'Course Time',
            'Tech' => 'Tech',
            'UnitCount' => 'Unit Count',
            'SUnitCount' => 'Sunit Count',
            'OpenDay' => 'Open Day',
        ];
    }
}
