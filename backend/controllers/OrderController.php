<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\HiUserOrderMerge;
use yii\data\Pagination;
use yii\widgets\LinkPager;

class OrderController extends BaseController
{
    public function actionIndex(){
        $query = HiUserOrderMerge::find()->select(['hi_user_order_merge.id','hi_user_order_merge.OrderId','hi_user_order_merge.Uid','hi_user_order_merge.Trade','hi_user_order_merge.Price','hi_user_order_merge.RecvId',
                'hi_user_order_merge.Message','hi_user_order_merge.PayType','hi_user_order_merge.Status','hi_user_order_merge.SendStatus',
                'hi_user_order_merge.PayTime','hi_user_order_merge.Time','hi_user_order_merge.PaymentInfo','hi_user_merge.UserName','hi_user_merge.Mobile'])
            ->innerJoin('hi_user_merge','hi_user_order_merge.Uid = hi_user_merge.Uid')
            ->andWhere(1);
        $searchData = $this->searchForm($query, ['OrderId', 'hi_user_order_merge.Uid', 'hi_user_order_merge.PayType','Status','SendStatus','hi_user_merge.Mobile','hi_user_merge.UserName']);
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 10]);
        $orders = $query->offset($pages->offset)->limit($pages->limit)->asArray()->all();
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
}