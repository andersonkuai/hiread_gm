<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_user_course_answer_merge".
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
class HiUserCourseAnswerMerge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_user_course_answer_merge';
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
            [['Uid'], 'required'],
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
}
