<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\HiConfCoupon;
use common\models\HiUserCoupon0;
use yii;
use yii\data\Pagination;
use yii\widgets\LinkPager;

class CouponController extends BaseController
{
    public function __construct($id, $module, $config = [])
    {
        date_default_timezone_set('PRC');
        $this->enableCsrfValidation = false;//关闭scrf验证
        parent::__construct($id, $module, $config);
    }
    /**
     * 优惠券列表
     * @return string
     */
    public function actionIndex(){
        $query = HiConfCoupon::find()->andWhere(1);
        $searchData = $this->searchForm($query, [ 'state','ID']);
        if(!empty($_GET['Name'])){
            $query->andWhere("Name like '%".$_GET['Name']."%'");
            $searchData['Name'] = $_GET['Name'];
        }
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $users = $query->orderBy("ID desc")->offset($pages->offset)->asArray()->limit($pages->limit)->all();
//        echo '<pre>';
//        print_r($users);exit;
        $renderData = [
            'users' => $users,
            'searchData' => $searchData,
            'pageHtml' => LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
            ])
        ];
        return $this->display('index', $renderData);
    }
    /**
     * 添加优惠券
     * @return string
     */
    public function actionAdd(){

        if(Yii::$app->getRequest()->getIsPost()){
            $this->couponForm();
        }else{
            $renderData = [];
            return $this->display('form', $renderData);
        }
    }
    /**
     * 修改优惠券
     * @return string
     */
    public function actionEdit(){
        if(Yii::$app->getRequest()->getIsPost()){
            $this->couponForm();
        }else {
            $id = intval(Yii::$app->getRequest()->get('id'));
            $row = HiConfCoupon::findOne(['ID' => $id]);
            $renderData = ['row' => $row];
            return $this->display('form', $renderData);
        }
    }
    private function couponForm(){
        $id = intval( Yii::$app->getRequest()->post('id') );
        $data = Yii::$app->getRequest()->post();
        $data['Expire'] = intval(Yii::$app->getRequest()->post('Expire')) * 3600 * 24;

        if( $id ){
            $admin = HiConfCoupon::findOne( $id );
            if(empty($data['Name'])) $this->exitJSON(0, '优惠券名称不能为空！');
            if(empty($data['Price'])) $this->exitJSON(0, '面额不能为空！');
            if(empty($data['Count'])) $this->exitJSON(0, '券数不能为空！');
            if($data['EffectiveWay'] == 1){
                if(empty($data['EffectiveTime1']) || empty($data['EffectiveTime2'])) $this->exitJSON(0,'有效时间不能为空！');
                $data['EffectiveTime1'] = strtotime($data['EffectiveTime1']);
                $data['EffectiveTime2'] = strtotime($data['EffectiveTime2']);
                unset($data['EffectiveDay']);
                $admin->EffectiveTime1 = $data['EffectiveTime1'];
                $admin->EffectiveTime2 = $data['EffectiveTime2'];
            }else{
                if(empty($data['EffectiveDay'])) $this->exitJSON(0,'有效时长不能为空！');
                unset($data['EffectiveTime1']);
                unset($data['EffectiveTime2']);
                $admin->EffectiveDay = $data['EffectiveDay'];
            }
            $admin->Name = $data['Name'];
            $admin->Price = $data['Price'];
            $admin->MinLimit = $data['MinLimit'];
            $admin->EffectiveWay = $data['EffectiveWay'];
            $admin->SingleLimit= $data['SingleLimit'];
            $admin->Count= $data['Count'];
            $rtn = $admin->save();
        }else{
            if(empty($data['Name'])) $this->exitJSON(0, '优惠券名称不能为空！');
            if(empty($data['Price'])) $this->exitJSON(0, '面额不能为空！');
            if(empty($data['Count'])) $this->exitJSON(0, '券数不能为空！');
                if($data['EffectiveWay'] == 1){
                if(empty($data['EffectiveTime1']) || empty($data['EffectiveTime2'])) $this->exitJSON(0,'有效时间不能为空！');
                $data['EffectiveTime1'] = strtotime($data['EffectiveTime1']);
                $data['EffectiveTime2'] = strtotime($data['EffectiveTime2']);
                unset($data['EffectiveDay']);
            }else{
                if(empty($data['EffectiveDay'])) $this->exitJSON(0,'有效时长不能为空！');
                unset($data['EffectiveTime1']);
                unset($data['EffectiveTime2']);
            }
            $admin = new HiConfCoupon();
            $admin->setAttributes($data, false);
            $rtn = $admin->insert();
            $id = $admin->ID;
        }
        if( $rtn ){
            $this->exitJSON(1, 'Success!');
        }else{
            $this->exitJSON(0, 'Fail!',$data);
        }
    }
    /**
     * 删除优惠券
     */
    public function actionDel()
    {
        $id = Yii::$app->getRequest()->get('id');
        if(empty($id)){
            $this->exitJSON(0, 'Fail!');
        }
        $result = HiConfCoupon::findOne($id)->delete();
        if($result){
            $this->exitJSON(1, 'success!');
        }else{
            $this->exitJSON(0, 'Fail!');
        }
    }
    /**
     * 操作优惠券
     */
    public function actionOperation()
    {
        $action = $_GET['action'];
        switch ($action){
            default :
                $this->exitJSON(0,'Fail!');
                break;
            case 2://生效
                break;
            case 3://失效
                break;
        }
        //修改
        $id = $_GET['id'];
        if(empty($id)) $this->exitJSON(0,'Fail!');
        $coupon = HiConfCoupon::findOne( $id );
        $coupon->state = $action;
        $rtn = $coupon->save();
        if($rtn){
            $this->exitJSON(1,'Success');
        }else{
            $this->exitJSON(0,'Fail');
        }
    }
    /**
     * 分发优惠券
     */
    public function actionGiveOut()
    {
        $time = time();
        $user = $_POST['content'];
        $id = $_POST['id'];
        if(empty($user) || empty($id)) $this->exitJSON(0,'数据为空！');
        $userData = explode('-hiread-',$user);
        $data = array();
        if(!empty($userData)){
            foreach ($userData as $key=>$val){
                if(in_array($val,$data)) $this->exitJSON(0,'账号'.$val.'重复');
                if(!empty($val)) $data[] = $val;
            }
        }
        if(empty($data)) $this->exitJSON(0,'账号不能为空！');
        //优惠券信息
        $coupon = HiConfCoupon::find()->where("`ID` = {$id}")->asArray()->one();
        if(empty($coupon)) $this->exitJSON(0,'该优惠券不存在！');
        if($coupon['state'] != 2) $this->exitJSON(0,'该优惠券不可发放!');
        if($coupon['EffectiveWay'] == 1){
            if(intval($coupon['EffectiveTime2']) < $time) $this->exitJSON(0,'该优惠券已过期!');
        }
        if(count($data) + intval($coupon['AlCount']) > intval($coupon['Count'])) $this->exitJSON(0,'优惠券数量不足！');
        $connection = Yii::$app->hiread;
        $transaction = $connection->beginTransaction();
        try{
            foreach ($data as $k=>$v){
                $v = trim($v);
                //用户信息
                $tableName = 'hi_user_'.substr(md5($v),0,1);
                $sql = "select * from {$tableName} where UserName = '{$v}'";
                $command = $connection->createCommand($sql);
                $user = $command->queryOne();
                if(empty($user)){
                    throw new yii\db\Exception($v.'用户不存在！');
                }
                //查询用户已获取此优惠码数量
                $tableName = 'hi_user_coupon_'.substr($user['Uid'],-1,1);
                $sql = "select count(*) count from {$tableName} where Uid = {$user['Uid']} and Coupon = {$id}";
                $command = $connection->createCommand($sql);
                $count = $command->queryOne();
                if(empty($count)) $this->exitJSON(0,'发放失败！');
                if($coupon['SingleLimit'] != 0){
                    if(intval($count['count']) + 1 > $coupon['SingleLimit']) $this->exitJSON(0,$v.'账号下此组优惠券已达上限！');
                }
                //为账号添加优惠券
                if($coupon['EffectiveWay'] == 1){
                    $expire = $coupon['EffectiveTime2'];
                }elseif($coupon['EffectiveWay'] == 2){
                    $expire = $time + 86400*$coupon['EffectiveDay'];
                }
                $userCoupon = new HiUserCoupon0($tableName);
                $userCoupon->Uid = $user['Uid'];
                $userCoupon->Coupon = $id;
                $userCoupon->Expire = $expire;
                $userCoupon->Time = $time;
                $userCoupon->setAttributes(array(['Uid' => $user['Uid'],'Coupon' => $id,'Expire' => $expire,'Time' => $time]));
                $res = $userCoupon->save();
                if(!empty($res)){
                    //修改优惠券信息
                    $couponInfo = HiConfCoupon::findOne($id);
                    if($couponInfo->AlCount + 1 == $couponInfo->Count){
                        $couponInfo->state = 3;//已发放完毕，改为失效状态
                    }
                    $couponInfo->AlCount = $couponInfo->AlCount + 1;
                    $couponInfo->save();
                }
            }
            $transaction->commit();
        }catch (yii\db\Exception $e){
            $transaction->rollBack();
            $this->exitJSON(0,$e->getMessage());
        }
        $this->exitJSON(1,'',$res);
    }
    /**
     * 查询优惠券信息
     */
    public function actionQueryCoupon()
    {
        $id = $_POST['id'];
        if(empty($id)) $this->exitJSON(0,'Fail');
        $coupon = HiConfCoupon::find()->where("`ID` = {$id}")->asArray()->one();
        if(empty($coupon)) $this->exitJSON(0,'Fail');
        if($coupon['CourseId'] == 0){$coupon['CourseId'] = '通用';}
        //有效期
        if($coupon['EffectiveWay'] == 1){
            $coupon['EffectiveTime'] = date('Y-m-d H:i:s',$coupon['EffectiveTime1']).' <br>~<br> '.date('Y-m-d H:i:s',$coupon['EffectiveTime2']);
        }else{
            $coupon['EffectiveTime'] = $coupon['EffectiveDay'].'天';
        }
        //领取方式
        $coupon['EffectiveWay'] = \common\enums\Coupon::labels()[\common\enums\Coupon::pfwvalues('COUPON_EFFECTIVE_WAY')[$coupon['EffectiveWay']]];

        if($coupon['CourseId'] == 0){$coupon['CourseId'] = '通用';}
        $this->exitJSON(1,'',$coupon);
    }

}