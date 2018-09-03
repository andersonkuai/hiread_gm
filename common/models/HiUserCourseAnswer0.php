<?php

namespace common\models;

use Yii;
use yii\base\InvalidConfigException;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "hi_user_course_answer_0".
 *
 * @property integer $ID
 * @property integer $Uid
 * @property integer $Course
 * @property integer $Tid
 * @property string $Answer
 * @property string $Comment
 * @property integer $Teacher
 * @property integer $Time
 * @property string $Modify
 * @property double $Score
 * @property integer $isMerge
 */
class HiUserCourseAnswer0 extends \yii\db\ActiveRecord
{
    public static $table = '';
    public function __construct($table,$config = [])
    {
        self::$table = $table;
        parent::__construct($config);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return self::$table;
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
            [['Uid', 'Course', 'Tid', 'Teacher', 'Time', 'isMerge'], 'integer'],
            [['Answer', 'Comment', 'Modify'], 'string'],
            [['Score'], 'number'],
            [['Uid', 'Course'], 'unique', 'targetAttribute' => ['Uid', 'Course'], 'message' => 'The combination of 用户ID and 课程ID has already been taken.'],
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
            'Course' => '课程ID',
            'Tid' => '题目ID',
            'Answer' => '题目答案',
            'Comment' => '教师评语',
            'Teacher' => '评价老师',
            'Time' => '进入该题目时间',
            'Modify' => '教室批改',
            'Score' => '总分',
            'isMerge' => '是否合并，1：是，0：否',
        ];
    }
    /**
     * @param $table
     * @param $condition
     * @return mixed
     * @throws InvalidConfigException
     */
    public static function findOnex($table, $condition)
    {
        return static::findByConditionx($table, $condition)->one();
    }
    /**
     * @param $table
     * @return object
     * @throws InvalidConfigException
     */
    public static function findx($table)
    {
        if (self::$table != $table) {
            self::$table = $table;
        }
        return Yii::createObject(ActiveQuery::className(), [get_called_class(), ['from' => [static::tableName()]]]);
    }
    /**
     * @param $table
     * @param $condition
     * @return mixed
     * @throws InvalidConfigException
     */
    protected static function findByConditionx($table, $condition)
    {
        $query = static::findx($table);

        if (!ArrayHelper::isAssociative($condition)) {
            // query by primary key
            $primaryKey = static::primaryKey();
            if (isset($primaryKey[0])) {
                $condition = [$primaryKey[0] => $condition];
            } else {
                throw new InvalidConfigException('"' . get_called_class() . '" must have a primary key.');
            }
        }

        return $query->andWhere($condition);
    }
    /**
     * @param array $row
     * @return static
     */
    public static function instantiate($row)
    {
        return new static(static::tableName());
    }
    
}
