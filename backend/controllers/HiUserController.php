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
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 10]);
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
        $uid = \Yii::$app->getRequest()->get('id');
        if(empty($uid)) header("Location:http:/index.php?r=hi-user/index");
        //获取用户想信息
        $user = HiUserMerge::findOne(['Uid' => $uid]);
        //获取问卷调查题目信息
        $connection = \Yii::$app->hiread;
        $sql = "select * from hi_conf_research";
        $research = $connection->createCommand($sql)->queryAll();
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
        ];
        return $this->display('info',$renderData);
    }

}