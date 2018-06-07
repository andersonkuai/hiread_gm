<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\HiWxArticleTheme;
use yii;
use yii\data\Pagination;
use yii\widgets\LinkPager;

class WxArticleThemeController extends BaseController
{
    public function __construct($id, $module, $config = [])
    {
        $this->enableCsrfValidation = false;//关闭scrf验证
        parent::__construct($id, $module, $config);
    }
    /**
     * 菜单列表
     * @return string
     */
    public function actionIndex(){
        $query = HiWxArticleTheme::find()->andWhere(1);
        $searchData = $this->searchForm($query, ['theme']);
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $users = $query->orderBy("ID asc")->offset($pages->offset)->limit($pages->limit)->all();
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
     * 添加菜单
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
     * 修改主题
     * @return string
     */
    public function actionEdit(){
        if(Yii::$app->getRequest()->getIsPost()){
            $this->couponForm();
        }else {
            $id = intval(Yii::$app->getRequest()->get('id'));
            $row = HiWxArticleTheme::findOne(['id' => $id]);
            $renderData = ['row' => $row];
            return $this->display('form', $renderData);
        }
    }
    private function couponForm(){
        $id = intval( Yii::$app->getRequest()->post('id') );
        $data = Yii::$app->getRequest()->post();

        if( $id ){
            $admin = HiWxArticleTheme::findOne( $id );
            $admin->theme = $data['theme'];
            $admin->img = $data['img'];
            $rtn = $admin->save();
        }else{
            if(empty($data['theme'])) $this->exitJSON(0, '主题不能为空');
            $admin = new HiWxArticleTheme();
            $admin->setAttributes($data, false);
            $rtn = $admin->insert();
            $id = $admin->id;
        }
        if( $rtn ){
            $this->exitJSON(1, 'Success!');
        }else{
            $this->exitJSON(0, 'Fail!');
        }
    }
    //删除主题
    public function actionDel()
    {
        $id = Yii::$app->getRequest()->get('id');
        $res = HiWxArticleTheme::deleteAll(['id' => $id]);
        if($res) $this->exitJSON(1, 'success!');
        $this->exitJSON(0, 'fail');
    }
}