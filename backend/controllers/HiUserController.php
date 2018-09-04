<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\HiUserInfo;
use common\models\HiUserMerge;
use common\models\HiUserInfoMerge;
use common\models\HiConfWritingScore;
use common\models\HiUserCourseAnswerMerge;
use common\models\HiUserCourseAnswer0;
use common\models\HiConfCourse;
use common\models\HiConfTopic;
use common\models\HiUserWritingImg;
use common\models\HiUserWritingScore;
use yii\data\Pagination;
use yii\db\Exception;
use yii\widgets\LinkPager;

class HiUserController extends BaseController
{
    public function __construct($id, $module, $config = [])
    {
        $this->enableCsrfValidation = false;//关闭scrf验证
        parent::__construct($id, $module, $config);
    }
    /**
     * 注册用户信息列表
     * @return string
     */
    public function actionIndex(){
        $query = HiUserMerge::find()->alias('a')
            ->select(['a.Uid','a.UserName','a.Time','a.Channel','a.Mobile','b.EnName','b.school_type','b.birth','b.Gold'])
            ->innerJoin('hi_user_info_merge as b','a.Uid = b.Uid')
            ->andWhere(1);
        $searchData = $this->searchForm($query, ['a.UserName', 'a.Mobile']);
        //注册时间
        if(!empty($_GET['Time1'])){
            $searchData['Time1'] = $_GET['Time1'];
            $activated_time = strtotime($_GET['Time1']);
            $query = $query->andWhere("Time >= '{$activated_time}'");
        }
        if(!empty($_GET['Time2'])){
            $searchData['Time2'] = $_GET['Time2'];
            $activated_time = strtotime($_GET['Time2']);
            $query = $query->andWhere("Time <= '{$activated_time}'");
        }
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $users = $query->orderBy("Time desc")->asArray()->offset($pages->offset)->limit($pages->limit)->all();
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
        //问卷调查的答案分值配置
        $points = array(
            1 => array(1 => 1,2 => 2,3 => 3,4 => 4),
            2 => array(1 => 0,2 => 1,3 => 2,4 => 3,5 => 4,6 => 5),
            3 => array(1 => 0,2 => 1,3 => 2,4 => 3,5 => 4,6 => 5),
            4 => array(1 => 0,2 => 1,3 => 2,4 => 3,5 => 4,6 => 5),
            5 => array(1 => 0,2 => 2,3 => 2,4 => 2),
            6 => array(1 => 0,2 => 1,3 => 2,4 => 4),
        );
        $uid = \Yii::$app->getRequest()->get('id');
        if(empty($uid)) header("Location:http:/index.php?r=hi-user/index");
        //获取用户信息
        $user = HiUserMerge::findOne(['Uid' => $uid]);
        //获取问卷调查题目信息
        $connection = \Yii::$app->hiread;
        $sql = "select * from hi_conf_research";
        $research = $connection->createCommand($sql)->queryAll();
        //去掉最后一个题目
        array_pop($research);
        //获取用户问卷调查答案
        $suffix = substr($uid, -1);
        $sql = "select * from hi_user_survey_{$suffix} where uid = '{$uid}'";
        $result = $connection->createCommand($sql)->queryOne();
        $answer = $result['Questions'];
        if(!empty($answer)){
            $answer = json_decode($answer,true);
        }
        //获取用户订单
        $orderTab = 'hi_user_order_'.$suffix;
        $orderDetailTab = 'hi_user_order_detail_'.$suffix;
        $orderDetailSql = "select b.CourseId,b.`Time` from {$orderTab} a INNER JOIN  {$orderDetailTab} b ON a.ID = b.Oid WHERE a.Uid = '{$uid}' and a.Status = 1";
        $userOrder = $connection->createCommand($orderDetailSql)->queryAll();
        if(!empty($userOrder)){
            foreach ($userOrder as &$val){
                $val['level'] = '';//级别
                $val['expire'] = '';//有效期
                $val['starTime'] = 0;//开始时间
                $val['courseName'] = '';//课程名称
                $val['study'] = '';//学习进度
                $val['isTry'] = 0;//是否试听
                //获取课程信息
                if(!empty($val['CourseId'])){
                    $userCourseTab1 = 'hi_user_course_'.$suffix;
                    $userCourseSql1 = "select IsTry,`Time` from {$userCourseTab1} where Uid = '{$uid}' and Course = '{$val['CourseId']}' ORDER by id DESC ";
                    $userCourse1 = $connection->createCommand($userCourseSql1)->queryOne();

                    $userCourseTab = 'hi_user_course_unit_'.$suffix;
                    $userCourseSql = "select CourseID,UnitId,SUnitId from {$userCourseTab} where Uid = '{$uid}' and CourseID = '{$val['CourseId']}' ORDER by SUnitId DESC ";
                    $userCourse = $connection->createCommand($userCourseSql)->queryOne();
                    if(!empty($userCourse)){
                        //课程信息
                        $courseTab = 'hi_conf_course';
                        $courseSql = "select ProdName,`Level`,`Expire`,`ProdName` from {$courseTab} where ID = '{$userCourse['CourseID']}'";
                        $course = $connection->createCommand($courseSql)->queryOne();
                        //单元信息
                        $unitTab = 'hi_conf_unit';
                        $unitSql = "select Name from {$unitTab} where ID = '{$userCourse['UnitId']}'";
                        $unit = $connection->createCommand($unitSql)->queryOne();
                        //子单元信息
                        $subUnitTab = 'hi_conf_sub_unit';
                        $subUnitSql = "select Name from {$subUnitTab} where ID = '{$userCourse['SUnitId']}'";
                        $subUnit = $connection->createCommand($subUnitSql)->queryOne();
                        //得到学习进度
                        $val['level'] = $course['Level'];//级别
                        $val['expire'] = $course['Expire'];//有效期
                        $val['starTime'] = $userCourse1['Time'];//开始时间
                        $val['courseName'] = $course['ProdName'];//课程名称
                        $val['study'] = $course['ProdName'].'-'.$unit['Name'].'_'.$subUnit['Name'];//学习进度
                        $val['isTry'] = $userCourse1['IsTry'];//是否试听
                    }
                }//end if
            }//end foreach
        }//end if
//        echo '<pre>';
//        print_r($userOrder);
//        exit;
        $renderData = [
            'user' => $user,
            'research' => $research,
            'answer' => $answer,
            'points' => $points,
            'userOrder' => $userOrder,
        ];
        return $this->display('info',$renderData);
    }
    /**
    *修改用户信息
    */
    public function actionEdit()
    {
        if(\Yii::$app->getRequest()->getIsPost()){
            $transaction = \Yii::$app->hiread->beginTransaction();
            try{
                $uid = empty($_POST['id']) ? 0 : $_POST['id'];
                $table = 'hi_user_info_'.substr($uid,-1,1);
                //修改原始表
                $source = HiUserInfo::findOnex($table,['Uid' => $uid]);
                $res = time() - (intval($_POST['age']) - 1)*3600*24*365;
                if($res <= 0) $res = 0;
                if(!empty($res)) $source->birth = $res;
                $source->EnName = $_POST['en_name'];
                $source->school_type = $_POST['school_type'];
                $source->save();
                //修改合并表
                $sourceTotal = HiUserInfoMerge::findOne(['Uid' => $uid]);
                if(!empty($res)) $sourceTotal->birth = $res;
                $sourceTotal->EnName = $_POST['en_name'];
                $sourceTotal->school_type = $_POST['school_type'];
                $sourceTotal->save();
                $transaction->commit();
            }catch (Exception $e){
                $transaction->rollBack();
                $this->exitJSON(0,'fail!');
            }
            $this->exitJSON(1,'修改成功',[]);
        }else {
            $uid = \Yii::$app->getRequest()->get('id',0);
            if(empty($uid)) $this->exitJSON(0,'fail!');
            //查询用户信息
            $query = HiUserMerge::find()->andWhere('Uid = '.$uid)->asArray()->one();
            //查询用户及时信息
            $table = 'hi_user_info_'.substr($uid,-1,1);
            $connection  = \Yii::$app->hiread;
            $sql = "select * from {$table} where Uid = {$uid}";
            $command = $connection->createCommand($sql);
            $user = $command->queryOne();
            $user['user_name'] = $query['UserName'];
            $user['mobile'] = $query['Mobile'];
            $data = [
                'row' => $user,
            ];
            return $this->display('form',$data);
        }
        
    }
    /**
     * 查询金币数量
     */
    public function actionQueryGold()
    {
        $uid = $_POST['uid'];
        if(empty($uid)) $this->exitJSON(0,'fail!');
        $table = 'hi_user_info_'.substr($uid,-1,1);
        //查询用户现有金币
        $connection  = \Yii::$app->hiread;
        $sql = "select * from {$table} where Uid = {$uid}";
        $command = $connection->createCommand($sql);
        $res = $command->queryOne();
        if(empty($res)){
            $this->exitJSON(0,'fail!');
        }
        $this->exitJSON(1,'',$res);
    }
    /**
     * 修改金币数量
     */
    public function actionUpdateGold()
    {
        $uid = $_POST['uid'];
        if(empty($uid)) $this->exitJSON(0,'fail!');
        $table = 'hi_user_info_'.substr($uid,-1,1);
        $add = intval($_POST['add_gold']);
        $minus = intval($_POST['minus_gold']);
        $final = $add - $minus;
        if(!empty($final)){
            $transaction = \Yii::$app->hiread->beginTransaction();
            try{
                //修改原始表
                $source = HiUserInfo::findOnex($table,['Uid' => $uid]);
                $source->Gold = $source->Gold + $final;
                $res = $source->save();
                //修改统计表
                $sourceTotal = HiUserMerge::findOne(['Uid' => $uid]);
                $sourceTotal->Gold = $sourceTotal->Gold + $final;
                $sourceTotal->save();
                $transaction->commit();
            }catch (Exception $e){
                $transaction->rollBack();
                $this->exitJSON(0,'fail!');
            }

//            $source->Gold = 10;
//            $userInfo = $model::findOne(1);
//            $userInfo->Gold = 188;
//            $res = $userInfo->save();
//            $connection  = \Yii::$app->hiread;
//            $sql = "update {$table} set Gold = Gold + {$final} where Uid = {$uid}";
//            $command = $connection->createCommand($sql);
//            $res = $command->execute();
        }
//        if(empty($res)){
//            $this->exitJSON(0,'fail!');
//        }
        $this->exitJSON(1,'',$res);
    }
    /**
    *用户作文列表
    */
    public function actionWriting()
    {
        $query = HiUserCourseAnswerMerge::find()->alias('a')
                ->innerJoin('hi_user_info_merge as b','a.Uid = b.Uid')
                ->select(['b.EnName','a.ID','a.Uid','a.Course','a.Tid','a.Score'])
                ->andWhere(1);
        $searchData = $this->searchForm($query, ['a.Uid', 'a.Score']);
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $list = $query->orderBy('Time desc')->asArray()->offset($pages->offset)->limit($pages->limit)->all();
        $renderData = [
            'list' => $list,
            'searchData' => $searchData,
            'pageHtml' => LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
            ])
        ];
        return $this->display('writing-list', $renderData);
    }
    /**
    *批改作文
    */
    public function actionModifyWriting()
    {
        if(\Yii::$app->getRequest()->getIsPost()){
            $data = \Yii::$app->getRequest()->post();
            $uid = $data['uid'];
            $id = $data['id'];
            $tid = $data['tid'];
            $comment = empty($data['comment']) ? '' : $data['comment'];
            $type = $data['type'];
            $checked = empty($data['checked']) ? [] : $data['checked'];
            $modify = $data['modify'];
            $totalScore = $data['score'];
            //保存修改数据
            try {
                $transaction = \Yii::$app->hiread->beginTransaction();
                //保存合并数据
                $admin = HiUserCourseAnswerMerge::findOne(['Uid' => $uid,'ID'=> $id]);
                if(!$admin) throw new Exception("数据不存在");
                if(!empty($comment)) $admin->Comment = $comment;
                $admin->Modify = $modify;
                $admin->Score = $totalScore;
                $rtn = $admin->save();
                //保存分表数据
                $table = 'hi_user_course_answer_'.substr($uid,-1,1);
                $hiUserAn = HiUserCourseAnswer0::findOnex($table,['Uid' => $uid]);
                if(!$admin) throw new Exception("数据不存在");
                if(!empty($comment)) $hiUserAn->Comment = $comment;
                if(!empty($modify)) $hiUserAn->Modify = $modify;
                $hiUserAn->Score = $totalScore;
                $rtn = $hiUserAn->save();
                //保存得分
                HiUserWritingScore::deleteAll(['uid' => $uid,'tid' => $tid]);
                foreach ($checked as $val) {
                    if(empty($val)) continue;
                    $model = new HiUserWritingScore();
                    $addData = [
                        'uid' => $uid,
                        'tid' => $tid,
                        'score_id' => $val,
                    ];
                    $model->setAttributes($addData, false);
                    $model->insert();
                }
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollBack();
                $this->exitJSON(0, $e->getMessage());
            }
            $this->exitJSON(1, 'success!');
        }else{
            $id = \Yii::$app->getRequest()->get('id');
            $uid = \Yii::$app->getRequest()->get('uid');
            $writing = HiUserCourseAnswerMerge::find()->where("ID = $id and Uid = $uid")->asArray()->one();
            //获取题目信息
            $question = HiConfTopic::findOne($writing['Tid']);
            //获取课程信息
            $course = HiConfCourse::findOne($writing['Course']);
            //获取用户信息
            $uid = $writing['Uid'];
            $table = 'hi_user_info_'.substr($uid,-1,1);
            $userInfo = HiUserInfo::findOnex($table,['Uid' => $uid]);
            //获取用户上传的图片
            $imgs = HiUserWritingImg::findAll(['uid' => $uid,'tid' => $writing['Tid']]);
            //获取得分点
            $scorePoint = HiConfWritingScore::find()->where(['level' => $course['HLevel']])->asArray()->all();
            $scoreRule = [];
            foreach($scorePoint as $val){
                $scoreRule[$val['type']][$val['item']][$val['point']][] = $val;
            }
            //获取用户得分
            $userScore = HiUserWritingScore::find()->where(['uid' => $uid,'tid' => $writing['Tid']])->asArray()->all();
            if(!empty($userScore)){
                $userScore = array_column($userScore,'score_id');
            }

            $total = 0;
            $type = '1';
            foreach($userScore as $val){
                $conf = HiConfWritingScore::find()->where(['id' => $val])->asArray()->one();
                $type = $conf['type'];
                if(empty($conf)){
                    $this->exitJSON(0, '配置出错');
                }
                $total += $conf['score'];
            };
            if(!empty($userScore)){
                $total = round($total/count($userScore),2);
            }
            if(1 <= $total && $total <= 1.74){
                $des = 'Try Harder';
            }elseif(1.75 <= $total && $total <= 2.49){
                $des = 'Average';
            }elseif(2.5 <= $total && $total <= 3.24){
                $des = 'Good';
            }elseif(3.25 <= $total && $total <= 4){
                $des = 'Excellent';
            }else{
                $des = '';
            }
            $renderData = [
                'type' => $type,
                'total_des' => $des,
                'total_score' => $total,
                'user_score' => $userScore,
                'score_rule' => $scoreRule,
                'img' => $imgs,
                'question' => $question,
                'course' => $course,
                'user_info' => $userInfo,
                'writing' => $writing,
            ];
            return $this->display('modify-writing',$renderData);
        }
    }
    public function actionComputeTotalScore()
    {
        $data = \Yii::$app->getRequest()->post();
        if(empty($data['checked'])){
            $this->exitJSON(0, '请先打分');
        }
        $total = 0;
        $count = 0;
        foreach($data['checked'] as $val){
            if(empty($val)) continue;
            $conf = HiConfWritingScore::find()->where(['id' => $val])->asArray()->one();
            if(empty($conf)){
                $this->exitJSON(0, '配置出错');
            }
            $total += $conf['score'];
            $count = $count + 1;
        };
        $total = round($total/$count,2);
        if(1 <= $total && $total <= 1.74){
            $des = 'Try Harder';
        }elseif(1.75 <= $total && $total <= 2.49){
            $des = 'Average';
        }elseif(2.5 <= $total && $total <= 3.24){
            $des = 'Good';
        }elseif(3.25 <= $total && $total <= 4){
            $des = 'Excellent';
        }else{
            $des = '';
        }
        $this->exitJSON(1,'',['total_score' => $total,'total_des' => $des]);
    }
    /**
    *上传批改的图片
    */
    public function actionUploadModifyImg()
    {
        $data = [];
        $baseAddress = \Yii::$app->params['teachers_upload'];
        $viewAddress = \Yii::$app->params['view_teachers_upload'];
        foreach ($_FILES as $key => $val) {
            $imgFile = @file_get_contents($val['tmp_name']);
            $imgFileSize = @getimagesizefromstring($imgFile);
            if (!$imgFile || !$imgFileSize) {
                continue;
            }
            $isCreate = \common\helpers\Func::mkdirRecursion($baseAddress);//创建目录
            $file_name = date('YmdHis').'_'.rand(1,999).rand(1,999).'_'.$val['name'];
            //保存数据
            if ($val['error'] == 0){
                move_uploaded_file($val['tmp_name'],$baseAddress.$file_name);
            }
            $data[] = \Yii::$app->params['static_hiread'].$viewAddress.$file_name;
        }
        return json_encode(['errno' => 0,'data' => $data]);
    }
    /**
    *作文得分点配置
    */
    public function actionConfWriting()
    {
        $query = HiConfWritingScore::find()->andWhere(1);
        $searchData = $this->searchForm($query, ['id', 'level', 'type', 'item', 'point', 'score','weight']);
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $list = $query->orderBy('id desc')->asArray()->offset($pages->offset)->limit($pages->limit)->all();
        $renderData = [
            'list' => $list,
            'searchData' => $searchData,
            'pageHtml' => LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
            ])
        ];
        return $this->display('conf-writing', $renderData);
    }
    /**
     * 添加作文得分点配置
     * @return string
     */
    public function actionAddWriting(){
        if(\Yii::$app->getRequest()->getIsPost()){
            $this->writingForm();
        }else{
            $renderData = [];
            return $this->display('form-writing', $renderData);
        }
    }
    /**
     * 修改作文得分点配置
     * @return string
     */
    public function actionEditWriting(){
        if(\Yii::$app->getRequest()->getIsPost()){
            $this->writingForm();
        }else {
            $id = intval(\Yii::$app->getRequest()->get('id'));
            $row = HiConfWritingScore::findOne(['ID' => $id]);
            $renderData = ['row' => $row];
            return $this->display('form-writing', $renderData);
        }
    }
    private function writingForm(){
        $id = intval( \Yii::$app->getRequest()->post('id') );
        $data = \Yii::$app->getRequest()->post();

        if( $id ){
            $admin = HiConfWritingScore::findOne( $id );
            if(empty($data['level'])) $this->exitJSON(0, '等级不能为空');
            if(empty($data['type'])) $this->exitJSON(0, '请选择类型！');
            if(empty($data['item'])) $this->exitJSON(0, '得分项目不能为空！');
            if(empty($data['point'])) $this->exitJSON(0, '得分点不能为空！');
            if(empty($data['name'])) $this->exitJSON(0, '得分项目名称不能为空');
            if(empty($data['score'])) $this->exitJSON(0, '分值不能为空');
            if(empty($data['weight'])) $this->exitJSON(0, '权重不能为空');

            $admin->level = $data['level'];
            $admin->type = $data['type'];
            $admin->item = $data['item'];
            $admin->point = $data['point'];
            $admin->name= $data['name'];
            $admin->score= $data['score'];
            $admin->weight= $data['weight'];
            $rtn = $admin->save();
        }else{
            if(empty($data['level'])) $this->exitJSON(0, '等级不能为空');
            if(empty($data['type'])) $this->exitJSON(0, '请选择类型！');
            if(empty($data['item'])) $this->exitJSON(0, '得分项目不能为空！');
            if(empty($data['point'])) $this->exitJSON(0, '得分点不能为空！');
            if(empty($data['name'])) $this->exitJSON(0, '得分项目名称不能为空');
            if(empty($data['score'])) $this->exitJSON(0, '分值不能为空');
            if(empty($data['weight'])) $this->exitJSON(0, '权重不能为空');

            $admin = new HiConfWritingScore();
            $admin->setAttributes($data, false);
            $rtn = $admin->insert();
            $id = $admin->id;
        }
        if( $rtn ){
            $this->exitJSON(1, 'Success!');
        }else{
            $this->exitJSON(0, 'Fail!',$data);
        }
    }
    /**
     * 删除作文得分点配置
     */
    public function actionDelWriting()
    {
        $id = \Yii::$app->getRequest()->get('id');
        if(empty($id)){
            $this->exitJSON(0, 'Fail!');
        }
        $result = HiConfWritingScore::findOne($id)->delete();
        if($result){
            $this->exitJSON(1, 'success!');
        }else{
            $this->exitJSON(0, 'Fail!');
        }
    }

}