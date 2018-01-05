<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/1
 * Time: 9:47
 */

namespace console\controllers;

use common\models\User;
use yii\console\Controller;
use Yii;

/**
 * 云联美购相关操作
 * @package console\controllers
 */
class MallController extends Controller
{
    //从美购商城拉取注册用户以开通积分功能
    public function actionRegister(){

        while (true){

            $rows = Yii::$app->wnmall->createCommand(
                "SELECT id,name,nickname,tel,tguid,register2fund,register2fund_log,fund_uid 
                FROM wn_user where register2fund = 0 and tel <> '' order by id asc limit 1000"
            )->queryAll();
            if(empty($rows)) break;

            foreach ($rows as $row){

                //判断是否绑定微信，账号不完整，禁止同步start
                $wxBind = Yii::$app->wnmall
                    ->createCommand("select * from wn_user_bind where uid = {$row['id']} and `type` = 'wx'")
                    ->queryOne();
                if(empty($wxBind)) return false;//账号不完整，禁止同步end

                $rcmdid = 0;
                if(!empty($row['tguid'])){
                    $tgUser = Yii::$app->wnmall
                        ->createCommand("select fund_uid from wn_user where id = {$row['tguid']}")
                        ->queryOne();
                    $rcmdid = !empty($tgUser['fund_uid']) ? $tgUser['fund_uid'] : 0;
                }
                $ylmguid  = $row['id'];
                $mobile   = empty($row['tel']) ? '':$row['tel'];
                $rcmdid   = $rcmdid;
                $username = 'MG'. $ylmguid;
                $password = 'PW'.rand(10000, 99999);

                //$user = User::findOne(['username'=> $username]);
                
                $user = Yii::$app->db->createCommand("SELECT * FROM user WHERE username='{$username}'")->queryOne();
                
                if(empty($user)) {
                    //$user = new User();
                    $data = array(
                        'username' => $username,
                        'auth_key' => Yii::$app->security->generateRandomString(),
                        'password' => Yii::$app->security->generatePasswordHash($password),
                        'created' => time(),
                        'status' => 10,
                        'nickname'      => empty($row['nickname']) ? 'FD'.rand(10000, 99999) : $row['nickname'],
                        'realname'      => '',
                        'ylmguid'       => $ylmguid,
                        'mobile'        => $mobile,
                        'membertype'    => 0,
                        'email'         => '',
                        'idnumber'      => '',
                        'recommenderid' => $rcmdid,
                        'recommenders'  => implode(',', User::getRecommenders($rcmdid, 10)),
                        //'recommenders'  => '',
                        'avatar'        => '/avatar/avatar5.png',
                        'modified'      => time(),
                        'usertoken'     => md5('ut' . uniqid() . rand(1000, 9999))
                    );

                    //$user->setAttributes($data);
                    //$rtn = $user->insert();
                    
                    $rtn = Yii::$app->db->createCommand()->insert('user', $data)->execute();
                    if(!$rtn){
                        //$errors = $user->getFirstErrors();
                        $data = [
                            'register2fund'     => 2,
                            'register2fund_log' => 'insert error'
                        ];
                    }else{
                        $data = [
                            'register2fund' => 1,
                            'fund_uid'      => Yii::$app->db->getLastInsertID()
                        ];
                    }
                }else{
                    $data = [
                        'register2fund' => 1,
                        'fund_uid'      => $user['id']
                    ];
                }
                Yii::$app->wnmall->createCommand()->update('wn_user', $data, "id={$ylmguid}" )->execute();
                echo $ylmguid . "|" . json_encode($data) . PHP_EOL;
            }
        }
        
        
    }
    public function actionTest(){
            $aa = User::getRecommenders(11, 10);
            print_r($aa);
    }
}