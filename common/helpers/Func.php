<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 16:39
 */

namespace common\helpers;

use Yii;
use common\models\SysConfig;
use common\models\GlobalStatistics;
use yii\base\InvalidParamException;

class Func
{
    //获取返还率,万分率
    public static function getReturnRate(){

        $useconfigrate = SysConfig::instance()->get('useconfigrate');

        if( $useconfigrate ){
            return SysConfig::instance()->get('returnrates');
        }else{
            $returnrates = GlobalStatistics::getLastest('returnrates');
            return $returnrates ? $returnrates : self::getReturnConfig('returnrates');
        }
    }
    public static function getReChargeStockRate(){

        $handin = self::getReturnConfig('handin');
        if($handin == 0) throw new InvalidParamException('handin can not be 0');

        return round(1/$handin, 2);
    }
    //白积分兑换美购券费率
    public static function getWhiteBalanceRate(){

        $whitebalancerate = self::getReturnConfig('whitebalancerate');
        if($whitebalancerate == 0) throw new InvalidParamException('whitebalancerate can not be 0');

        return $whitebalancerate;
    }
    //白积分兑换美购券倍率
    public static function getWhiteBalancePercent(){

        $whitebalancepercent = self::getReturnConfig('whitebalancepercent');
        if($whitebalancepercent == 0) throw new InvalidParamException('whitebalancepercent can not be 0');

        return $whitebalancepercent;
    }
    //红积分兑换美购券费率
    public static function getRedBalanceRate(){

        $redbalancerate = self::getReturnConfig('redbalancerate');
        if($redbalancerate == 0) throw new InvalidParamException('redbalancerate can not be 0');

        return $redbalancerate;
    }
    //红积分兑换美购券倍率
    public static function getRedBalancePercent(){

        $redbalancepercent = self::getReturnConfig('redbalancepercent');
        if($redbalancepercent == 0) throw new InvalidParamException('redbalancepercent can not be 0');

        return $redbalancepercent;
    }
    public static function getReChargeWhiteRate(){
        $rechargewhiterate = SysConfig::instance()->get('rechargewhiterate');

        if( $rechargewhiterate ){
            return SysConfig::instance()->get('rechargewhiterate');
        }else{
            return self::getReturnConfig('rechargewhiterate');
        }
    }
    public static function checkMobile($mobile){

        if(!$mobile || strlen($mobile) != 11) return false;

        $str_mate = "/^(0|86|17951)?(13[0-9]|14[57]|15[012356789]|166|17[03678]|18[0-9]|19[89])[0-9]{8}$/";
        $r = preg_match_all($str_mate,$mobile);
        if(!$r) return false;

        return true;
    }
    //todo
    public static function checkVerifyCode( $code, $mobile ){

        return $code == 8888 ? true : false;
    }

    public static function params($paramKey){

        return isset(Yii::$app->params[$paramKey]) ?
            Yii::$app->params[$paramKey] : null;
    }
    public static function param($paramKey, $key){

        $params = self::params($paramKey);
        return isset($params[$key]) ? $params[$key] : null;
    }
    public static function sign( $secret, $arr ){

        ksort($arr);
        $str = '';
        foreach( $arr as $key=>$value ){
            if( !is_string($value) && !is_numeric($value) )
                throw new InvalidParamException('expects param 2 array value to be string,array given.');
            $str.= $key . '=' . $value . '&';
        }
        return sha1($str.$secret);
    }

    public static function checkSign( $data, $keys = null ){

        if(empty($data['appid']) || empty($data['sign'])) return false;
        $appid = $data['appid'];
        $sign = $data['sign'];
        $app = self::param('system.app', $appid);

        unset($data['sign']);
        if( $keys ){
            foreach($data as $key => $value){
                if( !in_array($key, $keys) ) unset($data[$key]);
            }
        }
        $newSign = self::sign($app['appsecret'] , $data);

        return $sign == $newSign;
    }
    //元转为分
    public static function trMoney( $money ){

        if($money < 0) return 0;

        return intval(sprintf('%.2f' , $money * 100));
    }
    public static function getClientIp()
    {
        switch(true){
            case ($ip=getenv("HTTP_X_FORWARDED_FOR")):
                break;
            case ($ip=getenv("HTTP_CLIENT_IP")):
                break;
            default:
                $ip=getenv("REMOTE_ADDR")?getenv("REMOTE_ADDR"):'127.0.0.1';
        }
        if (strpos($ip, ', ')>0) {
            $ips = explode(', ', $ip);
            $ip = $ips[0];
        }
        return $ip;
    }

    public static function getReturnConfig( $name ){
        $configs = self::params('return_config');

        return isset($configs[$name]) ? $configs[$name] : 0;
    }
    public static function calculateRate($cashpool, $whitepoint, $withdrawRate, $day){

        if($whitepoint == 0) throw new InvalidParamException('Func::calculateRate param whitepoint can not be 0');
        if($withdrawRate == 1) throw new InvalidParamException('Func::calculateRate param withdrawRate can not be 1');

        $rate = 1 -   pow(1 - $cashpool / (1 - $withdrawRate) / $whitepoint, 1/$day);
        if(is_nan($rate)) throw new InvalidParamException('calculate Error');
        $rate = sprintf("%.6f", $rate * 10000);
        return $rate;
    }
    public static function calculateDay($cashpool, $whitepoint, $withdrawRate , $rate ){

        if($whitepoint == 0) throw new InvalidParamException('Func::calculateDay param whitepoint can not be 0');
        if($withdrawRate == 1) throw new InvalidParamException('Func::calculateDay param withdrawRate can not be 1');

        $day = log( 1 - $cashpool / (1 - $withdrawRate) / $whitepoint, (1 - $rate) );
        if(is_nan($day)) throw new InvalidParamException('calculate Error');
        $day = sprintf("%.6f", $day);
        return $day;
    }
    public static function resubmit(){
        $keyName = 'submit.time';
        $time = intval(Yii::$app->getSession()->get($keyName));
        if($time && (time() - $time < 3) ) return true;
        Yii::$app->getSession()->set($keyName, time());
        return false;
    }
    //格式化时间显示，如5分钟前,3天前
    public static function formatCreatedTime($time){
        if(intval($time) <= 0) return "";
        $str = "";
        $current_time = time();
        $result = $current_time - intval($time);
        if($result>0 && $result < 60){
            $str = intval($result)."秒前";
        }elseif($result >= 60 && $result < 3600){
            $str = intval($result / 60)."分钟前";
        }elseif ($result >= 3600 && $result < 86400){
            $str = intval($result / 3600)."小时前";
        }elseif ($result >= 86400 && $result < 2592000){
            $str = intval($result / 86400)."天前";
        }elseif ($result >= 2592000 && $result < 31104000){
            $str = intval($result / 2592000)."月前";
        }else{
            $str = intval($result / 31104000)."年前";
        }
        return $str;
    }
    public static function getPT(){

        $pt = (isset($_SERVER['HTTP_DEVICEID'] ) && in_array($_SERVER['HTTP_DEVICEID'], array('YLMG_IOS', 'YLMG_ANDROID') ))
        || ( isset($_GET['pt'] ) && $_GET['pt'] == 'app' ) ? 'app':'web';

        return $pt;
    }
}