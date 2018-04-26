<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\HiOrderDetailMerge;
use common\models\HiOrderMerge;
use common\models\HiUserAddressMerge;
use common\models\HiUserMerge;
use common\models\HiUserOrderMerge;
use yii\data\Pagination;
use yii\widgets\LinkPager;

class OrderController extends BaseController
{
    public function actionIndex(){
        $query = HiUserOrderMerge::find()->select(['hi_user_order_merge.id','hi_user_order_merge.OrderId','hi_user_order_merge.Uid','hi_user_order_merge.Trade','hi_user_order_merge.Price','hi_user_order_merge.RecvId',
                'hi_user_order_merge.Message','hi_user_order_merge.PayType','hi_user_order_merge.Status','hi_user_order_merge.SendStatus','hi_user_order_merge.CourseId',
                'hi_user_order_merge.PayTime','hi_user_order_merge.Time','hi_user_order_merge.PaymentInfo','hi_user_order_merge.DiscountPrice','hi_user_order_merge.Type',
                'hi_user_merge.UserName','hi_user_merge.City',
                'hi_user_address_merge.Province','hi_user_address_merge.City','hi_user_address_merge.Area','hi_user_address_merge.Address','hi_user_address_merge.Mobile',
                'hi_conf_course.ProdName',
            ])
            ->innerJoin('hi_user_merge','hi_user_order_merge.Uid = hi_user_merge.Uid')
            ->leftJoin('hi_user_address_merge','hi_user_order_merge.RecvId = hi_user_address_merge.ID and hi_user_order_merge.Uid = hi_user_address_merge.Uid')
            ->leftJoin('hi_conf_course','hi_user_order_merge.CourseId = hi_conf_course.ID')
            ->andWhere(1);
        $status = \Yii::$app->getRequest()->get("Status");
        //默认显示已支付的订单
        if (!isset($status)){
            $_GET["Status"] = 1;
        }
        $searchData = $this->searchForm($query, ['OrderId','hi_user_order_merge.Type', 'hi_user_order_merge.Uid', 'hi_user_order_merge.PayType','hi_user_order_merge.Status','hi_user_order_merge.SendStatus','hi_user_address_merge.Mobile','hi_user_merge.UserName','hi_conf_course.ProdName']);
        //下单时间
        if(!empty($_GET['Time1'])){
            $searchData['Time1'] = $_GET['Time1'];
            $activated_time = strtotime($_GET['Time1']);
            $query = $query->andWhere("hi_user_order_merge.Time >= '{$activated_time}'");
        }
        if(!empty($_GET['Time2'])){
            $searchData['Time2'] = $_GET['Time2'];
            $activated_time = strtotime($_GET['Time2']);
            $query = $query->andWhere("hi_user_order_merge.Time <= '{$activated_time}'");
        }
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $orders = $query->orderBy("Time desc")->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $renderData = [
            'orders' => $orders,
            'searchData' => $searchData,
            'pageHtml' => LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
            ])
        ];
        return $this->display('index', $renderData);
    }
    /**
     * 订单列表
     */
    public function actionList()
    {
        $query = HiOrderMerge::find()->alias('a')->select([
               'b.UserName','b.Mobile','b.InviteCode',
                'a.OrderId','a.Uid','a.Type','a.Trade','a.Price','a.PayType','a.Status','a.RefundPrice','a.SendStatus','a.PayTime','a.Time','a.RefundTime',
            ])
            ->leftJoin('hi_user_merge as b','a.Uid = b.Uid')
            ->andWhere(1);
        $status = \Yii::$app->getRequest()->get("Status");
        //默认显示已支付的订单
        if (!isset($status)){
            $_GET["Status"] = 1;
        }
        $searchData = $this->searchForm($query, ['OrderId','a.Type', 'a.Uid', 'a.PayType','a.Status','a.SendStatus','b.Mobile','b.UserName']);
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
        $ordersTmp = $query->orderBy('a.Time desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $orders = array();
        //获取订单详情
        if(!empty($ordersTmp)){
            foreach ($ordersTmp as $k=>$v){
                $orders[$v['OrderId']] = $v;
            }
            $orderIds = array_column($orders,'OrderId');
            $orderDetail = HiOrderDetailMerge::find()->alias('a')
                ->select([
                    'a.ID','a.Uid','a.OrderId','a.Oid','a.Group','a.Price','a.DiscountPrice','a.IsTry','a.Count','a.Time','a.CourseId',
                    'b.ProdName',
                ])
                ->leftJoin('hi_conf_course as b','a.CourseId = b.ID')
                ->orderBy('a.ID asc')->where(array('a.OrderId' => $orderIds))->asArray()->all();
            if(!empty($orderDetail)){
                foreach ($orderDetail as $key => $val){
                    $orders[$val['OrderId']]['detail'][] = $val;
                }
            }//end if
        }
        $renderData = [
            'orders' => $orders,
            'searchData' => $searchData,
            'pageHtml' => LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
            ])
        ];
        return $this->display('list',$renderData);
    }
    /**
     * 订单详情
     */
    public function actionInfo()
    {
        $orderId = $_GET['OrderId'];
        $renderData = array();
        if(!empty($orderId)){
//            $query = HiOrderMerge::find()->alias('a')->select([
//                    'b.UserName','b.Mobile','b.InviteCode',
//                    'a.OrderId','a.Uid','a.Type','a.Trade','a.Price','a.PayType','a.Status','a.RefundPrice','a.SendStatus','a.PayTime','a.Time','a.RefundTime','a.RecvId',
//                ])
//                ->leftJoin('hi_user_merge as b','a.Uid = b.Uid')
//                ->where(array('a.OrderId' => $orderId))->asArray()->one();
            $query = HiOrderMerge::find()
                ->where(array('OrderId' => $orderId))->asArray()->one();
            $renderData['order'] = $query;
            //查询用户信息
            if(!empty($query['Uid'])){
                $user = HiUserMerge::find()
                    ->where("`Uid` = {$query['Uid']}")->asArray()->one();
                $renderData['user'] = $user;
            }
            //查询收件地址
            if(!empty($query['RecvId'])){
                $receive = HiUserAddressMerge::find()->where(array('Uid' => $query['Uid'],'ID' => $query['RecvId']))->asArray()->one();
                $renderData['receive'] = $receive;
            }
            //查询订单详情
            if(!empty($query)){
                $orderDetail = HiOrderDetailMerge::find()->alias('a')
                    ->select([
                        'a.ID','a.Uid','a.OrderId','a.Oid','a.Group','a.Price','a.DiscountPrice','a.IsTry','a.Count','a.Time','a.CourseId',
                        'b.ProdName',
                    ])
                    ->leftJoin('hi_conf_course as b','a.CourseId = b.ID')
                    ->orderBy('a.ID asc')->where(array('a.OrderId' => $query['OrderId']))->asArray()->all();
                $renderData['orderDetail'] = $orderDetail;
            }
        }
        return $this->display('info',$renderData);
    }
}