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
use common\models\HiConfCourseCatalog;
use common\models\HiConfCourseOutline;
use common\models\HiConfCoursePackage;
use common\models\HiConfCourseWord;
use common\models\HiConfDayRead;
use common\models\HiConfExtensive;
use common\models\HiConfExtensiveTopic;
use common\models\HiConfExtensiveTopicAnswer;
use common\models\HiConfExtensiveTopicList;
use common\models\HiConfSubUnit;
use common\models\HiConfSubUnitTrain;
use common\models\HiConfTopic;
use common\models\HiConfUnit;
use yii\data\Pagination;
use yii\db\Exception;
use yii\widgets\LinkPager;
use Yii;

class CourseController extends BaseController
{
    public function __construct($id, $module, $config = [])
    {
        date_default_timezone_set('PRC');
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
            //课程包
            $renderData['package'] = HiConfCoursePackage::findAll(['CourseId' => $courseId]);
            //大纲
            $renderData['outline'] = HiConfCourseOutline::findAll(['CourseId' => $courseId]);
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
                //课程包
                if(!empty($_POST['FileName'])){
                    foreach ($_POST['FileName'] as $k=>$v){
                        if(empty($v)) continue;
                        $packageModel = new HiConfCoursePackage();
                        //添加课程包
                        $addData = array(
                            'CourseId' => $courseId,
                            'FileName' => $v,
                            'FileSize' => $_POST['FileSize'][$k]
                        );
                        $packageModel->setAttributes($addData,true);
                        $packageModel->insert();
                    }
                }//end if
                //课程大纲
                if(!empty($_POST['intensive_outline_name'])){
                    foreach ($_POST['intensive_outline_name'] as $k=>$v){
                        if(empty($v)) continue;
                        $outlineModel = new HiConfCourseOutline();
                        //添加大纲
                        $addData = array(
                            'CourseId' => $courseId,
                            'Name' => $v,
                            'Desc' => $_POST['intensive_outline_desc'][$k]
                        );
                        $outlineModel->setAttributes($addData,false);
                        $outlineModel->insert();
                    }

                }//end if
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
            $transaction = Yii::$app->hiread->beginTransaction();
            try{
                $attr = $course->attributeLabels();//表字段
                $updateData = array_intersect_key($data, $attr);
                $courseSource = HiConfCourse::findOne($id);
                if(!empty($updateData)){
                    foreach ($updateData as $k=>$v){
                        $courseSource->$k = $v;
                    }
                }
                $rtn = $courseSource->save();
                //课程包
                HiConfCoursePackage::deleteAll(['CourseId' => $id]);//删除课程包
                if(!empty($_POST['FileName'])){
                    foreach ($_POST['FileName'] as $k=>$v){
                        if(empty($v)) continue;
                        $packageModel = new HiConfCoursePackage();
                        //添加课程包
                        $addData = array(
                            'CourseId' => $id,
                            'FileName' => $v,
                            'FileSize' => $_POST['FileSize'][$k]
                        );
                        $packageModel->setAttributes($addData,false);
                        $packageModel->insert();
                    }

                }//end if
                //课程大纲
                HiConfCourseOutline::deleteAll(['CourseId' => $id]);//删除课程大纲
                if(!empty($_POST['intensive_outline_name'])){
                    foreach ($_POST['intensive_outline_name'] as $k=>$v){
                        if(empty($v)) continue;
                        $outlineModel = new HiConfCourseOutline();
                        //添加大纲
                        $addData = array(
                            'CourseId' => $id,
                            'Name' => $v,
                            'Desc' => $_POST['intensive_outline_desc'][$k]
                        );
                        $outlineModel->setAttributes($addData,false);
                        $outlineModel->insert();
                    }

                }//end if
                $transaction->commit();
            }catch (Exception $e){
                $error = $e->getMessage();
                $transaction->rollBack();
                //修改失败
                $this->exitJSON(0, $error);
            }
            $this->exitJSON(1, 'Success!');
        }//end if
    }

    /**
     * 课程结构
     */
    public function actionStructure()
    {
        //开放日期格式化
        date_default_timezone_set('PRC');
        $courseId = Yii::$app->getRequest()->get('id');
        //查看泛读
        $extensive = HiConfExtensive::findAll(['CourseId' => $courseId]);
        //查看单元（精读）
        $unit = HiConfUnit::find()->joinWith(['subUnit'])->select(
            'hi_conf_unit.ID,hi_conf_unit.CourseId,hi_conf_unit.Name Name,hi_conf_unit.OpenDay')
            ->where(['hi_conf_unit.CourseId' => $courseId])->asArray()->indexBy('ID')->all();
        $renderData['extensive'] = $extensive;
        $renderData['unit'] = $unit;
        $renderData['courseId'] = $courseId;
        return $this->display('structure_empty', $renderData);
    }
    /**
     * 添加泛读
     */
    public function actionAddExtensive()
    {
        $courseId = intval( Yii::$app->getRequest()->get('courseId') );
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doExtensiveForm($courseId);
        }else{
            return $this->display('extensive_form');
        }
    }
    /**
     * 修改泛读
     */
    public function actionEditExtensive()
    {
        $courseId = intval( Yii::$app->getRequest()->get('courseId') );
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doExtensiveForm($courseId);
        }else{
            $extensiveId = Yii::$app->getRequest()->get('extensiveId');
            $extensive = HiConfExtensive::findOne(['ID' => $extensiveId]);
            $renderData['extensive'] = $extensive;
            return $this->display('extensive_form',$renderData);
        }
    }
    /**
     * @param $courseId 课程id
     * 泛读操作
     */
    private function DoExtensiveForm($courseId)
    {
        if(empty($courseId)) $this->exitJSON(0, '课程id不能为空');
        $extensiveId = intval( Yii::$app->getRequest()->post('extensiveId') );
        $data = Yii::$app->getRequest()->post();
        if(!empty($data['OpenDay'])){
            $data['OpenDay'] = strtotime($data['OpenDay']);
        }
        $extensiveModel = new HiConfExtensive();
        if(empty($extensiveId)){
            //添加泛读
            $data = array(
                'CourseId' => $courseId,
                'Title' => $data['Title'],
                'Video' => $data['Video'],
                'Poster' => $data['Poster'],
                'OpenDay' => empty($data['OpenDay']) ? 0 : $data['OpenDay'],
            );
            $extensiveModel->setAttributes($data, false);
            $rtn = $extensiveModel->insert();
            if($rtn){
                $this->exitJSON(1, 'Success!');
            }
        }else{
            $data = array(
                'CourseId' => $courseId,
                'Title' => $data['Title'],
                'Video' => $data['Video'],
                'Poster' => $data['Poster'],
                'OpenDay' => empty($data['OpenDay']) ? 0 : $data['OpenDay'],
            );
            $extensive = new HiConfExtensive();
            $attr = $extensive->attributeLabels();//表字段
            $updateData = array_intersect_key($data, $attr);
            $source = HiConfExtensive::findOne($extensiveId);
            if(!empty($updateData)){
                foreach ($updateData as $k=>$v){
                    $source->$k = $v;
                }
            }
            $rtn = $source->save();
//            $rtn = $source->updateAttributes($updateData);
            if ($rtn){
                $this->exitJSON(1, 'success');
            }else{
                $this->exitJSON(0, 'Fail!',$updateData);
            }
        }//end if
        $this->exitJSON(0, 'Fail!',$data);
    }
    /**
     * 删除泛读
     */
    public function actionDelExtensive()
    {
        $extensiveId = Yii::$app->getRequest()->get('extensiveId');
        $transaction = Yii::$app->hiread->beginTransaction();
        try{
            //删除相关题目
            $topic = HiConfExtensiveTopicList::findAll(['ExtId' => $extensiveId]);
            if(!empty($topic)){
                foreach ($topic as $k=>$v){
                    $questions = explode('|',$v['Questions']);
                    if(!empty($questions)){
                        foreach ($questions as $key=>$val){
                            HiConfExtensiveTopic::deleteAll(['ID' => $val]);//删除题目
                            HiConfExtensiveTopicAnswer::deleteAll(['Tid' => $val]);//删除答案
                        }
                    }//end if
                }
            }
//            HiConfExtensive::deleteAll(['ID' => $extensiveId]);//删除泛读
            HiconfExtensive::findOne($extensiveId)->delete();//删除泛读
            HiConfExtensiveTopicList::deleteAll(['ExtId' => $extensiveId]);//删除泛读题目中间表
            $transaction->commit();
        }catch (Exception $e){
            $error = $e->getMessage();
            $transaction->rollBack();
            //添加失败
            $this->exitJSON(0, '删除失败！',$error);
        }
        $this->exitJSON(1, 'Success!');
    }
    /**
     * 添加单元
     */
    public function actionAddUnit()
    {
        $courseId = intval( Yii::$app->getRequest()->get('courseId') );
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doUnitForm($courseId);
        }else{
            return $this->display('unit_form');
        }
    }
    /**
     * 删除单元
     */
    public function actionDelUnit()
    {
        $unitId = intval( Yii::$app->getRequest()->get('unitId') );
        if(empty($unitId)){
            $this->exitJSON(0, '单元ID不能为空!');
        }
        $transaction = Yii::$app->hiread->beginTransaction();
        try{
            $subUnit = HiConfSubUnit::findAll(['UnitId' => $unitId]);
            if(!empty($subUnit)){
                foreach ($subUnit as $k=>$v){
                    HiConfTopic::deleteAll(['SUnitId' => $v['ID']]);
                    HiConfSubUnit::deleteAll(['ID' => $v['ID']]);
                    HiConfSubUnitTrain::deleteAll(['SUnitId' => $v['ID']]);
                }
            }
            //删除单元信息
            HiConfUnit::deleteAll(['ID' => $unitId]);
            $transaction->commit();
            $this->exitJSON(1, 'success');
        }catch (Exception $e){
            $this->exitJSON(0, 'Fail!');
        }

    }
    /**
     * 修改单元
     */
    public function actionEditUnit()
    {
        $courseId = intval( Yii::$app->getRequest()->get('courseId') );
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doUnitForm($courseId);
        }else{
            $unitId = Yii::$app->getRequest()->get('unitId');
            $unit = HiConfUnit::findOne(['ID' => $unitId]);
            $renderData['unit'] = $unit;
            return $this->display('unit_form',$renderData);
        }
    }
    private function DoUnitForm($courseId)
    {
        if(empty($courseId)) $this->exitJSON(0, '课程id不能为空');
        $unitId = intval( Yii::$app->getRequest()->post('unitId') );
        $data = Yii::$app->getRequest()->post();
        if(!empty($data['OpenDay'])){
            $data['OpenDay'] = strtotime($data['OpenDay']);
        }
        $unitModel = new HiConfUnit();
        if(empty($unitId)){
            $transaction = Yii::$app->hiread->beginTransaction();
            try{
                //添加泛读
                $extensiveData = array(
                    'CourseId' => $courseId,
                    'Name' => $data['Name'],
                    'OpenDay' => empty($data['OpenDay']) ? 0 : $data['OpenDay'],
                );
                $unitModel->setAttributes($extensiveData, false);
                $rtn = $unitModel->insert();
                $id = $unitModel->ID;
                //添加子单元
                if(!empty($data['subUnitName'])){
                    $insertData = [];
                    foreach ($data['subUnitName'] as $k=>$v){
                        if(empty($v)) continue;
                        $insertData[] = array($id,$data['subUnitType'][$k],$v,1);
                    }
                    if(!empty($insertData)){
                        $subUnit = new HiConfSubUnit();
                        $subUnit->insertAll($insertData);
                    }
                }
                $transaction->commit();
                $this->exitJSON(1, 'success!',$data);
            }catch (Exception $e){
                $error = $e->getMessage();
                $transaction->rollBack();
                //添加失败
                $this->exitJSON(0, $error);
            }
            $this->exitJSON(1, 'Success2!');
        }else{
            $updateData1 = array(
                'Name' => $data['Name'],
                'OpenDay' => empty($data['OpenDay']) ? 0 : $data['OpenDay'],
            );
            $unitModel = new HiConfUnit();
            $attr = $unitModel->attributeLabels();//表字段
            $updateData = array_intersect_key($updateData1, $attr);
            $source = HiConfUnit::findOne($unitId);
//            $rtn = $source->updateAttributes($updateData);
            if(!empty($updateData)){
                foreach ($updateData as $k=>$v){
                    $source->$k = $v;
                }
            }
            $rtn = $source->save();
            if ($rtn){
                $this->exitJSON(1, 'success');
            }else{
                $this->exitJSON(0, 'Fail!',$updateData);
            }
        }//end if
        $this->exitJSON(0, 'Fail!',$data);
    }

    /**
     * 添加子单元
     * @return string
     */
    public function actionAddSubUnit()
    {
        $unitId = intval( Yii::$app->getRequest()->get('unitId') );
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doSubUnitForm($unitId);
        }else{
            //获取单元信息
            $unit = HiConfUnit::findOne(['ID' => $unitId])->toArray();
            $renderData['unit'] = $unit;
            return $this->display('sub_unit_form',$renderData);
        }
    }
    /**
     * 修改子单元
     * @return string
     */
    public function actionEditSubUnit()
    {
        $unitId = intval( Yii::$app->getRequest()->get('unitId') );
        $subUnitId = intval( Yii::$app->getRequest()->get('subUnitId') );
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doSubUnitForm($unitId);
        }else{
            //获取单元信息
            $unit = HiConfUnit::findOne(['ID' => $unitId])->toArray();
            $renderData['unit'] = $unit;
            //获取子单元
            $subUnit = HiConfSubUnit::findOne(['ID' => $subUnitId])->toArray();
            $renderData['subUnit'] = $subUnit;
            return $this->display('sub_unit_form',$renderData);
        }
    }
    private function DoSubUnitForm($unitId)
    {
        if(empty($unitId)) $this->exitJSON(0, '单元id不能为空');
        $subUnitId = intval( Yii::$app->getRequest()->post('subUnitId') );
        $data = Yii::$app->getRequest()->post();
        $model = new HiConfSubUnit();
        if(empty($subUnitId)){
            //添加子单元
            $insertData = array(
                'UnitId' => $unitId,
                'Type' => $data['Type'],
                'Name' => $data['Name'],
            );
            $model->setAttributes($insertData, false);
            $rtn = $model->insert();
            if($rtn){
                $this->exitJSON(1, 'Success!');
            }
        }else{
            //修改子单元
            $updateData1 = array(
                'UnitId' => $unitId,
                'Type' => $data['Type'],
                'Name' => $data['Name'],
            );
            $subUnitModel = new HiConfSubUnit();
            $attr = $subUnitModel->attributeLabels();//表字段
            $updateData = array_intersect_key($updateData1, $attr);
            $source = HiConfSubUnit::findOne($subUnitId);
//            $rtn = $source->updateAttributes($updateData);
            if(!empty($updateData)){
                foreach ($updateData as $k=>$v){
                    $source->$k = $v;
                }
            }
            $rtn = $source->save();
            if ($rtn){
                $this->exitJSON(1, 'success');
            }else{
                $this->exitJSON(0, 'Fail!',$updateData);
            }
        }//end if
        $this->exitJSON(0, 'Fail!',$data);
    }
    /**
     * 删除子单元
     */
    public function actionDelSubUnit()
    {
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        if(empty($subUnitId)){
            $this->exitJSON(0, 'Fail!');
        }
        $result = $this->delsubUnitTopic($subUnitId);
        if($result){
            $this->exitJSON(1, 'Success!');
        }else{
            $this->exitJSON(0, 'Fail!');
        }
    }
    /**
     * 删除子单元和子单元下面的题目
     */
    private function delsubUnitTopic($subUnitId)
    {
        $transaction = Yii::$app->hiread->beginTransaction();
        try{
            HiConfTopic::deleteAll(['SUnitId' => $subUnitId]);
//            HiConfSubUnit::deleteAll(['ID' => $subUnitId]);
            HiConfSubUnit::findOne($subUnitId)->delete();
            HiConfSubUnitTrain::deleteAll(['SUnitId' => $subUnitId]);
            $transaction->commit();
        }catch (Exception $e){
            $error = $e->getMessage();
            $transaction->rollBack();
            //添加失败
            return false;
        }
        return true;
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
        $isCreate = \common\helpers\Func::mkdirRecursion($base_address);//创建目录
        $file_name = date('s').'_'.uniqid().'_'.$_FILES['questionPic']['name'];
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
    /**
     * 课程目录
     */
    public function actionCatalog()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        //获取课程目录
        $catalog = HiConfCourseCatalog::find()->where(['SUnitId' => $subUnitId])->asArray()->all();
        $renderData['catalog'] = $catalog;
        return $this->display('catalog', $renderData);
    }
    /**
     * 添加课程目录
     */
    public function actionAddCatalog()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doCataLogForm();
        }else{
            return $this->display('catalog_form');
        }
    }
    /**
     * 修改课程目录
     */
    public function actionEditCatalog()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        $catalogId = Yii::$app->getRequest()->get('catalogId');
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doCataLogForm();
        }else{
            //获取课程目录信息
            $catalog = HiConfCourseCatalog::find()->where(['ID' => $catalogId])->asArray()->one();
            $renderData['row'] = $catalog;
            return $this->display('catalog_form',$renderData);
        }
    }

    /**
     * 删除课程目录
     */
    public function actionDelCatalog()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        $catalogId = Yii::$app->getRequest()->get('catalogId');
        if(empty($catalogId)){
            $this->exitJSON(0, 'Fail!');
        }
//        $result = HiConfCourseCatalog::deleteAll(['ID' => $catalogId]);
        $result = HiConfCourseCatalog::findOne($catalogId)->delete();
        if($result){
            $this->exitJSON(1, 'success!');
        }else{
            $this->exitJSON(0, 'Fail!');
        }
    }
    private function doCataLogForm()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        $id = Yii::$app->getRequest()->post('catalogId');
        $data = Yii::$app->getRequest()->post();
        $data['CourseId'] = $courseId;
        $data['SUnitId'] = $subUnitId;
        $transaction = Yii::$app->hiread->beginTransaction();
        try{
            if(!empty($id)){
                //修改数据
                $model = new HiConfCourseCatalog();
                $attr = $model->attributeLabels();//表字段
                $updateData = array_intersect_key($data, $attr);
                $courseSource = HiConfCourseCatalog::findOne($id);
//                $rtn = $courseSource->updateAttributes($updateData);
                if(!empty($updateData)){
                    foreach ($updateData as $k=>$v){
                        $courseSource->$k = $v;
                    }
                }
                $rtn = $courseSource->save();
            }else{
                //添加数据
                $model = new HiConfCourseCatalog();
                $model->setAttributes($data,false);
                $model->save();
            }
            $transaction->commit();
        }catch (Exception $e){
            $error = $e->getMessage();
            $transaction->rollBack();
            $this->exitJSON(0, $error);
        }
        $this->exitJSON(1, 'success!');
    }
    /**
     * 视频词汇表
     */
    public function actionWord()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        //获取课程目录
        $catalog = HiConfCourseWord::find()->where(['SUnitId' => $subUnitId])->asArray()->all();
        $renderData['catalog'] = $catalog;
        return $this->display('word', $renderData);
    }
    /**
     * 添加视频词汇
     */
    public function actionAddWord()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doWordForm();
        }else{
            return $this->display('word_form');
        }
    }
    /**
     * 修改课程视频词汇
     */
    public function actionEditWord()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        $catalogId = Yii::$app->getRequest()->get('catalogId');
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doWordForm();
        }else{
            //获取课程目录信息
            $catalog = HiConfCourseWord::find()->where(['ID' => $catalogId])->asArray()->one();
            $renderData['row'] = $catalog;
            return $this->display('word_form',$renderData);
        }
    }
    /**
     * 删除课程视频词汇
     */
    public function actionDelWord()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        $catalogId = Yii::$app->getRequest()->get('catalogId');
        if(empty($catalogId)){
            $this->exitJSON(0, 'Fail!');
        }
//        $result = HiConfCourseWord::deleteAll(['ID' => $catalogId]);
        $result = HiConfCourseWord::findOne($catalogId)->delete();
        if($result){
            $this->exitJSON(1, 'success!');
        }else{
            $this->exitJSON(0, 'Fail!');
        }
    }
    private function doWordForm()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        $id = Yii::$app->getRequest()->post('id');
        $data = Yii::$app->getRequest()->post();
        $data['CourseId'] = $courseId;
        $data['SUnitId'] = $subUnitId;
        $transaction = Yii::$app->hiread->beginTransaction();
        try{
            if(!empty($id)){
                //修改数据
                $model = new HiConfCourseWord();
                $attr = $model->attributeLabels();//表字段
                $updateData = array_intersect_key($data, $attr);
                $courseSource = HiConfCourseWord::findOne($id);
//                $rtn = $courseSource->updateAttributes($updateData);
                if(!empty($updateData)){
                    foreach ($updateData as $k=>$v){
                        $courseSource->$k = $v;
                    }
                }
                $rtn = $courseSource->save();
            }else{
                //添加数据
                $model = new HiConfCourseWord();
                $model->setAttributes($data,false);
                $model->save();
            }
            $transaction->commit();
        }catch (Exception $e){
            $error = $e->getMessage();
            $transaction->rollBack();
            $this->exitJSON(0, $error);
        }
        $this->exitJSON(1, 'success!');
    }
    /**
     * 每日朗读
     */
    public function actionRead()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $unitId = Yii::$app->getRequest()->get('unitId');
        //获取课程目录
        $catalog = HiConfDayRead::find()->where(['UnitID' => $unitId])->asArray()->all();
        $renderData['catalog'] = $catalog;
        return $this->display('read', $renderData);
    }
    /**
     * 添加每日朗读
     */
    public function actionAddRead()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $unitId = Yii::$app->getRequest()->get('unitId');
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doReadForm();
        }else{
            return $this->display('read_form');
        }
    }
    /**
     * 修改每日朗读
     */
    public function actionEditRead()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $unitId = Yii::$app->getRequest()->get('unitId');
        $id = Yii::$app->getRequest()->get('id');
        if(Yii::$app->getRequest()->getIsPost()){
            $this->doReadForm();
        }else{
            //获取课程目录信息
            $catalog = HiConfDayRead::find()->where(['ID' => $id])->asArray()->one();
            $renderData['row'] = $catalog;
            return $this->display('read_form',$renderData);
        }
    }
    /**
     * 删除每日阅读
     */
    public function actionDelRead()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $unitId = Yii::$app->getRequest()->get('unitId');
        $id = Yii::$app->getRequest()->get('id');
        if(empty($id)){
            $this->exitJSON(0, 'Fail!');
        }
//        $result = HiConfDayRead::deleteAll(['ID' => $id]);
        $result = HiConfDayRead::findOne($id)->delete();
        if($result){
            $this->exitJSON(1, 'success!');
        }else{
            $this->exitJSON(0, 'Fail!');
        }
    }
    private function doReadForm()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('unitId');
        $id = Yii::$app->getRequest()->post('id');
        $data = Yii::$app->getRequest()->post();
        $data['CourseId'] = $courseId;
        $data['UnitID'] = $subUnitId;
        $transaction = Yii::$app->hiread->beginTransaction();
        try{
            if(empty($data['Chapter'])){
                throw new Exception('章节不能为空');
            }
            if(empty($data['Page'])){
                throw new Exception('页码不能为空');
            }
            if(!empty($id)){
                //修改数据
                $model = new HiConfDayRead();
                $attr = $model->attributeLabels();//表字段
                $updateData = array_intersect_key($data, $attr);
                $courseSource = HiConfDayRead::findOne($id);
//                $rtn = $courseSource->updateAttributes($updateData);
                if(!empty($updateData)){
                    foreach ($updateData as $k=>$v){
                        $courseSource->$k = $v;
                    }
                }
                $rtn = $courseSource->save();
            }else{
                //添加数据
                $model = new HiConfDayRead();
                $model->setAttributes($data,false);
                $model->save();
            }
            $transaction->commit();
        }catch (Exception $e){
            $error = $e->getMessage();
            $transaction->rollBack();
            $this->exitJSON(0, $error);
        }
        $this->exitJSON(1, 'success!');
    }
}