<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 11:12
 */

namespace console\controllers;


use common\classes\KuaiqianClient;
use common\models\UserWithdraw;
use yii\console\Controller;

class WithdrawController extends Controller
{
    //快钱提现脚本
    public function actionBankpay(){

        $kuaiqianClient = new KuaiqianClient();
        //大额提现需要审核
        $withdrawList = UserWithdraw::find()
            ->where(['status'=> 'created'])
            ->andWhere('txamount <= 1000')
            ->all();

        if(empty($withdrawList)) return;
        foreach ( $withdrawList as $withdraw ){

            list($code, $msg) = $kuaiqianClient->bankPay($withdraw);

            $withdraw->status = $code == 1 ? 'pending' : 'submit_failed';
            $withdraw->log = $withdraw->log .date('Y-m-d H:i:s').'|'.$msg . PHP_EOL;
            $withdraw->update();
            echo date('Y-m-d H:i:s').'|'.$withdraw->withdraw_sn.'|'.$code.PHP_EOL;

            sleep(1);
        }

    }
    //快钱提现状态查询
    public function actionQuerydeal(){

        $kuaiqianClient = new KuaiqianClient();

        $withdrawList = UserWithdraw::find()
            ->where(['status'=> 'pending'])
            ->all();

        if(empty($withdrawList)) return;
        foreach ( $withdrawList as $withdraw ){

            list($code, $msg) = $kuaiqianClient->queryDeal($withdraw);

            if($code == 111){
                $withdraw->status = 'paid';
                $withdraw->update();
            }elseif ($code == 112){
                $withdraw->status = 'failed';
                $withdraw->log = $withdraw->log .date('Y-m-d H:i:s').'|'.$msg . PHP_EOL;
                $withdraw->update();
            }else{
                //暂时不作处理
                //echo $msg;
            }
            echo date('Y-m-d H:i:s').'|'.$withdraw->withdraw_sn.'|'.$code.PHP_EOL;

            sleep(1);
        }
    }

}