<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_wx_article_theme".
 *
 * @property integer $id
 * @property string $theme
 * @property string $img
 */
class HiWxArticleTheme extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_wx_article_theme';
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
            [['theme', 'img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'theme' => '内容主题',
            'img' => '背景图片',
        ];
    }
}
