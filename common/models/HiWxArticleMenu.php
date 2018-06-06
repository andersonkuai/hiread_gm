<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_wx_article_menu".
 *
 * @property integer $id
 * @property string $name
 * @property integer $order
 * @property integer $is_show
 */
class HiWxArticleMenu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_wx_article_menu';
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
            [['order', 'is_show'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '菜单名',
            'order' => '排序',
            'is_show' => '是否显示',
        ];
    }
}
