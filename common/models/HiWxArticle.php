<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_wx_article".
 *
 * @property integer $id
 * @property integer $menu
 * @property string $title
 * @property string $introduction
 * @property integer $is_show
 * @property integer $time
 * @property string $url
 * @property string $img
 */
class HiWxArticle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_wx_article';
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
            [['menu', 'is_show', 'time'], 'integer'],
            [['title', 'url', 'img'], 'string', 'max' => 255],
            [['introduction'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'menu' => '菜单id',
            'title' => '标题',
            'introduction' => '简介',
            'is_show' => '是否显示 1:是，2：不是',
            'time' => '添加时间',
            'url' => '链接',
            'img' => '图片',
        ];
    }
}
