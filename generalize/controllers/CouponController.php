<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\HiConfCoupon;
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
     * 代金券列表
     * @return string
     */
    public function actionIndex(){
        $query = HiConfCoupon::find()->andWhere(1);
        $searchData = $this->searchForm($query, ['Name', 'Type']);
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $users = $query->orderBy("ID desc")->offset($pages->offset)->limit($pages->limit)->all();
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
     * 添加代金券
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
     * 修改管理员
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
            $admin->Name = $data['Name'];
            $admin->Type = $data['Type'];
            $admin->Price = $data['Price'];
            $admin->Expire = $data['Expire'];
            $rtn = $admin->save();
        }else{
            if(empty($data['Name'])) $this->exitJSON(0, '代金券名称不能为空');
            if(empty($data['Type'])) $this->exitJSON(0, '类型不能为空');
            if(empty($data['Price'])) $this->exitJSON(0, '面值不能为空');
            if(empty($data['Expire'])) $this->exitJSON(0, '有效期不能为空');
            $admin = new HiConfCoupon();
            $admin->setAttributes($data, false);
            $rtn = $admin->insert();
            $id = $admin->ID;
        }
        if( $rtn ){
            $this->exitJSON(1, 'Success!');
        }else{
            $this->exitJSON(0, 'Fail!');
        }
    }
    /**
     * 删除代金券
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

}