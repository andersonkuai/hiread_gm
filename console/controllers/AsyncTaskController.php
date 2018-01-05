<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/8
 * Time: 11:50
 */

namespace console\controllers;


use common\classes\DelayTask;
use common\classes\SystemOperate;
use common\classes\UserOperate;
use common\enums\AsyncTask;
use common\enums\Cashpool;
use common\models\User;
use common\models\UserConsume;
use common\models\UserRecharge;
use yii\console\Controller;
use common\enums\StockPoint;
use common\enums\WhitePoint;
use common\helpers\Func;

class AsyncTaskController extends Controller
{
    //充值库存积分
    public function actionCharge(){
        exit('stops using');
        $userRechargeArr = UserRecharge::find()
            ->where(['asynctask_status' => AsyncTask::STATUS_CREATED])
            ->orderBy('created')
            ->all();

        if( !empty($userRechargeArr) ){
            $rate = Func::getReChargeStockRate();
            $whiteRate = Func::getReChargeWhiteRate();
            foreach ($userRechargeArr as $userRecharge){
                echo $userRecharge->recharge_sn . ' START...'.PHP_EOL;
                $rtns = $logs = [];
                $userRecharge->asynctask_status = AsyncTask::STATUS_PROGRESS;
                $userRecharge->update();

                $num = $userRecharge->money * $rate;
                //加库存积分
                $rtns[1] = UserOperate::stockPoint([
                    'uid'       =>  $userRecharge->recharge_uid,
                    'trade_type'=>  StockPoint::TRADE_TYPE_CHARGE,
                    'num'       =>  $num,
                    'other_uid' =>  0,
                    'other_type'=>  StockPoint::OTHER_TYPE_SYSTEM,
                    'other_name'=>  StockPoint::label(StockPoint::OTHER_TYPE_SYSTEM),
                    'mark'      =>  "会员充值库存积分[{$rate}倍]",
                    'trade_no'  =>  $userRecharge->recharge_sn
                ]);
                //加白积分
                $rtns[2] =UserOperate::whitePoint([
                    'uid'       =>  $userRecharge->recharge_uid,
                    'trade_type'=>  WhitePoint::TRADE_TYPE_SELLER_CHARGE_GET,
                    'num'       =>  $userRecharge->money * $whiteRate,
                    'other_uid' =>  0,
                    'other_type'=>  WhitePoint::OTHER_TYPE_SYSTEM,
                    'other_name'=>  WhitePoint::label(WhitePoint::OTHER_TYPE_SYSTEM),
                    'mark'      =>  "会员充值返还白积分[{$whiteRate}倍]",
                    'trade_no'  =>  $userRecharge->recharge_sn
                ]);
                //资金池记录
                $rtns[3] =SystemOperate::cash(
                    Cashpool::TRADE_TYPE_CHARGE,
                    $userRecharge->money,
                    $userRecharge->recharge_uid,
                    "会员充值库存积分[{$rate}倍][{$userRecharge->recharge_sn}]"
                );
                //商家分成
                $rtns[4] =UserOperate::sellerCommission($userRecharge->recharge_uid, $num, $userRecharge->recharge_sn);

                foreach($rtns as $key => $rtn){
                    $logs[] = $key . '.'.implode(',', $rtn);
                }
                $userRecharge->asynctask_status = AsyncTask::STATUS_SUCCESS;
                $userRecharge->asynctask_log = $this->logs($logs);
                $userRecharge->update();

                echo $userRecharge->recharge_sn . ' END.'.PHP_EOL;
            }
        }
    }
    //消费
    public function actionConsume(){
        exit('stops using');
        $userConsumeArr = UserConsume::find()
            ->where(['asynctask_status' => AsyncTask::STATUS_CREATED, 'trade_status' => 0])
            ->orderBy('created')
            ->all();

        if( !empty($userConsumeArr) ){
            foreach($userConsumeArr as $userConsume){
                echo $userConsume->consume_sn . ' START...'.PHP_EOL;
                $rtns = $logs = [];

                $userConsume->asynctask_status = AsyncTask::STATUS_PROGRESS;
                $userConsume->update();
                $rtns[1] = $rtnArr = UserOperate::consumePoint($userConsume['seller_uid'], $userConsume['consume_uid'],
                    $userConsume['money'], $userConsume['consume_sn']);

                if(!$rtnArr[0]){
                    $userConsume->asynctask_status = AsyncTask::STATUS_FAIL;
                    $userConsume->asynctask_log = $this->logs($rtnArr[1]);
                    $userConsume->update();
                    continue;
                }
                $userConsume->trade_status = 1;
                $userConsume->update();
                //消费分成
                $rtns[2] = UserOperate::consumeCommission( $userConsume['consume_uid'], $userConsume['money'],
                    $userConsume['consume_sn'] );

                foreach($rtns as $key => $rtn){
                    $logs[] = $key . '.'.implode(',', $rtn);
                }

                $userConsume->asynctask_status = AsyncTask::STATUS_SUCCESS;
                $userConsume->asynctask_log = $this->logs($logs);
                $userConsume->update();
                echo $userConsume->consume_sn . ' END.'.PHP_EOL;
            }
        }
    }

    //激活用户消费加入队列
    public function actionActivateUserConsume(){
        $userConsumeArr = UserConsume::find()
            ->where(['asynctask_status' => AsyncTask::STATUS_CREATED, 'trade_status' => 6])
            ->orderBy('created')
            ->all();

        if( !empty($userConsumeArr) ){
            foreach($userConsumeArr as $userConsume){
                echo $userConsume->consume_sn . ' START...'.PHP_EOL;

                $user = User::findOne(['id' => $userConsume['consume_uid']]);
                if(empty($user) || empty($user->ylmguid)) continue;

                //查询账号是否激活
                $sql = "select u.id,u.name,u.tel,b.openid,b.unionid from wn_user u 
                        left join wn_user_bind b on u.id = b.uid 
                        where u.id = {$user->ylmguid} and b.`type` = 'wx'";
                $mgUser = \Yii::$app->wnmall->createCommand($sql)->queryOne();
                if( empty($mgUser) ) continue;

                $userConsume->trade_status = 0;
                $userConsume->update();
                //加入队列
                DelayTask::instance()->put('USER_CONSUME', ['consume_sn' => $userConsume->consume_sn]);

                echo $userConsume->consume_sn . ' END.'.PHP_EOL;
            }
        }
    }

    private function logs($logs){
        $arr = [];

        if( is_array($logs) ){
            $arr = $logs;
        }elseif(is_string($logs)){
            $arr[] = $logs;
        }

        array_unshift($arr, date("Y-m-d H:i:s"));
        return implode(PHP_EOL, $arr);
    }
}