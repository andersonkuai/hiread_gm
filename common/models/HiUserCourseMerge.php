<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "hi_user_course_merge".
 *
 * @property integer $ID
 * @property integer $Uid
 * @property integer $Course
 * @property integer $TopicCount
 * @property integer $CorrentCount
 * @property integer $ErrorCount
 * @property integer $State
 * @property integer $StudyUnitCount
 * @property string $StudyUnits
 * @property integer $StudyUnit
 * @property integer $StudyTopic
 * @property integer $CostTime
 * @property integer $IsTry
 * @property integer $Time
 * @property integer $StudySUnit
 * @property integer $live_time
 * @property integer $isMerge
 */
class HiUserCourseMerge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hi_user_course_merge';
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
            [['Uid', 'Course', 'TopicCount', 'CorrentCount', 'ErrorCount', 'State', 'StudyUnitCount', 'StudyUnit', 'StudyTopic', 'CostTime', 'IsTry', 'Time', 'StudySUnit', 'live_time', 'isMerge'], 'integer'],
            [['StudyUnits'], 'string', 'max' => 255],
            [['Uid', 'Course', 'State'], 'unique', 'targetAttribute' => ['Uid', 'Course', 'State'], 'message' => 'The combination of 用户ID, 课程ID and 课程状态(0:未开始1:学习中2:已完成学习3:试听过) has already been taken.'],
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
            'TopicCount' => '已做题目数量',
            'CorrentCount' => '答对次数',
            'ErrorCount' => '答错次数',
            'State' => '课程状态(0:未开始1:学习中2:已完成学习3:试听过)',
            'StudyUnitCount' => '已学单元数',
            'StudyUnits' => '已学过的单元ID(|隔开)',
            'StudyUnit' => '当前所处单元',
            'StudyTopic' => '当前题目ID',
            'CostTime' => '已花费时间',
            'IsTry' => '是否试听',
            'Time' => '进入该题目时间',
            'StudySUnit' => '当前所处子单元',
            'live_time' => '外教直播日期（秋季）',
            'isMerge' => '是否合并，1：是，0：否',
        ];
    }
}
