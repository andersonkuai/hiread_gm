<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\helpers\Curl;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use common\models\HiUserCourseMerge;
use common\models\HiAutumnLiveTime;
use common\models\HiConfCourse;
use common\models\HiUserInfo;

use Yii;

class UserCourseController extends BaseController
{
    /**
     * 订单列表
     */
    public function actionIndex()
    {
        $query = HiUserCourseMerge::find()->alias('a')->select([
               'a.*','b.UserName','c.week','live_time' => 'c.time','d.EnName','e.ProdName','e.HLevel'
            ])
            ->innerJoin('hi_user_merge as b','a.Uid = b.Uid')
            ->innerJoin('hi_user_info_merge d','a.Uid = d.Uid')
            ->innerJoin('hi_conf_course e','a.Course = e.ID')
            ->leftJoin('hi_autumn_live_time c','a.live_time = c.id')
            ->andWhere('a.status = 1');
        $searchData = $this->searchForm($query, ['a.Uid','b.UserName','e.HLevel','c.id','a.Course']);
        //下单时间
        if(!empty($_GET['Time1'])){
            $searchData['Time1'] = $_GET['Time1'];
            $activated_time = strtotime($_GET['Time1']);
            $query = $query->andWhere("a.Time >= '{$activated_time}'");
        }
        if(!empty($_GET['Time2'])){
            $searchData['Time2'] = $_GET['Time2'];
            $activated_time = strtotime($_GET['Time2']);
            $query = $query->andWhere("a.Time <= '{$activated_time}'");
        }
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $res = $query->orderBy('a.Time desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        //获取直播课时间
        $liveTime = HiAutumnLiveTime::find()->asArray()->all();
        //获取课程信息
        $courseName = HiConfCourse::find()->select(['ProdName','ID'])->asArray()->all();

        $renderData = [
            'courseName' => $courseName,
            'liveTime' => $liveTime,
            'course' => $res,
            'searchData' => $searchData,
            'pageHtml' => LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
            ])
        ];
        return $this->display('index',$renderData);
    }
    /**
    *添加用户课程
    */
    public function actionAdd()
    {
        if(\Yii::$app->getRequest()->getIsPost()){
            $connection  = \Yii::$app->hiread;  
            $transaction = \Yii::$app->hiread->beginTransaction();
            try{
                if(empty($_POST['uid']) || empty($_POST['course'])){
                    throw new \Exception("用户、课程数据不能为空", 1);
                }
                $uid = $_POST['uid'];
                $courseId = $_POST['course'];

                $userInfoTable = 'hi_user_info_'.substr($uid,-1,1);
                $userCourseTable = 'hi_user_course_'.substr($uid,-1,1);
                //查询用户信息
                $userInfo = HiUserInfo::findOnex($userInfoTable,['Uid' => $uid]);
                if(empty($userInfo)) $this->exitJSON(0,'用户不存在');
                //查询用户是否有改课程
                $sql1     = "select * from {$userCourseTable} where Uid =".$uid." and Course = ".$courseId;
                $command = $connection->createCommand($sql1);
                $res     = $command->queryAll();
                if(!empty($res)) throw new \Exception("用户已有该课程");
                $time = time();
                //添加原始表
                $sql = "insert into {$userCourseTable} (Uid,Course,Time,isMerge) values({$uid},{$courseId},{$time},1)";
                $command = $connection->createCommand($sql);
                $res = $command->execute();
                //添加合并表
                $sql = "insert into hi_user_course_merge (Uid,Course,Time,isMerge) values({$uid},{$courseId},{$time},1)";
                $command = $connection->createCommand($sql);
                $res = $command->execute();

                $transaction->commit();
            }catch (\Exception $e){
                $transaction->rollBack();
                $this->exitJSON(0,$e->getMessage());
            }
            $this->exitJSON(1,'添加成功',[]);
        }else {
            //获取直播课时间
            $liveTimePre = HiAutumnLiveTime::find()->asArray()->all();
            $liveTime = [];
            foreach ($liveTimePre as $val) {
                $liveTime[$val['level']][] = $val;
            }
            //获取课程信息
            $courseName = HiConfCourse::find()->select(['ProdName','ID','HLevel'])->asArray()->all();
            $data = ['course' => $courseName,'liveTime' => $liveTime];
            return $this->display('form',$data);
        }
        
    }
    
}