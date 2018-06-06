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

class WxArticleController extends BaseController
{
    public function __construct($id, $module, $config = [])
    {
        $this->enableCsrfValidation = false;//关闭scrf验证
        parent::__construct($id, $module, $config);
    }
    /**
     * 文章列表
     * @return string
     */
    public function actionIndex(){
        $query = HiWxArticle::find()->andWhere(1);
        $searchData = $this->searchForm($query, ['title','menu','is_show']);
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $users = $query->orderBy("ID asc")->offset($pages->offset)->limit($pages->limit)->all();
        //获取所有菜单
        $menuTmp = HiWxArticleMenu::find()->asArray()->all();
        $menuKey = array_column($menuTmp,'id');
        $menu = array_combine($menuKey, $menuTmp);
        $renderData = [
            'menu' => $menu,
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
     * 添加推荐文章
     * @return string
     */
    public function actionAdd(){

        if(Yii::$app->getRequest()->getIsPost()){
            $this->couponForm();
        }else{
            //获取所有菜单
            $menu = HiWxArticleMenu::find()->all();
            $renderData = ['menu' => $menu];
            return $this->display('form', $renderData);
        }
    }
    /**
     * 修改推荐文章
     * @return string
     */
    public function actionEdit(){
        if(Yii::$app->getRequest()->getIsPost()){
            $this->couponForm();
        }else {
            $id = intval(Yii::$app->getRequest()->get('id'));
            $row = HiWxArticle::findOne(['id' => $id]);
            $menu = HiWxArticleMenu::find()->all();//获取所有菜单
            $renderData = ['row' => $row,'menu' => $menu];
            return $this->display('form', $renderData);
        }
    }
    private function couponForm(){
        $id = intval( Yii::$app->getRequest()->post('id') );
        $data = Yii::$app->getRequest()->post();

        if( $id ){
            $admin = HiWxArticle::findOne( $id );
            $admin->menu = $data['menu'];
            $admin->title = $data['title'];
            $admin->introduction = $data['introduction'];
            $admin->is_show = $data['is_show'];
            $admin->url = $data['url'];
            $admin->img = $data['img'];
            $rtn = $admin->save();
        }else{
            if(empty($data['title'])) $this->exitJSON(0, '标题不能为空');
            if(empty($data['menu'])) $this->exitJSON(0, '请选择所属菜单');
            $data['time'] = time();
            $admin = new HiWxArticle();
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
    //删除文章
    public function actionDelArticle()
    {
        $id = Yii::$app->getRequest()->get('id');
        $res = HiWxArticle::deleteAll(['id' => $id]);
        if($res) $this->exitJSON(1, 'success!');
        $this->exitJSON(0, 'fail');
    }
    /**
     * 上传图片信息
     */
    public function actionUploadimg()
    {
        $return = array(
            'code' => 0,
            'image_id' => '',
            'pic' => '',
            'msg' => ''
        );
        $imgFile = @file_get_contents($_FILES['questionPic']['tmp_name']);
        $imgFileSize = @getimagesizefromstring($imgFile);
        if (!$imgFile || !$imgFileSize) {
            $return['msg'] = '不是图片或者出错了';
            exit(json_encode($return));
        }
        //保存地址
        $action = trim(Yii::$app->getRequest()->get('action'));
        $base_address = Yii::$app->params[$action];
        $isCreate = \common\helpers\Func::mkdirRecursion($base_address);//创建目录
        $file_name = date('YmdHis').'_'.rand(1,999).rand(1,999).'_'.$_FILES['questionPic']['name'];
        //保存数据
        if ($_FILES['questionPic']['error'] == 0){
            move_uploaded_file($_FILES['questionPic']['tmp_name'],$base_address.'/'.$file_name);
        }
        $return['code'] = 1;
        $return['pic'] = $file_name;
        $return['isCreate'] = $isCreate;
        $return['tmp'] = $_FILES['questionPic']['tmp_name'];
        exit(json_encode($return));
    }
}