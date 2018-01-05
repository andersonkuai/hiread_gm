<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/8
 * Time: 15:16
 */

namespace console\controllers;


use common\classes\UserOperate;
use common\enums\RedPoint;
use common\enums\WhitePoint;
use common\helpers\Func;
use common\models\GlobalStatistics;
use common\models\SysInfo;
use common\models\User;
use common\models\UserWhitepointDetail;
use yii\console\Controller;

class RefundController extends Controller
{

    public function actionCalculate(){
        $row = GlobalStatistics::findOne(['ymd' => date("Ymd")]);

        if(!empty($row)) exit( date("Ymd").' Already calculated'.PHP_EOL );

        //开始计算

        $default_rates = Func::getReturnConfig('returnrates')/10000;//默认返还率
        $withdrawals_rates = Func::getReturnConfig('withdrawals_rates');//提现手续费 0.01
        $income_rates = Func::getReturnConfig('income_rates');//公司收入比率 0
        $returndays = Func::getReturnConfig('returndays');//可返还天数 180

        $sysInfo = SysInfo::findOne(1);
        $cashpool_total = $sysInfo->cash * (1 - $income_rates);//去掉公司收入
        $whitepoint_total = User::find()->sum('whitepoint');

        $day = log( 1 - $cashpool_total / (1 - $withdrawals_rates) / $whitepoint_total, (1 - $default_rates) );

        if($day < $returndays){
            $default_rates = 1 -   pow(1 - $cashpool_total / (1 - $withdrawals_rates) / $whitepoint_total, 1/$returndays);
            $day = log( 1 - $cashpool_total / (1 - $withdrawals_rates) / $whitepoint_total, (1 - $default_rates) );
        }

        $data = [
            'cashpool_total' => $sysInfo->cash,
            'whitepoint_total' => $whitepoint_total,
            'returnrates' => $default_rates * 10000,
            'returndays' => $day,
            'ymd' => date('Ymd'),
            'created' => time()
        ];
        $model = new GlobalStatistics();

        $model->setAttributes($data);
        $model->insert();

        exit(date("Ymd").' Finished calculation'.PHP_EOL);
    }
    //每日返还
    public function actionBalance(){
        $ymd = date("Ymd");
        $white_return_min = Func::getReturnConfig('white_return_min');
        $rate = Func::getReturnRate()/10000;
        while ( true ){
            $users = User::find()
                ->where(['<', 'lastbalance_date', $ymd])
                ->andWhere(['>', 'whitepoint', $white_return_min])
                ->limit(100)
                ->all();
            if(empty($users)) break;
            foreach ($users as $user){
                $user->lastbalance_date = $ymd;
                $user->update();
                $trade_no = uniqid('tn') . rand(1000, 9999);
                echo $user->id . '|' . $trade_no . ' Start...'.PHP_EOL;
                $pointNum = $user->whitepoint * $rate;

                $row = UserWhitepointDetail::findOne([
                    'uid'       => $user->id,
                    'trade_type'=> WhitePoint::TRADE_TYPE_CONSUME,
                    'ymd'       => $ymd
                ]);
                if(!empty($row)){
                    echo "Already balanced".PHP_EOL;
                    continue;//今天结算过 不再结算
                }
                //扣除白积分
                UserOperate::whitePoint([
                    'uid'       =>  $user->id,
                    'trade_type'=>  WhitePoint::TRADE_TYPE_CONSUME,
                    'num'       =>  -$pointNum,
                    'other_uid' =>  $user->id,
                    'other_type'=>  WhitePoint::OTHER_TYPE_USER,
                    'other_name'=>  $user->nickname,
                    'mark'      =>  "结算，转出至红积分",
                    'trade_no'  => $trade_no
                ]);
                //加入红积分
                UserOperate::redPoint([
                    'uid'       =>  $user->id,
                    'trade_type'=>  RedPoint::TRADE_TYPE_CONSUME,
                    'num'       =>  $pointNum,
                    'other_uid' =>  $user->id,
                    'other_type'=>  RedPoint::OTHER_TYPE_USER,
                    'other_name'=>  $user->nickname,
                    'mark'      =>  "结算，白积分转入",
                    'trade_no'  => $trade_no
                ]);

                echo $user->id . ' End.'.PHP_EOL;
            }
        }
    }
}