<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 11:12
 */

namespace console\controllers;

use common\models\HiConfig;
use yii\console\Controller;
use yii\db\Exception;

class MergeDataController extends Controller
{
    /**
     * 合并优惠券数据
     */
    public function actionCoupon(){
        $userSuffix = [0,1,2,3,4,5,6,7,8,9];
        foreach ($userSuffix as $v){
            $tableName = 'hi_user_coupon_'.$v;
            $connection = \Yii::$app->hiread;
            $sql = "replace into hi_user_coupon_merge select * from {$tableName} where isMerge = 0";
            $result1 = $connection->createCommand($sql)->execute();
            //变更记录
            $sql = "update {$tableName} set isMerge = 1 where isMerge = 0;";
            $result2 = $connection->createCommand($sql)->execute();
            echo 'replace:'.$result1.',update:'.$result2.'--';
        }//end foreach
    }
    /**
     * 合并订单数据
     */
    public function actionMergeOrder(){
        $userSuffix = [0,1,2,3,4,5,6,7,8,9];
        foreach ($userSuffix as $v){
            $tableName = 'hi_user_order_'.$v;
            $connection = \Yii::$app->hiread;
            $sql = "replace into hi_user_order_merge select * from {$tableName} where isMerge = 0";
            $result1 = $connection->createCommand($sql)->execute();
            //变更记录
            $sql = "update {$tableName} set isMerge = 1 where isMerge = 0;";
            $result2 = $connection->createCommand($sql)->execute();
            echo 'replace:'.$result1.',update:'.$result2.'--';
        }//end foreach
    }
    public function actionMergeOrderDetail(){
        $userSuffix = [0,1,2,3,4,5,6,7,8,9];
        foreach ($userSuffix as $v){
            $tableName = 'hi_user_order_detail_'.$v;
            $connection = \Yii::$app->hiread;
            $sql = "replace into hi_user_order_detail_merge select * from {$tableName} where isMerge = 0";
            $result1 = $connection->createCommand($sql)->execute();
            //变更记录
            $sql = "update {$tableName} set isMerge = 1 where isMerge = 0;";
            $result2 = $connection->createCommand($sql)->execute();
            echo 'replace:'.$result1.',update:'.$result2.'--';
        }//end foreach
    }
    //合并用户数据
    public function actionMergeUser(){
        $userSuffix = [0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f'];
        foreach ($userSuffix as $v){
            $tableName = 'hi_user_'.$v;
            $connection = \Yii::$app->hiread;
            $sql = "replace into hi_user_merge select * from {$tableName} where isMerge = 0";
            $result1 = $connection->createCommand($sql)->execute();
            //变更记录
            $sql = "update {$tableName} set isMerge = 1 where isMerge = 0;";
            $result2 = $connection->createCommand($sql)->execute();
            echo 'replace:'.$result1.',update:'.$result2.'--';
        }//end foreach
    }
    public function actionMergeUserInfo(){
        $userSuffix = [0,1,2,3,4,5,6,7,8,9];
        foreach ($userSuffix as $v){
            $tableName = 'hi_user_info_'.$v;
            $connection = \Yii::$app->hiread;
            $sql = "replace into hi_user_info_merge select * from {$tableName} where isMerge = 0";
            $result1 = $connection->createCommand($sql)->execute();
            //变更记录
            $sql = "update {$tableName} set isMerge = 1 where isMerge = 0;";
            $result2 = $connection->createCommand($sql)->execute();
            echo 'replace:'.$result1.',update:'.$result2.'--';
        }//end foreach
    }
    //合并地址
    public function actionMergeAddress(){
        $userSuffix = [0,1,2,3,4,5,6,7,8,9];
        foreach ($userSuffix as $v){
            $tableName = 'hi_user_address_'.$v;
            $connection = \Yii::$app->hiread;
            $sql = "replace into hi_user_address_merge select * from {$tableName} where isMerge = 0";
            $result1 = $connection->createCommand($sql)->execute();
            //变更记录
            $sql = "update {$tableName} set isMerge = 1 where isMerge = 0;";
            $result2 = $connection->createCommand($sql)->execute();
            echo 'replace:'.$result1.',update:'.$result2.'--';
        }//end foreach
    }
    //合并地址
    public function actionMergeUserCourse(){
        $userSuffix = [0,1,2,3,4,5,6,7,8,9];
        foreach ($userSuffix as $v){
            $tableName = 'hi_user_course_'.$v;
            $connection = \Yii::$app->hiread;
            $sql = "replace into hi_user_course_merge select * from {$tableName} where isMerge = 0";
            $result1 = $connection->createCommand($sql)->execute();
            //变更记录
            $sql = "update {$tableName} set isMerge = 1 where isMerge = 0;";
            $result2 = $connection->createCommand($sql)->execute();
            echo 'replace:'.$result1.',update:'.$result2.'--';
        }//end foreach
    }
    //合并作文答案
    public function actionMergeUserCourseAnswer(){
        $userSuffix = [0,1,2,3,4,5,6,7,8,9];
        foreach ($userSuffix as $v){
            $tableName = 'hi_user_course_answer_'.$v;
            $connection = \Yii::$app->hiread;
            $sql = "replace into hi_user_course_answer_merge select * from {$tableName} where isMerge = 0";
            $result1 = $connection->createCommand($sql)->execute();
            //变更记录
            $sql = "update {$tableName} set isMerge = 1 where isMerge = 0;";
            $result2 = $connection->createCommand($sql)->execute();
            echo 'replace:'.$result1.',update:'.$result2.'--';
        }//end foreach
    }
    
    

}