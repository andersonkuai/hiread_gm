<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 11:12
 */

namespace console\controllers;

use yii\console\Controller;

class MergeDataController extends Controller
{
    /**
     * 合并订单数据
     */
    public function actionOrders(){
        //获取订单数据
        for ($i = 0; $i <= 9; $i++){
            $tableName = 'hi_user_order_'.$i;
            $connection = \Yii::$app->hiread;
            $sql = "replace into hi_user_order_merge select * from {$tableName} where isMerge = 0";
            $result1 = $connection->createCommand($sql)->execute();
            //变更记录
            $sql = "update {$tableName} set isMerge = 1 where isMerge = 0;";
            $result2 = $connection->createCommand($sql)->execute();
            echo 'replace:'.$result1.',update:'.$result2.'--';
        }//end for
    }
    /**
     * 合并用户数据
     */
    public function actionUsers(){
        $userSuffix = [0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f'];
        //获取订单数据
        foreach ($userSuffix as $v){
            $tableName = 'hi_user_'.$v;
            $connection = \Yii::$app->hiread;
            $sql = "replace into hi_user_merge select * from {$tableName} where isMerge = 0";
            $result1 = $connection->createCommand($sql)->execute();
            //变更记录
            $sql = "update {$tableName} set isMerge = 1 where isMerge = 0;";
            $result2 = $connection->createCommand($sql)->execute();
            echo 'replace:'.$result1.',update:'.$result2.'--';
        }//end for
    }

}