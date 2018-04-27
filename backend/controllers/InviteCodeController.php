<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\HiConfCoupon;
use common\models\HiInviteCode;
use common\models\HiUserMerge;
use yii;
use yii\data\Pagination;
use yii\widgets\LinkPager;

class InviteCodeController extends BaseController
{
    public function __construct($id, $module, $config = [])
    {
        $this->enableCsrfValidation = false;//关闭scrf验证
        parent::__construct($id, $module, $config);
    }
    /**
     * 邀请码列表
     * @return string
     */
    public function actionIndex(){
        $query = HiInviteCode::find()->andWhere(1);
        $searchData = $this->searchForm($query, ['Code','UserName']);
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $users = $query->orderBy("ID asc")->offset($pages->offset)->limit($pages->limit)->all();
        if(!empty($users)){
            //获取邀请码注册用户数
            $count_init = HiUserMerge::find()->select(['count'=>'count(Uid)','InviteCode'])->groupBy('InviteCode')->asArray()->all();
            $count = [];
            if(!empty($count_init)){
                foreach ($count_init as $val){
                    if(empty($val['InviteCode'])) continue;
                    $count[$val['InviteCode']] = $val;
                }
            }
//            echo '<pre>';
//            print_r($count);
//            exit;
        }
        $renderData = [
            'count' => $count,
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
     * 添加邀请码
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
     * 修改邀请码
     * @return string
     */
    public function actionEdit(){
        if(Yii::$app->getRequest()->getIsPost()){
            $this->couponForm();
        }else {
            $id = intval(Yii::$app->getRequest()->get('id'));
            $row = HiInviteCode::findOne(['ID' => $id]);
            $renderData = ['row' => $row];
            return $this->display('form', $renderData);
        }
    }
    private function couponForm(){
        $id = intval( Yii::$app->getRequest()->post('id') );
        $data = Yii::$app->getRequest()->post();

        if( $id ){
            $admin = HiInviteCode::findOne( $id );
            $admin->Code = $data['Code'];
            $admin->UserName = $data['UserName'];
            $rtn = $admin->save();
        }else{
            if(empty($data['Code'])) $this->exitJSON(0, '代金券名称不能为空');
            $admin = new HiInviteCode();
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
     * 分配邀请码
     */
    public function actionAllot()
    {
        if(empty($_POST['id'])){
            $this->exitJSON(0, '没有此邀请码！');
        }else{
            $admin = HiInviteCode::findOne( $_POST['id'] );
            $admin->UserName = $_POST['username'];
            $rtn = $admin->save();
            if(!empty($rtn)){
                $this->exitJSON(1, 'Success!');
            }
        }
        $this->exitJSON(0, 'Fail!');
    }

}