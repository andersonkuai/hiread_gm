<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use yii;
use yii\data\Pagination;
use yii\widgets\LinkPager;

class TestController extends BaseController
{
    public function __construct($id, $module, $config = [])
    {
        $this->enableCsrfValidation = false;//关闭scrf验证
        parent::__construct($id, $module, $config);
    }
    public function actionClearTest(){
        $userSuffix = [0,1,2,3,4,5,6,7,8,9];
        $connection = \Yii::$app->hiread;
        foreach ($userSuffix as $v){
            $order = 'hi_user_order_'.$v;
            $orderDetail = 'hi_user_order_detail_'.$v;
            $userCourse = 'hi_user_course_'.$v;
            $sql1 = "select * from {$order} where Price <= 0.5";
            $result1 = $connection->createCommand($sql1)->queryAll();
            echo '<pre>';
            print_r($result1);
            if(!empty($result1)){
                foreach($result1 as $value){
                    $sql2 = "select * from {$orderDetail} where Oid = {$value['ID']} and Uid = {$value['Uid']}";
                    $result2 = $connection->createCommand($sql2)->queryAll();
                    echo '<pre>';
                    print_r($result2);
                    if(!empty($result2)){
                        foreach($result2 as $val){
                            $sql3 = "delete from {$userCourse} where Course = {$val['CourseId']} and Uid = {$value['Uid']}";
                            $result3 = $connection->createCommand($sql3)->execute();
                        }
                    }
                    //删除
                    $sql4 = "delete from {$orderDetail} where Oid = {$value['ID']} and Uid = {$value['Uid']}";
                    $connection->createCommand($sql4)->execute();
                }
            }
            //删除
            $sql5 = "delete from {$order} where Price <= 0.5";
            $connection->createCommand($sql5)->execute();
        }//end foreach
    }

}