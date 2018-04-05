<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;

use common\models\HiConfCategory;
use common\models\HiConfCourse;
use common\models\HiConfCourseOutline;
use common\models\HiConfCoursePackage;
use common\models\HiConfExtensive;
use common\models\HiConfExtensiveTopic;
use common\models\HiConfExtensiveTopicAnswer;
use common\models\HiConfExtensiveTopicList;
use common\models\HiConfSubUnit;
use common\models\HiConfUnit;
use yii\data\Pagination;
use yii\db\Exception;
use yii\widgets\LinkPager;
use Yii;

class CourseController extends BaseController
{
    public function __construct($id, $module, $config = [])
    {
        $this->enableCsrfValidation = false;//关闭scrf验证
        parent::__construct($id, $module, $config);

    }
    /**
     * 课程列表
     * @return string
     */
    public function actionIndex(){
        $query = HiConfCourse::find()->select(['CategoryName' => 'hi_conf_category.name',
            'hi_conf_course.ProdName', 'BookName' => 'hi_conf_course.Name','CourseId' => 'hi_conf_course.ID',
            'CourseTime','Price','DiscountPrice','Expire','Level','MinAge','MaxAge',
            ])
            ->innerJoin('hi_conf_category','hi_conf_course.Category = hi_conf_category.ID')
            ->andWhere(1);
        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' => 20]);
        $orders = $query->orderBy("hi_conf_course.ID desc")->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        $renderData = [
            'orders' => $orders,
            'searchData' => "",
            'pageHtml' => LinkPager::widget([
                'pagination' => $pages,
                'options' => ['class' => 'pagination pagination-sm no-margin pull-right']
            ])
        ];
        return $this->display('index', $renderData);
    }
    /**
     * 添加课程
     */
    public function actionAdd(){

        if(Yii::$app->getRequest()->getIsPost()){
            $this->doForm();
        }else{
            //获取课程类型
            $category = HiConfCategory::find()->all();
            $renderData = [];
            $renderData['category'] = $category;
            return $this->display('form', $renderData);
        }
    }
    /**
     * 修改课程
     */
    public function actionEdit(){
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doForm();
        }else{
            //获取课程类型
            $category = HiConfCategory::find()->all();
            $renderData = [];
            $renderData['category'] = $category;
            //获取课程相关信息
            $courseId = Yii::$app->getRequest()->get('id');
            if (!empty($courseId)){
                $course = HiConfCourse::findOne(['ID' => $courseId])->toArray();
            }
            $renderData['row'] = !empty($course) ? $course : array();
            return $this->display('form', $renderData);
        }
    }
    /**
     * 存储数据
     */
    public function doForm()
    {
        $id = intval( Yii::$app->getRequest()->post('ID') );
        $data = Yii::$app->getRequest()->post();
        //开放日期格式化
        date_default_timezone_set('PRC');
        if(!empty($data['OpenDay'])){
            $data['OpenDay'] = strtotime($data['OpenDay']);
        }
        if(empty($id)){
            //添加课程（事物）
            $course = new HiConfCourse();
            $transaction = Yii::$app->hiread->beginTransaction();
            try{
                $course->setAttributes($data,false);
                $result = $course->save();
                if (!$result){
                    throw new Exception('插入课程数据失败');
                }
                $courseId = $course->ID;
                if (empty($courseId)){
                    throw new Exception('插入课程数据失败');
                }
                $transaction->commit();
            }catch (Exception $e){
                $error = $e->getMessage();
                $transaction->rollBack();
                //添加失败
                $this->exitJSON(0, $error);
            }
            //添加成功
            $this->exitJSON(1, 'Success!');
        }else{
            //修改课程
            $course = new HiConfCourse();
            $attr = $course->attributeLabels();//表字段
            $updateData = array_intersect_key($data, $attr);
            $courseSource = HiConfCourse::findOne($id);
            $rtn = $courseSource->updateAttributes($updateData);
            if ($rtn){
                $this->exitJSON(1, 'success');
            }else{
                $this->exitJSON(0, 'fail!',$updateData);
            }
        }//end if
    }

    /**
     * 配置题目
     */
    public function actionTopic()
    {
        date_default_timezone_set('PRC');
        if(Yii::$app->getRequest()->getIsPost()){
            //存储题目数据/答案数据/泛读题目表
            $data = Yii::$app->getRequest()->post();
            $transaction = Yii::$app->hiread->beginTransaction();
            try{
                $extensiveId = $data['extensiveId'];//泛读id
                //删除原有数据
                $questionAlready = HiConfExtensiveTopicList::find()->where(['ExtId' => $extensiveId])->asArray()->all();
                if(!empty($questionAlready)){
                    foreach ($questionAlready as $k=>$v){
                        $questionAlreadyArray = explode('|',$v['Questions']);
                        //删除数据
                        HiConfExtensiveTopicAnswer::deleteAll(['Tid' => $questionAlreadyArray]);
                        HiConfExtensiveTopic::deleteAll(['ID' => $questionAlreadyArray]);
                        HiConfExtensiveTopicList::deleteAll(['ID' => $v['ID']]);
                    }
                }//end if
                //添加数据
                if (!empty($data['Title'])){
                    $topicIDList = array();
                    foreach ($data['Title'] as $k=>$v){
                        if(empty($v)){
                            continue;
                        }
                        //保存题目
                        $topic = array(
                            'Title' => $v,//题目标题
                            'Image' => $data['Image'][$k],//题目图片
                            'Audio' => $data['Audio'][$k],//题目音频
                            'QAudio' => $data['QAudio'][$k],//题目描述音频
                            'Analysis' => $data['Analysis'][$k],//题目解析
                            'AAudio' => $data['AAudio'][$k],//题目解析音频
                            'AVideo' => $data['AVideo'][$k],//题目解析视频
                            'Translate' => $data['Translate'][$k],//翻译
                            'Help' => $data['Help'][$k],//提示信息
                            'Gold' => !empty($data['Gold'][$k]) ? $data['Gold'][$k] : 0,//获得金币数量
                            'IsTrain' => $data['IsTrain'][$k],//是否是练习题目
                            'Category' => $data['Category'][$k],//CCSS细项
                        );
                        $extensiveTopic = new HiConfExtensiveTopic();
                        $extensiveTopic->setAttributes($topic,false);
                        $extensiveTopic->save();
                        $topicId = Yii::$app->hiread->getLastInsertID();
                        $topicIDList[] = $topicId;
                        //保存答案
                        $correctAnswer = array();//正确答案
                        if(!empty($data['answerName'][$k])){
                            foreach ($data['answerName'][$k] as $key=>$val){
                                $answer = array(
                                    'Tid' => $topicId,
                                    'Name' => $val,
                                    'Image' => $data['answerImage'][$k][$key],
                                    'Show' => $data['answerShow'][$k][$key],
                                    'Pair1Text' => $data['answerPair1Text'][$k][$key],
                                    'Pair1Audio' => $data['answerPair1Audio'][$k][$key],
                                    'Pair1Img' => $data['answerPair1Img'][$k][$key],
                                    'Pair2Text' => $data['answerPair2Text'][$k][$key],
                                    'Pair2Audio' => $data['answerPair2Audio'][$k][$key],
                                    'Pair2Img' => $data['answerPair2Img'][$k][$key],
                                );
                                $extensiveTopicAnswer = new HiConfExtensiveTopicAnswer();
                                $extensiveTopicAnswer->setAttributes($answer,false);
                                $extensiveTopicAnswer->save();
                                $answerId = Yii::$app->hiread->getLastInsertID();
                                //标记正确答案
                                if($data['isTrue'][$k][$key] == '1'){
                                    $correctAnswer[] = $answerId;
                                }
                            }//end foreach
                        }//end if
                        //更新题目的正确答案
                        if(!empty($correctAnswer)){
                            $correctAnswerStr = implode('|',$correctAnswer);
                            HiConfExtensiveTopic::updateAll(['Correct' => $correctAnswerStr], ['ID' => $topicId]);
                        }
                    }
                    //保存泛读视频题目列表
                    if(!empty($topicIDList)){
                        $insertData = array(
                            'ExtId' => $extensiveId,
                            'Questions' => implode('|',$topicIDList),
                            'Min' => !empty($data['appearMin']) ? $data['appearMin'] : 0,
                            'Sec' => !empty($data['appearSec']) ? $data['appearSec'] : 0,
                        );
                        $extensiveTopicList = new HiConfExtensiveTopicList();
                        $extensiveTopicList->setAttributes($insertData,false);
                        $extensiveTopicList->save();
                    }
                }//end if
                $transaction->commit();
            }catch (Exception $e){
                $error = $e->getMessage();
                $transaction->rollBack();
                //添加失败
                $this->exitJSON(0, $error);
            }
            $this->exitJSON(0, 'this is error',$data);
        }else{
            $courseId = Yii::$app->getRequest()->get('id');
            $extensive = HiConfExtensive::findAll(['CourseId' => $courseId]);
            if (!empty($extensive)){//泛读
                $renderData['readType'] = 'extensive';
                //获取泛读题目列表
                $extensiveList = HiConfExtensive::find()->where(['CourseId' => $courseId])->asArray()->all();
                if(!empty($extensiveList)){
                    foreach ($extensiveList as $k=>&$v){
                        //获取题目列表
                        $extensiveTopicList = HiConfExtensiveTopicList::find()->where(['ExtId' => $v['ID']])->asArray()->all();
                        if(!empty($extensiveTopicList)){
                            $topic = $extensiveTopicList['0'];
                            $questionId = explode('|',$topic['Questions']);
                            if(!empty($questionId)){
                                $test = array();
                                foreach ($questionId as $key=>$val){
                                    //查询问题答案
                                    $question = HiConfExtensiveTopic::findOne(['ID' => $val])->toArray();
                                    $question['answer'] = HiConfExtensiveTopicAnswer::findAll(['Tid' => $val]);
                                    $test[$val] = $question;
                                }
                                $topic['Questions'] = $test;
                                $v['extensiveTopicList'] = $topic;
                            }//end if
                        }//end if
                    }
                }
//                if(!empty($extensiveList)){
//                    foreach ($extensiveList as $k=>&$v){
//                        $toplic = array();
//                        if(!empty($v['extensiveTopicList'])){
//                            $toplic = $v['extensiveTopicList'][0];
//                            $questionId = explode('|',$v['extensiveTopicList'][0]['Questions']);
//                            if(!empty($questionId)){
//                                $test = array();
//                                foreach ($questionId as $key=>$val){
//                                    //查询问题答案
//                                    $question = HiConfExtensiveTopic::findOne(['ID' => $val])->toArray();
//                                    $question['answer'] = HiConfExtensiveTopicAnswer::findAll(['Tid' => $val]);
//                                    $test[$val] = $question;
//                                }
//                                $toplic['Questions'] = $test;
//                            }//end if
//                        }
//                        $v['extensiveTopicList'] = $toplic;
//                    }//end foreach
//                }//end if
                //获取题目类型
                $renderData['extensive'] = $extensive;
                $renderData['extensiveTopicList'] = $extensiveList;
//                echo '<pre>';
//                print_r($renderData['extensiveTopicList']);
//                exit;
                return $this->display('extensive_topic', $renderData);
            }else{//精读
                echo 1234;
            }
        }//end if
    }

    /**
     * 配置课程结构
     */
    public function actionStructure()
    {
        //开放日期格式化
        date_default_timezone_set('PRC');
        if(Yii::$app->getRequest()->getIsPost()){
            $data = Yii::$app->getRequest()->post();
            $read_type = trim(Yii::$app->getRequest()->post('read_type'));
            $courseId = intval( Yii::$app->getRequest()->post('id') );
            //先删除相关数据
            $transaction = Yii::$app->hiread->beginTransaction();
            try{
                HiConfCourseOutline::deleteAll(['CourseId' => $courseId]);//删除课程大纲
                HiConfCoursePackage::deleteAll(['CourseId' => $courseId]);//删除课程包
                $unit = HiConfUnit::findAll(['CourseId' => $courseId]);//查询单元信息
                $unitId = array();
                foreach ($unit as $v){
                    $unitId[] = $v['ID'];
                }
                HiConfSubUnit::deleteAll(['UnitId' => $unitId]);//删除子单元
                HiConfUnit::deleteAll(['CourseId' => $courseId]);//删除单元
                HiConfExtensive::deleteAll(['CourseId' => $courseId]);//删除泛读信息
                //新增数据
                if($read_type == 'extensive'){
                    //泛读
                    if(!empty($_POST['extensiveTitle'])){
                        foreach ($_POST['extensiveTitle'] as $k=>$val){
                            if (empty($val)) continue;
                            $extensiveData[] = array(
                                $courseId,
                                $val,
                                $_POST['extensiveVideo'][$k],
                                $_POST['extensivePoster'][$k],
                                strtotime($_POST['extensiveOpenDay'][$k]),
                            );
                        }
                        if (!empty($extensiveData)){
                            $extensiveModel = new HiConfExtensive();
                            $extensiveModel->insertAll($extensiveData);
                        }
                    }
                }else{//精读
                    //课程包
                    if(!empty($_POST['FileName'])){
                        foreach ($_POST['FileName'] as $k=>$v){
                            if(empty($v)) continue;
                            $packageData[] = array($courseId,$v,$_POST['FileSize'][$k]);
                        }
                        if(!empty($packageData)){
                            $coursePackage = new HiConfCoursePackage();
                            $coursePackage->insertAll($packageData);
                        }
                    }//end if
                    if(!empty($_POST['intensive_outline_name'])){
                        //大纲
                        foreach ($_POST['intensive_outline_name'] as $k=>$v){
                            if(empty($v)) continue;
                            $courseOutlineData[] = array($courseId,$v,$_POST['intensive_outline_desc'][$k]);
                        }
                        if (!empty($courseOutlineData)){
                            $courseOutline = new HiConfCourseOutline();
                            $courseOutline->insertAll($courseOutlineData);
                        }
                    }//end if

                }
                $transaction->commit();
            }catch (Exception $e){
                $error = $e->getMessage();
                $transaction->rollBack();
                //添加失败
                $this->exitJSON(0, $error);
            }
            $this->exitJSON(1, 'success!');
        }else{
            $courseId = Yii::$app->getRequest()->get('id');
            //获取课程信息
            $course = $courseSource = HiConfCourse::findOne($courseId);
            //精度
            //课程包
            $package = HiConfCoursePackage::findAll(['CourseId' => $courseId]);
            //大纲
            $outline = HiConfCourseOutline::findAll(['CourseId' => $courseId]);
            //单元
            $unit = HiConfUnit::find()->joinWith(['subUnit'])->select(
                'hi_conf_unit.ID,hi_conf_unit.CourseId,hi_conf_unit.Name,hi_conf_unit.OpenDay,hi_conf_sub_unit.Type,hi_conf_sub_unit.Name')
                ->where(['hi_conf_unit.CourseId' => $courseId])->asArray()->all();
            //泛读
            $extensive = HiConfExtensive::findAll(['CourseId' => $courseId]);
            $renderData = array();
            $renderData['course'] = $course;
            $renderData['package'] = $package;
            $renderData['outline'] = $outline;
            $renderData['extensive'] = $extensive;
            $renderData['unit'] = $unit;
            return $this->display('structure', $renderData);
        }

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
        switch ($action){
            case 'Poster':
                $base_address = Yii::$app->params['extensive_cover_img'];//泛读封面
                break;
            case 'CoverImg':
                $base_address = Yii::$app->params['cover_img'];//课程封面
                break;
            case 'DetailImg':
                $base_address = Yii::$app->params['detail_img'];//课程简介图片
                break;
            case 'Author':
                $base_address = Yii::$app->params['author_img'];//作者头像
                break;
            case 'extensive_topic_img':
                $base_address = Yii::$app->params['extensive_topic_img'];//泛读题目图片
                break;
            case 'extensive_topic_audio':
                $base_address = Yii::$app->params['extensive_topic_audio'];//泛读题目音频
                break;
            case 'extensive_answer_image':
                $base_address = Yii::$app->params['extensive_answer_image'];//泛读答案图片
                break;
            case 'extensive_answer_Pair1Img':
                $base_address = Yii::$app->params['extensive_answer_Pair1Img'];//泛读答案配对图片1
                break;
            default :
                exit(json_encode($return));
                break;
        }
        \common\helpers\Func::mkdirRecursion($base_address);//创建目录
        $file_name = date('YmdHis').'_'.uniqid().'_'.$_FILES['questionPic']['name'];
        //保存数据
        if ($_FILES['questionPic']['error'] == 0){
            move_uploaded_file($_FILES['questionPic']['tmp_name'],$base_address.'/'.$file_name);
        }
        $return['code'] = 1;
        $return['pic'] = $file_name;
        exit(json_encode($return));
    }
    /**
     * 上传视频信息
     */
    public function actionUploadvideo()
    {
        $return = array(
            'code' => 0,
            'image_id' => '',
            'pic' => '',
            'msg' => ''
        );
        $File = @file_get_contents($_FILES['VideoSource']['tmp_name']);
        if (!$File) {
            $return['msg'] = '出错了';
            exit(json_encode($return));
        }
        //保存地址
        $base_address = Yii::$app->params['extensive_video'];

        \common\helpers\Func::mkdirRecursion($base_address);//创建目录
        $file_name = date('YmdHis').'_'.uniqid().'_'.$_FILES['VideoSource']['name'];
        //保存数据
        if ($_FILES['VideoSource']['error'] == 0){
            move_uploaded_file($_FILES['VideoSource']['tmp_name'],$base_address.'/'.$file_name);
        }
        $return['code'] = 1;
        $return['pic'] = $file_name;
        exit(json_encode($return));
    }
    /**
     * 上传课程包
     */
    public function actionUploadPackage()
    {
        $return = array(
            'code' => 0,
            'image_id' => '',
            'pic' => '',
            'msg' => ''
        );
        $File = @file_get_contents($_FILES['package']['tmp_name']);
        if (!$File) {
            $return['msg'] = '出错了';
            exit(json_encode($return));
        }
        //保存地址
        $base_address = Yii::$app->params['package'];

        \common\helpers\Func::mkdirRecursion($base_address);//创建目录
        $file_name = date('YmdHis').'_'.uniqid().'_'.$_FILES['package']['name'];
        //保存数据
        if ($_FILES['package']['error'] == 0){
            move_uploaded_file($_FILES['package']['tmp_name'],$base_address.'/'.$file_name);
        }
        $return['code'] = 1;
        $return['size'] = round($_FILES['package']['size']/1024,2).' KB';
        $return['pic'] = $file_name;
        exit(json_encode($return));
    }
    /**
     * 上传文件
     */
    public function actionUploadFile()
    {
        $return = array(
            'code' => 0,
            'image_id' => '',
            'pic' => '',
            'msg' => ''
        );
        $imgFile = @file_get_contents($_FILES['questionPic']['tmp_name']);
        if (!$imgFile) {
            $return['msg'] = '出错了';
            exit(json_encode($return));
        }
        //保存地址
        $action = trim(Yii::$app->getRequest()->get('action'));
        $base_address = Yii::$app->params[$action];
        \common\helpers\Func::mkdirRecursion($base_address);//创建目录
        $file_name = date('YmdHis').'_'.uniqid().'_'.$_FILES['questionPic']['name'];
        //保存数据
        if ($_FILES['questionPic']['error'] == 0){
            move_uploaded_file($_FILES['questionPic']['tmp_name'],$base_address.'/'.$file_name);
        }
        $return['code'] = 1;
        $return['pic'] = $file_name;
        exit(json_encode($return));
    }
}