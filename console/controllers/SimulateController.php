<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/7
 * Time: 17:08
 */

namespace console\controllers;


use common\models\UserConsume;
use yii\console\Controller;

class SimulateController extends Controller
{
    //模拟客户消费
    public function actionConsume(){

        $users = [1,8,9,10,11];
        shuffle($users);
        $consume_uid = array_shift($users);
        $seller_uid = array_shift($users);
        $model = new UserConsume();
        $data = [
            'consume_sn' => $model->generateConsumeSn(),
            'consume_uid' => $consume_uid,
            'money' => rand(10000, 990000),
            'seller_uid' => $seller_uid,
            'platform' => $this->u_array_rand([0,1,2]),
            'order_sn' => 'sl' . uniqid() . rand(1000, 9999),
            'trade_status' => 0,
            'created' => time()
        ];

        $model->setAttributes  ($data);
        $rtn = $model->save();

        echo $rtn ? 'success':'fail',' ',$data['consume_sn'],PHP_EOL;
    }

    private function u_array_rand( $arr ){
        return $arr[array_rand($arr)];
    }
}