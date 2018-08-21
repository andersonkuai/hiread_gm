<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\helpers\Curl;
use common\models\HiAdminOrder;
use common\models\HiConfCourse;
use common\models\HiConfCoursePrice;
use common\models\HiOrderDetailMerge;
use common\models\HiOrderMerge;
use common\models\HiUserAddressMerge;
use common\models\HiUserCoupon0;
use common\models\HiUserMerge;
use common\models\HiUserOrder0;
use common\models\HiUserOrderMerge;
use common\models\HiUserOrderDetailMerge;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use Yii;

class OrderController extends BaseController
{
    // /**
    //  * 订单列表
    //  */
    // public function actionIndex()
    // {
    //     $query = HiOrderMerge::find()->alias('a')->select([
    //            'b.UserName','b.Mobile','b.InviteCode',
    //             'a.OrderId','a.Uid','a.Type','a.Trade','a.Price','a.PayType','a.Status','a.RefundPrice','a.SendStatus','a.PayTime','a.Time','a.RefundTime',
    //             'InvitedBy'=>'c.UserName',
    //         ])
    //         ->leftJoin('hi_user_merge as b','a.Uid = b.Uid')
    //         ->leftJoin('hi_invite_code as c', 'b.InviteCode = c.Code')
    //         ->andWhere(1);
    //     $status = \Yii::$app->getRequest()->get("Status");
    //     //默认显示已支付的订单
    //     if (!isset($status)){
    //         $_GET["Status"] = 1;
    //     }
    //     $searchData = $this->searchForm($query, ['OrderId','a.Type', 'a.Uid', 'a.PayType','a.Status','a.SendStatus','b.Mobile','b.UserName']);
    //     //下单时间
    //     if(!empty($_GET['Time1'])){
    //         $searchData['Time1'] = $_GET['Time1'];
    //         $activated_time = strtotime($_GET['Time1']);
    //         $query = $query->andWhere("a.Time >= '{$activated_time}'");
    //     }
    //     if(!empty($_GET['Time2'])){
    //         $searchData['Time2'] = $_GET['Time2'];
    //         $activated_time = strtotime($_GET['Time2']);
    //         $query = $query->andWhere("a.Time <= '{$activated_time}'");
    //     }
    //     $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
    //     $ordersTmp = $query->orderBy('a.Time desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
    //     $orders = array();
    //     //获取订单详情
    //     if(!empty($ordersTmp)){
    //         foreach ($ordersTmp as $k=>$v){
    //             $orders[$v['OrderId']] = $v;
    //         }
    //         $orderIds = array_column($orders,'OrderId');
    //         $orderDetail = HiOrderDetailMerge::find()->alias('a')
    //             ->select([
    //                 'a.ID','a.Uid','a.OrderId','a.Oid','a.Group','a.Price','a.DiscountPrice','a.IsTry','a.Count','a.Time','a.CourseId',
    //                 'b.ProdName',
    //             ])
    //             ->leftJoin('hi_conf_course as b','a.CourseId = b.ID')
    //             ->orderBy('a.ID asc')->where(array('a.OrderId' => $orderIds))->asArray()->all();
    //         if(!empty($orderDetail)){
    //             foreach ($orderDetail as $key => $val){
    //                 $orders[$val['OrderId']]['detail'][] = $val;
    //             }
    //         }//end if
    //     }
    //     $renderData = [
    //         'orders' => $orders,
    //         'searchData' => $searchData,
    //         'pageHtml' => LinkPager::widget([
    //             'pagination' => $pages,
    //             'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
    //         ])
    //     ];
    //     return $this->display('list',$renderData);
    // }
    /**
     * 订单列表
     */
    public function actionIndex()
    {
        $query = HiUserOrderMerge::find()->alias('a')->select([
               'b.UserName','b.Mobile','b.InviteCode',
                'a.OrderId','a.Uid','a.Type','a.Trade','a.Price','a.PayType','a.Status','a.RefundPrice','a.SendStatus','a.PayTime','a.Time','a.RefundTime','a.ID','a.RecvId'
            ])
            ->innerJoin('hi_user_merge as b','a.Uid = b.Uid')
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
            foreach ($ordersTmp as $k=>&$v){
                // $orders[$v['ID']] = $v;
                //获取订单详情
                $v['detail'] = HiUserOrderDetailMerge::find()->alias('a')
                            ->select([
                                'a.ID','a.Uid','a.Oid','a.Group','a.Price','a.DiscountPrice','a.IsTry','a.Count','a.Time','a.CourseId',
                                'b.ProdName','a.is_entity'
                            ])
                            ->innerJoin('hi_conf_course as b','a.CourseId = b.ID')
                            ->orderBy('a.ID asc')->where('a.Oid = '. $v['ID'].' and a.Uid = '.$v['Uid'])->asArray()->all();
            }
            // $orderIds = array_column($orders,'ID');
            // $orderDetail = HiUserOrderDetailMerge::find()->alias('a')
            //     ->select([
            //         'a.ID','a.Uid','a.Oid','a.Group','a.Price','a.DiscountPrice','a.IsTry','a.Count','a.Time','a.CourseId',
            //         'b.ProdName','a.is_entity'
            //     ])
            //     ->innerJoin('hi_conf_course as b','a.CourseId = b.ID')
            //     ->orderBy('a.ID asc')->where(array('a.Oid' => $orderIds))->asArray()->all();
            // // echo '<pre>';
            // // print_r($orderIds);
            // // exit;
            // if(!empty($orderDetail)){
            //     foreach ($orderDetail as $key => $val){
            //         $orders[$val['Oid']]['detail'][] = $val;
            //     }
            // }//end if
        }
        $renderData = [
            'orders' => $ordersTmp,
            'searchData' => $searchData,
            'pageHtml' => LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
            ])
        ];
        return $this->display('list',$renderData);
    }
    /**
     * 实时订单
     */
    public function actionRealTime()
    {
        $uid = !empty($_GET['Uid']) ? $_GET['Uid'] : 0;
        $tableName = 'hi_user_order_'.substr($uid,-1,1);
        //获取订单信息
        $query = HiUserOrder0::findx($tableName)->andWhere(1);
        $searchData = $this->searchForm($query, ['Uid','Type', 'PayType','Status','SendStatus']);
        //下单时间
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
        $orders = $query->orderBy('Time desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $renderData = [
            'orders' => $orders,
            'searchData' => ['Uid' => $uid],
            'pageHtml' => LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
            ])
        ];
        return $this->display('real-time',$renderData);
    }

    /**
     * 取消订单（实时）
     */
    public function actionUpdateOrder()
    {
        $id = $_GET['id'];
        $uid = !empty($_GET['uid']) ? $_GET['uid'] : 0;
        $tableName = 'hi_user_order_'.substr($uid,-1,1);
        $couponTab = 'hi_user_coupon_'.substr($uid,-1,1);
        if(empty($id)) $this->exitJSON(0,'id不能为空');
        $order = HiUserOrder0::findOnex($tableName,['ID' => $id,'Uid' => $uid]);
        if(empty($order)) $this->exitJSON(0,'验证失败');
        if(!empty($order['Coupon'])){
            $couponArray = explode('|',$order['Coupon']);
            if(!empty($couponArray)){
                foreach ($couponArray as $key=>$val){
                    $coupon = HiUserCoupon0::findOnex($couponTab,['ID' => $val,'Uid' => $uid]);
                    if(!empty($coupon)){
                        $coupon->isMerge = 0;
                        $coupon->OrderId = '';
                        $coupon->isUsed = 0;
                        $coupon->save();
                    }
                }
            }
        }
        $order->Status = 5;
        $order->isMerge = 0;
        $res = $order->save();
        if($res) $this->exitJSON(1,'success');
        $this->exitJSON(0,'fail');
    }

    /**
     * 手动生成的订单列表
     */
    public function actionCreateList()
    {
        $query = HiAdminOrder::find()->andWhere(1)->alias('a')
            ->select(['a.*','b.ProdName','coursePrice' => 'b.Price','b.DiscountPrice'])
            ->innerJoin('hi_conf_course b','a.CourseId = b.ID');
        $searchData = $this->searchForm($query, ['a.UserName','a.Uid', 'a.OrderId', 'a.CourseId','a.CourseName']);
        //下单时间
        if(!empty($_GET['Time1'])){
            $searchData['Time1'] = $_GET['Time1'];
            $activated_time = strtotime($_GET['Time1']);
            $query = $query->andWhere("a.CreateTime >= '{$activated_time}'");
        }
        if(!empty($_GET['Time2'])){
            $searchData['Time2'] = $_GET['Time2'];
            $activated_time = strtotime($_GET['Time2']);
            $query = $query->andWhere("a.CreateTime <= '{$activated_time}'");
        }
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $ordersTmp = $query->orderBy('CreateTime desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        if(!empty($ordersTmp)){
            //获取早鸟价
            foreach ($ordersTmp as $k=>&$v){
                $time = time();
                $courseId = $v['CourseId'];
                $earlyBirdPrice = HiConfCoursePrice::find()->where("`CourseId` = $courseId and STime <= $time and ETime >= $time")->asArray()->one();
                $v['earlyBirdPrice'] = !empty($earlyBirdPrice) ? $earlyBirdPrice['Price'] : '无';
            }
        }
        $renderData = [
            'orders' => $ordersTmp,
            'searchData' => $searchData,
            'pageHtml' => LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
            ])
        ];
        return $this->display('create-list',$renderData);
    }
    /**
     * 生成订单
     */
    public function actionCreateOrder()
    {
        if(Yii::$app->getRequest()->getIsPost()){
            $coupon = floatval($_POST['coupon']);
            if(empty($_POST['UserName']) || empty($_POST['Course'])){
                $this->exitJSON(0,'数据不能为空');
            }
            //根据手机号，课程id生成订单
            $privateKey = 'read_hi_kuai';
            $enName = !empty($_POST['EnName']) ? $_POST['EnName'] : '';
            $time = time();
            $sign = md5(md5($time.$privateKey.$coupon.$_POST['UserName'].$_POST['Course'].$enName));
            $curl = new Curl();
            $data = [
                'sign' => $sign,
                'courseId' => $_POST['Course'],
                'time' => $time,
                'coupon' => $coupon,
                'userName' => $_POST['UserName'],
                'EnName' => $enName,
            ];
            $res = $curl->curl(HIREADURL."order/createOrderByUserName?sign=",$data,'POST');
            if(!empty($res)){
                $resData = json_decode($res,true);
                if($resData['status'] != 'success'){
                    $this->exitJSON(0,'接口调用失败！',$resData);
                }else{
                    //保存生成的数据
                    $adminOrder = new HiAdminOrder();
                    $insertData = [
                       'OrderId' => $resData['entity']['orderId'],
                       'Coupon' => $coupon,
                       'PayLink' => 'this is a link',
                       'UserName' => $_POST['UserName'],
                       'Uid' => $resData['entity']['uid'],
                       'CreateTime' => $time,
                       'CourseId' => $_POST['Course'],
                       'Price' => $resData['entity']['price'],
                        'PayLink' => 'https://hiread.cn/activity/payOrder?user_name='.$_POST['UserName'].'hiread'.$resData['entity']['orderId'],
                    ];
                    $adminOrder->setAttributes($insertData, false);
                    $rtn = $adminOrder->insert();
                    $id = $adminOrder->ID;
                    if(empty($id)) $this->exitJSON(0,'生成失败！');
                    $this->exitJSON(1,'success');
                }
            }else{
                $this->exitJSON(0,'生成失败！');
            }
        }else{
            //查询所有课程
            $courseData = array();
            $course = HiConfCourse::find()->asArray()->all();
            if(!empty($course)){
                foreach ($course as $k=>$v){
                    $courseData[$v['ID']] = $v;
                }
            }
            $renderData = [
                'course' => $courseData,
            ];
            return $this->display('create-order',$renderData);
        }
    }
    /**
     * 获取课程信息
     */
    public function actionGetCourse()
    {
        if(empty($_GET['id'])) $this->exitJSON(0);
        $courseId = $_GET['id'];
        //查询所有课程
        $courseData = array();
        $course = HiConfCourse::find()->where(['ID' => $courseId])->asArray()->one();
        if(empty($course)) $this->exitJSON(0);
        //获取早鸟价
        $time = time();
        $earlyBirdPrice = HiConfCoursePrice::find()->where("`CourseId` = $courseId and STime <= $time and ETime >= $time")->asArray()->one();
        $course['earlyBirdPrice'] = !empty($earlyBirdPrice) ? $earlyBirdPrice['Price'] : 'none';
        $this->exitJSON(1,'',$course);
    }
    /**
     * 订单详情
     */
    public function actionInfo()
    {
        $orderId = $_GET['OrderId'];
        $uid = $_GET['Uid'];
        $renderData = array();
        if(!empty($orderId)){
//            $query = HiOrderMerge::find()->alias('a')->select([
//                    'b.UserName','b.Mobile','b.InviteCode',
//                    'a.OrderId','a.Uid','a.Type','a.Trade','a.Price','a.PayType','a.Status','a.RefundPrice','a.SendStatus','a.PayTime','a.Time','a.RefundTime','a.RecvId',
//                ])
//                ->leftJoin('hi_user_merge as b','a.Uid = b.Uid')
//                ->where(array('a.OrderId' => $orderId))->asArray()->one();
            $query = HiUserOrderMerge::find()
                ->where(array('OrderId' => $orderId,'Uid' => $uid))->asArray()->one();
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
                $orderDetail = HiUserOrderDetailMerge::find()->alias('a')
                    ->select([
                        'a.ID','a.Uid','a.Oid','a.Group','a.Price','a.DiscountPrice','a.IsTry','a.Count','a.Time','a.CourseId',
                        'b.ProdName',
                    ])
                    ->leftJoin('hi_conf_course as b','a.CourseId = b.ID')
                    ->orderBy('a.ID asc')->where(array('a.Oid' => $query['ID'],'a.Uid' => $query['Uid']))->asArray()->all();
                $renderData['orderDetail'] = $orderDetail;
            }
        }
        return $this->display('info',$renderData);
    }
}