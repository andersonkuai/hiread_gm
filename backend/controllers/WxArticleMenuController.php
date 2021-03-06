<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\HiWxArticleMenu;
use common\models\HiWxArticleTheme;
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
        $searchData = $this->searchForm($query, ['name','is_show','theme']);
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $users = $query->orderBy("ID asc")->offset($pages->offset)->limit($pages->limit)->all();
        //获取所有主题
        $theme_tmp = HiWxArticleTheme::find()->asArray()->all();
        $theme_id = array_column($theme_tmp, 'id');
        $theme = array_combine($theme_id, $theme_tmp);
        $renderData = [
            'theme' => $theme,
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
            //获取所有主题
            $theme = HiWxArticleTheme::find()->asArray()->all();
            $renderData = ['theme' => $theme];
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
            //获取所有主题
            $theme = HiWxArticleTheme::find()->asArray()->all();
            $renderData = ['row' => $row,'theme' => $theme];
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
            $admin->theme = $data['theme'];
            $rtn = $admin->save();
        }else{
            if(empty($data['name'])) $this->exitJSON(0, '名称不能为空');
            if(empty($data['theme'])) $this->exitJSON(0, '请选择主题');
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