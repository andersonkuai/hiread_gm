<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\AdminLog;
use yii\data\Pagination;
use yii\widgets\LinkPager;

class AdminLogController extends BaseController
{
    public function __construct($id, $module, $config = [])
    {
        date_default_timezone_set('PRC');
        $this->enableCsrfValidation = false;//关闭scrf验证
        parent::__construct($id, $module, $config);
    }
    /**
     * 操作日志列表
     * @return string
     */
    public function actionIndex(){
        $query = AdminLog::find()->andWhere(1);
        $searchData = $this->searchForm($query, ['route', 'user_id', 'ip','table','user_name','action']);
        //操作时间
        if(!empty($_GET['Time1'])){
            $searchData['Time1'] = $_GET['Time1'];
            $activated_time = strtotime($_GET['Time1']);
            $query = $query->andWhere("created_at >= '{$activated_time}'");
        }
        if(!empty($_GET['Time2'])){
            $searchData['Time2'] = $_GET['Time2'];
            $activated_time = strtotime($_GET['Time2']);
            $query = $query->andWhere("created_at <= '{$activated_time}'");
        }
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $users = $query->orderBy("created_at desc")->offset($pages->offset)->limit($pages->limit)->all();
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
     * 用户详情
     */
    public function actionInfo(){

        return $this->display('info');
    }

}