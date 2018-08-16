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
        $searchData = $this->searchForm($query, ['a.Uid','b.UserName','e.HLevel','c.id']);
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
        $renderData = [
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
    
}