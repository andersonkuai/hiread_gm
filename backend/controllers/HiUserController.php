<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\HiUserMerge;
use yii\data\Pagination;
use yii\widgets\LinkPager;

class HiUserController extends BaseController
{
    /**
     * 注册用户信息列表
     * @return string
     */
    public function actionIndex(){
        $query = HiUserMerge::find()->andWhere(1);
        $searchData = $this->searchForm($query, ['UserName', 'ReadLevel', 'ylmguid','Mobile']);
        //注册时间
        if(!empty($_GET['Time1'])){
            $searchData['Time1'] = $_GET['Time1'];
            $activated_time = strtotime($_GET['Time1']);
            $query = $query->andWhere("Time >= '{$activated_time}'");
        }
        if(!empty($_GET['Time2'])){
            $searchData['Time2'] = $_GET['Time2'];
            $activated_time = strtotime($_GET['Time2']);
            $query = $query->andWhere("Time <= '{$activated_time}'");
        }
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $users = $query->offset($pages->offset)->limit($pages->limit)->all();
        $renderData = [
            'users' => $users,
            'searchData' => $searchData,
            'pageHtml' => LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
            ])
        ];
        return $this->display('index', $renderData);
    }
    /**
     * 用户详情
     */
    public function actionInfo(){
        //问卷调查的答案分值配置
        $points = array(
            1 => array(1 => 1,2 => 2,3 => 3,4 => 4),
            2 => array(1 => 0,2 => 1,3 => 2,4 => 3,5 => 4,6 => 5),
            3 => array(1 => 0,2 => 1,3 => 2,4 => 3,5 => 4,6 => 5),
            4 => array(1 => 0,2 => 1,3 => 2,4 => 3,5 => 4,6 => 5),
            5 => array(1 => 0,2 => 2,3 => 2,4 => 2),
            6 => array(1 => 0,2 => 1,3 => 2,4 => 4),
        );
        $uid = \Yii::$app->getRequest()->get('id');
        if(empty($uid)) header("Location:http:/index.php?r=hi-user/index");
        //获取用户信息
        $user = HiUserMerge::findOne(['Uid' => $uid]);
        //获取问卷调查题目信息
        $connection = \Yii::$app->hiread;
        $sql = "select * from hi_conf_research";
        $research = $connection->createCommand($sql)->queryAll();
        //去掉最后一个题目
        array_pop($research);
        //获取用户问卷调查答案
        $suffix = substr($uid, -1);
        $sql = "select * from hi_user_survey_{$suffix} where uid = '{$uid}'";
        $result = $connection->createCommand($sql)->queryOne();
        $answer = $result['Questions'];
        if(!empty($answer)){
            $answer = json_decode($answer,true);
        }
        $renderData = [
            'user' => $user,
            'research' => $research,
            'answer' => $answer,
            'points' => $points,
        ];
        return $this->display('info',$renderData);
    }

}