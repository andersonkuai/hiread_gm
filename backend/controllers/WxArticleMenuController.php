<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\HiWxArticleMenu;
use common\models\HiWxArticle;
use yii;
use yii\data\Pagination;
use yii\widgets\LinkPager;

class WxArticleMenuController extends BaseController
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
        $query = HiWxArticleMenu::find()->andWhere(1);
        $searchData = $this->searchForm($query, ['name','is_show']);
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
     * 修改菜单
     * @return string
     */
    public function actionEdit(){
        if(Yii::$app->getRequest()->getIsPost()){
            $this->couponForm();
        }else {
            $id = intval(Yii::$app->getRequest()->get('id'));
            $row = HiWxArticleMenu::findOne(['id' => $id]);
            $renderData = ['row' => $row];
            return $this->display('form', $renderData);
        }
    }
    private function couponForm(){
        $id = intval( Yii::$app->getRequest()->post('id') );
        $data = Yii::$app->getRequest()->post();

        if( $id ){
            $admin = HiWxArticleMenu::findOne( $id );
            $admin->name = $data['name'];
            $admin->order = intval($data['order']);
            $admin->is_show = $data['is_show'];
            $rtn = $admin->save();
        }else{
            if(empty($data['name'])) $this->exitJSON(0, '名称不能为空');
            $data['order'] = intval($data['order']); 
            $admin = new HiWxArticleMenu();
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
    //删除菜单
    public function actionDelArticle()
    {
        $id = Yii::$app->getRequest()->get('id');
        $res = HiWxArticleMenu::deleteAll(['id' => $id]);
        if($res) $this->exitJSON(1, 'success!');
        $this->exitJSON(0, 'fail');
    }
}