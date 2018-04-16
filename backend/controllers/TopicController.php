<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/24
 * Time: 9:34
 */

namespace backend\controllers;
use common\models\HiConfExtensiveTopic;
use common\models\HiConfExtensiveTopicAnswer;
use common\models\HiConfExtensiveTopicList;
use common\models\HiConfSubUnitTrain;
use common\models\HiConfTopic;
use common\models\HiConfTopicAnswer;
use Yii;
use yii\db\Exception;

class TopicController extends BaseController
{
    public function __construct($id, $module, $config = [])
    {
        date_default_timezone_set('PRC');
        $this->enableCsrfValidation = false;//关闭scrf验证
        parent::__construct($id, $module, $config);
    }
    /**
     * 泛读题目列表
     * @return string
     */
    public function actionExtensiveIndex(){
        $courseId = Yii::$app->getRequest()->get('courseId');
        $extensiveId = Yii::$app->getRequest()->get('extensiveId');
        //获取泛读题目
        $topicList = HiConfExtensiveTopicList::find()->where(['ExtId' => $extensiveId])->asArray()->all();
        //保存题目排序
        if(Yii::$app->getRequest()->getIsPost()){
            if(!empty($_POST['topic_id'])){
                $orderData = array();
                foreach ($_POST['topic_id'] as $k=>$v){
                    $source = HiConfExtensiveTopic::findOne($v);
                    $source->Order = $_POST['topic_order'][$k];
                    $source->save();
                    $orderData[$v] = $_POST['topic_order'][$k];
                }
                asort($orderData);
                //修改题目列表排序规则
                if(!empty($topicList)){
                    foreach ($topicList as $k=>$v){
                        $lastList = array();
                        $questionIds = explode('|',$v['Questions']);
                        foreach ($orderData as $key => $val){
                            if(in_array($key,$questionIds)) $lastList[] = $key;
                        }
                        $lastListStr = implode('|',$lastList);
                        if(!empty($lastList) && $v['Questions'] != $lastListStr){
                            $source = HiConfExtensiveTopicList::findOne($v['ID']);
                            $source->Questions = $lastListStr;
                            $source->save();
                        }
                    }//end foreach
                }
            }//end if
        }
        //获取泛读题目
        $topicList = HiConfExtensiveTopicList::find()->where(['ExtId' => $extensiveId])->asArray()->all();
        $test = array();
        if(!empty($topicList)){
            $questionId = [];
            foreach ($topicList as $key=>$v){
                $questionIdArray = explode('|',$v['Questions']);
                if(!empty($questionIdArray)){
                    foreach ($questionIdArray as $question_key=>$question_val){
                        $questionId[] = [
                            'Min' => $v['Min'],
                            'Sec' => $v['Sec'],
                            'questionId' => $question_val,
                        ];
                    }
                }//end if
            }
            if(!empty($questionId)){
                foreach ($questionId as $key=>$val){
                    //查询问题答案
                    $question = HiConfExtensiveTopic::findOne(['ID' => $val['questionId']]);
                    if(!empty($question)){
                        $question = $question->toArray();
                        //加入问题弹出时间
                        $question['Min'] = $val['Min'];
                        $question['Sec'] = $val['Sec'];
                        $question['answer'] = HiConfExtensiveTopicAnswer::findAll(['Tid' => $val['questionId']]);
                        $test[$val['questionId']] = $question;
                    }
                }
            }//end if
        }//end if
        $renderData['question'] = $test;
        return $this->display('extensive-index', $renderData);
    }
    /**
     * 添加泛读题目
     */
    public function actionAddExtensiveQuestion()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $extensiveId = Yii::$app->getRequest()->get('extensiveId');
        if(Yii::$app->getRequest()->getIsPost()){
            $this->saveQuestion();
        }
        $renderData['extensiveId'] = $extensiveId;
        $renderData['courseId'] = $courseId;
        return $this->display('add-extensive-question', $renderData);
    }
    /**
     * 删除题目
     */
    public function actionDelExtensiveQuestion()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $extensiveId = Yii::$app->getRequest()->get('extensiveId');
        $questionId = Yii::$app->getRequest()->get('questionId');
        $transaction = Yii::$app->hiread->beginTransaction();
        try{
            HiConfExtensiveTopicAnswer::deleteAll(['Tid' => $questionId]);
//            HiConfExtensiveTopic::deleteAll(['ID' => $questionId]);
            HiConfExtensiveTopic::findOne($questionId)->delete();
            //更新泛读视频题目列表
            $list = HiConfExtensiveTopicList::find()->where(['ExtId' => $extensiveId])->all();
            if(!empty($list)){
                foreach ($list as $k=>$v){
                    $questionIds = explode('|',$v['Questions']);
                    if(!empty($questionIds)){
                        foreach ($questionIds as $key=>$val){
                            if($val == $questionId) unset($questionIds[$key]);
                        }
                        //更新数据表
                        $questionIdStr = implode('|',$questionIds);
                        if(!empty($questionIdStr)){
//                            HiConfExtensiveTopicList::updateAll(['Questions' => $questionIdStr], ['ID' => $v['ID']]);
                            $sourceObj = HiConfExtensiveTopicList::findOne($v['ID']);
                            $sourceObj->Questions = $questionIdStr;
                            $sourceObj->save();
                        }else{
//                            HiConfExtensiveTopicList::deleteAll(['ID' => $v['ID']]);
                            HiConfExtensiveTopicList::findOne($v['ID'])->delete();
                        }
                    }//end if
                }
            }
            $transaction->commit();
        }catch (Exception $e){
            $error = $e->getMessage();
            $transaction->rollBack();
            //添加失败
            $this->exitJSON(0, $error);
        }
        $this->exitJSON(1, 'success!');
    }
    /**
     * 修改泛读题目
     */
    public function actionEditExtensiveQuestion()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $extensiveId = Yii::$app->getRequest()->get('extensiveId');
        if(Yii::$app->getRequest()->getIsPost()){
            $this->saveQuestion();
        }
        $renderData['extensiveId'] = $extensiveId;
        $renderData['courseId'] = $courseId;
        //获取泛读题目
        $questionId = Yii::$app->getRequest()->get('questionId');
        $question = HiConfExtensiveTopic::find()->where(['ID' => $questionId])->asArray()->one();
        //获取答案
        $answer = HiConfExtensiveTopicAnswer::find()->where(['Tid' => $questionId])->all();
        $renderData['question'] = $question;
        $renderData['answer'] = $answer;
        //获取题目跳出时间
        $extensive = HiConfExtensiveTopicList::find()->where(['ExtId' => $extensiveId])->asArray()->all();
        if(!empty($extensive)){
            foreach ($extensive as $k=>$v){
                $questionIds = explode('|',$v['Questions']);
                if(in_array($questionId,$questionIds)){
                    $renderData['min'] = $v['Min'];
                    $renderData['sec'] = $v['Sec'];
                }
            }//end foreach
        }
        return $this->display('add-extensive-question', $renderData);
    }
    /**
     * 保存题目
     */
    private function saveQuestion()
    {
        //存储题目数据/答案数据/泛读题目表
        $data = Yii::$app->getRequest()->post();
        $transaction = Yii::$app->hiread->beginTransaction();
        try{
            $extensiveId = Yii::$app->getRequest()->get('extensiveId');//泛读id
            $questionId = $data['questionId'];//题目id
            if(empty($data['Title'])) $this->exitJSON(0, '题目不能为空');
            if(!empty($questionId)){
                //删除原有答案
                HiConfExtensiveTopicAnswer::deleteAll(['Tid' => $questionId]);
                //更新数据
                $model = new HiConfExtensiveTopic();
                $attr = $model->attributeLabels();//表字段
                $updateData = array_intersect_key($data, $attr);
                $courseSource = HiConfExtensiveTopic::findOne($questionId);
//                $rtn = $courseSource->updateAttributes($updateData);
                if(!empty($updateData)){
                    foreach ($updateData as $k=>$v){
                        $courseSource->$k = $v;
                    }
                }
                $rtn = $courseSource->save();
                //添加答案
                foreach ($data['answerName'] as $k=>$v){
                    $answer = array(
                        'Tid' => $questionId,
                        'Name' => $v,
                        'Image' => $data['answerImage'][$k],
                        'Show' => $data['answerShow'][$k],
                        'Pair1Text' => $data['answerPair1Text'][$k],
                        'Pair1Audio' => $data['answerPair1Audio'][$k],
                        'Pair1Img' => $data['answerPair1Img'][$k],
                        'Pair2Text' => $data['answerPair2Text'][$k],
                        'Pair2Audio' => $data['answerPair2Audio'][$k],
                        'Pair2Img' => $data['answerPair2Img'][$k],
                    );
                    $extensiveTopicAnswer = new HiConfExtensiveTopicAnswer();
                    $extensiveTopicAnswer->setAttributes($answer,false);
                    $extensiveTopicAnswer->save();
                    $answerId = Yii::$app->hiread->getLastInsertID();
                    //标记正确答案
                    if($data['isTrue'][$k] == '1'){
                        $correctAnswer[] = $answerId;
                    }
                }
                //更新题目的正确答案
                if(!empty($correctAnswer)){
                    $correctAnswerStr = implode('|',$correctAnswer);
//                    HiConfExtensiveTopic::updateAll(['Correct' => $correctAnswerStr], ['ID' => $questionId]);
                    $sourse = HiConfExtensiveTopic::findOne($questionId);
                    $sourse->Correct = $correctAnswerStr;
                    $sourse->save();
                }
                //删除原有题目列表数据
                $topicList = HiConfExtensiveTopicList::find()->where(['ExtId' => $extensiveId])->asArray()->all();
                if(!empty($topicList)){
                    foreach ($topicList as $k=>$v){
                        $questionIds = explode('|',$v['Questions']);
                        if(!empty($questionIds)){
                            $action = 0;
                            foreach ($questionIds as $key => $val){
                                if($val == $questionId){
                                    unset($questionIds[$key]);
                                    $action = 1;
                                }
                            }
                            //重新保存题目列表信息
                            if($action == 1){
                                if(empty($questionIds)){
                                    HiConfExtensiveTopicList::findOne($v['ID'])->delete();
                                }else{
                                    $sourse = HiConfExtensiveTopicList::findOne($v['ID']);
                                    $sourse->Questions = implode('|',$questionIds);
                                    $sourse->save();
                                }
                            }
                        }
                    }//end foreach
                }
                //保存泛读视频题目列表
                if(empty($data['Min'])) {$min = 0;}else{$min = $data['Min'];};
                if(empty($data['Sec'])) {$sec = 0;}else{$sec = $data['Sec'];};
                $topic = HiConfExtensiveTopicList::findOne(['ExtId' => $extensiveId,'Min' => $min,'Sec' => $sec]);
                if(empty($topic)){
                    //插入数据
                    $insertData = array('ExtId' => $extensiveId,'Questions' => (string)$questionId,'Min' => $min,'Sec' => $sec);
                    $extensiveTopicListModel = new HiConfExtensiveTopicList();
                    $extensiveTopicListModel->setAttributes($insertData,false);
                    $result = $extensiveTopicListModel->save();
                }else{
                    //更新数据
                    if(!empty($topic->Questions)){
                        $updateData = array('Questions' => $topic->Questions.'|'.$questionId);
                    }else{
                        $updateData = array('Questions' => $questionId);
                    }
                    $sourse = HiConfExtensiveTopicList::findOne($topic->ID);
                    $sourse->Questions = $updateData['Questions'];
                    $rtn = $sourse->save();
//                    $rtn = $sourse->updateAttributes($updateData);
                    if (!$rtn){
                        $this->exitJSON(0, 'fail!',$updateData);
                    }
                }//end if
                $transaction->commit();
            }else{
                $question = new HiConfExtensiveTopic();
                $question->setAttributes($data,false);
                $result = $question->save();
                $topicId = $question->ID;
                //添加答案
                foreach ($data['answerName'] as $k=>$v){
                    $answer = array(
                        'Tid' => $topicId,
                        'Name' => $v,
                        'Image' => $data['answerImage'][$k],
                        'Show' => $data['answerShow'][$k],
                        'Pair1Text' => $data['answerPair1Text'][$k],
                        'Pair1Audio' => $data['answerPair1Audio'][$k],
                        'Pair1Img' => $data['answerPair1Img'][$k],
                        'Pair2Text' => $data['answerPair2Text'][$k],
                        'Pair2Audio' => $data['answerPair2Audio'][$k],
                        'Pair2Img' => $data['answerPair2Img'][$k],
                    );
                    $extensiveTopicAnswer = new HiConfExtensiveTopicAnswer();
                    $extensiveTopicAnswer->setAttributes($answer,false);
                    $extensiveTopicAnswer->save();
                    $answerId = Yii::$app->hiread->getLastInsertID();
                    //标记正确答案
                    if($data['isTrue'][$k] == '1'){
                        $correctAnswer[] = $answerId;
                    }
                }
                //更新题目的正确答案
                if(!empty($correctAnswer)){
                    $correctAnswerStr = implode('|',$correctAnswer);
//                    HiConfExtensiveTopic::updateAll(['Correct' => $correctAnswerStr], ['ID' => $topicId]);
                    $sourse = HiConfExtensiveTopic::findOne($topicId);
                    $sourse->Correct = $correctAnswerStr;
                    $sourse->save();
                }
                //保存泛读视频题目列表
                if(empty($data['Min'])) {$min = 0;}else{$min = $data['Min'];};
                if(empty($data['Sec'])) {$sec = 0;}else{$sec = $data['Sec'];};
                $topic = HiConfExtensiveTopicList::findOne(['ExtId' => $extensiveId,'Min' => $min,'Sec' => $sec]);
                if(empty($topic)){
                    //插入数据
                    $insertData = array('ExtId' => $extensiveId,'Questions' => (string)$topicId,'Min' => $min,'Sec' => $sec);
                    $extensiveTopicListModel = new HiConfExtensiveTopicList();
                    $extensiveTopicListModel->setAttributes($insertData,false);
                    $result = $extensiveTopicListModel->save();
                }else{
                    //更新数据
                    if(!empty($topic->Questions)){
                        $updateData = array('Questions' => $topic->Questions.'|'.$topicId);
                    }else{
                        $updateData = array('Questions' => $topicId);
                    }
                    $sourse = HiConfExtensiveTopicList::findOne($topic->ID);
                    $sourse->Questions = $updateData['Questions'];
                    $rtn = $sourse->save();
//                    $rtn = $sourse->updateAttributes($updateData);
                    if (!$rtn){
                        $this->exitJSON(0, 'fail!',$updateData);
                    }
                }//end if
                $transaction->commit();
            }
        }catch (Exception $e){
            $error = $e->getMessage();
            $transaction->rollBack();
            //添加失败
            $this->exitJSON(0, $error);
        }
        $this->exitJSON(1, 'success!');
    }
    /**
     * 子单元题目列表
     * @return string
     */
    public function actionUnitIndex(){
        $courseId = Yii::$app->getRequest()->get('courseId');
        $extensiveId = Yii::$app->getRequest()->get('subUnitId');
        //获取题目
        $topicList = HiConfSubUnitTrain::find()->where(['SUnitId' => $extensiveId])->asArray()->all();
        //保存题目排序
        if(Yii::$app->getRequest()->getIsPost()){
            if(!empty($_POST['topic_id'])){
                $orderData = array();
                foreach ($_POST['topic_id'] as $k=>$v){
                    $source = HiConfTopic::findOne($v);
                    $source->Order = $_POST['topic_order'][$k];
                    $source->save();
                    $orderData[$v] = $_POST['topic_order'][$k];
                }
                asort($orderData);
                //修改题目列表排序规则
                if(!empty($topicList)){
                    foreach ($topicList as $k=>$v){
                        $lastList = array();
                        $questionIds = explode('|',$v['Questions']);
                        foreach ($orderData as $key => $val){
                            if(in_array($key,$questionIds)) $lastList[] = $key;
                        }
                        $lastListStr = implode('|',$lastList);
                        if(!empty($lastList) && $v['Questions'] != $lastListStr){
                            $source = HiConfSubUnitTrain::findOne($v['ID']);
                            $source->Questions = $lastListStr;
                            $source->save();
                        }
                    }//end foreach
                }
            }//end if
        }
        //获取题目
        $topicList = HiConfSubUnitTrain::find()->where(['SUnitId' => $extensiveId])->asArray()->all();
        $test = array();
        if(!empty($topicList)){
            $questionId = [];
            foreach ($topicList as $key=>$v){
                $questionIdArray = explode('|',$v['Questions']);
                if(!empty($questionIdArray)){
                    foreach ($questionIdArray as $question_key=>$question_val){
                        $questionId[] = [
                            'Min' => $v['Min'],
                            'Sec' => $v['Sec'],
                            'questionId' => $question_val,
                        ];
                    }
                }//end if
            }
            if(!empty($questionId)){
                foreach ($questionId as $key=>$val){
                    //查询问题答案
                    $question = HiConfTopic::findOne(['ID' => $val['questionId']]);
                    if(!empty($question)){
                        $question = $question->toArray();
                        //加入问题弹出时间
                        $question['Min'] = $val['Min'];
                        $question['Sec'] = $val['Sec'];
                        $question['answer'] = HiConfTopicAnswer::findAll(['Tid' => $val['questionId']]);
                        $test[$val['questionId']] = $question;
                    }
                }
            }//end if
        }//end if
        $renderData['question'] = $test;
        return $this->display('unit-index', $renderData);
    }
    /**
     * 添加子单元题目
     */
    public function actionAddSubUnitQuestion()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        if(Yii::$app->getRequest()->getIsPost()){
            $this->saveUnitQuestion();
        }
        $renderData['subUnitId'] = $subUnitId;
        $renderData['courseId'] = $courseId;
        return $this->display('add-sub-unit-question', $renderData);
    }
    /**
     * 修改子单元题目
     */
    public function actionEditUnitQuestion()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        if(Yii::$app->getRequest()->getIsPost()){
            $this->saveUnitQuestion();
        }
        $renderData['subUnitId'] = $subUnitId;
        $renderData['courseId'] = $courseId;
        //获取题目
        $questionId = Yii::$app->getRequest()->get('questionId');
        $question = HiConfTopic::find()->where(['ID' => $questionId])->asArray()->one();
        //获取答案
        $answer = HiConfTopicAnswer::find()->where(['Tid' => $questionId])->all();
        $renderData['question'] = $question;
        $renderData['answer'] = $answer;
        //获取题目跳出时间
        $extensive = HiConfSubUnitTrain::find()->where(['SUnitId' => $subUnitId])->asArray()->all();
        if(!empty($extensive)){
            foreach ($extensive as $k=>$v){
                $questionIds = explode('|',$v['Questions']);
                if(in_array($questionId,$questionIds)){
                    $renderData['min'] = $v['Min'];
                    $renderData['sec'] = $v['Sec'];
                }
            }//end foreach
        }
        return $this->display('add-sub-unit-question', $renderData);
    }
    /**
     * 保存题目
     */
    private function saveUnitQuestion()
    {
        //存储题目数据/答案数据/题目表
        $data = Yii::$app->getRequest()->post();
        $transaction = Yii::$app->hiread->beginTransaction();
        try{
            $subUnitId = Yii::$app->getRequest()->get('subUnitId');//子单元id
            $questionId = $data['questionId'];//题目id
            if(empty($data['Title'])) $this->exitJSON(0, '题目不能为空');
            if(!empty($questionId)){
                //删除原有答案
                HiConfTopicAnswer::deleteAll(['Tid' => $questionId]);
                //更新数据
                $model = new HiConfTopic();
                $attr = $model->attributeLabels();//表字段
                $updateData = array_intersect_key($data, $attr);
                $courseSource = HiConfTopic::findOne($questionId);
//                $rtn = $courseSource->updateAttributes($updateData);
                if(!empty($updateData)){
                    foreach ($updateData as $k=>$v){
                        $courseSource->$k = $v;
                    }
                }
                $rtn = $courseSource->save();
                //添加答案
                foreach ($data['answerName'] as $k=>$v){
                    $answer = array(
                        'Tid' => $questionId,
                        'Name' => $v,
                        'Image' => $data['answerImage'][$k],
                        'Show' => $data['answerShow'][$k],
                        'Pair1Text' => $data['answerPair1Text'][$k],
                        'Pair1Audio' => $data['answerPair1Audio'][$k],
                        'Pair1Img' => $data['answerPair1Img'][$k],
                        'Pair2Text' => $data['answerPair2Text'][$k],
                        'Pair2Audio' => $data['answerPair2Audio'][$k],
                        'Pair2Img' => $data['answerPair2Img'][$k],
                    );
                    $extensiveTopicAnswer = new HiConfTopicAnswer();
                    $extensiveTopicAnswer->setAttributes($answer,false);
                    $extensiveTopicAnswer->save();
                    $answerId = Yii::$app->hiread->getLastInsertID();
                    //标记正确答案
                    if($data['isTrue'][$k] == '1'){
                        $correctAnswer[] = $answerId;
                    }
                }
                //更新题目的正确答案
                if(!empty($correctAnswer)){
                    $correctAnswerStr = implode('|',$correctAnswer);
//                    HiConfTopic::updateAll(['Correct' => $correctAnswerStr], ['ID' => $questionId]);
                    $sourse = HiConfTopic::findOne($questionId);
                    $sourse->Correct = $correctAnswerStr;
                    $sourse->save();
                }
                //删除原有题目列表数据
                $topicList = HiConfSubUnitTrain::find()->where(['SUnitId' => $subUnitId])->asArray()->all();
                if(!empty($topicList)){
                    foreach ($topicList as $k=>$v){
                        $questionIds = explode('|',$v['Questions']);
                        if(!empty($questionIds)){
                            $action = 0;
                            foreach ($questionIds as $key => $val){
                                if($val == $questionId){
                                    unset($questionIds[$key]);
                                    $action = 1;
                                }
                            }
                            //重新保存题目列表信息
                            if($action == 1){
                                if(empty($questionIds)){
                                    HiConfSubUnitTrain::findOne($v['ID'])->delete();
                                }else{
                                    $sourse = HiConfSubUnitTrain::findOne($v['ID']);
                                    $sourse->Questions = implode('|',$questionIds);
                                    $sourse->save();
                                }
                            }
                        }
                    }//end foreach
                }
                //保存泛读视频题目列表
                if(empty($data['Min'])) {$min = 0;}else{$min = $data['Min'];};
                if(empty($data['Sec'])) {$sec = 0;}else{$sec = $data['Sec'];};
                $topic = HiConfSubUnitTrain::findOne(['SUnitId' => $subUnitId,'Min' => $min,'Sec' => $sec]);
                if(empty($topic)){
                    //插入数据
                    $insertData = array('SUnitId' => $subUnitId,'Questions' => (string)$questionId,'Min' => $min,'Sec' => $sec);
                    $extensiveTopicListModel = new HiConfSubUnitTrain();
                    $extensiveTopicListModel->setAttributes($insertData,false);
                    $result = $extensiveTopicListModel->save();
                }else{
                    //更新数据
                    if(!empty($topic->Questions)){
                        $updateData = array('Questions' => $topic->Questions.'|'.$questionId);
                    }else{
                        $updateData = array('Questions' => $questionId);
                    }
                    $sourse = HiConfSubUnitTrain::findOne($topic->ID);
                    $sourse->Questions = $updateData['Questions'];
                    $rtn = $sourse->save();
//                    $rtn = $sourse->updateAttributes($updateData);
                    if (!$rtn){
                        $this->exitJSON(0, 'fail!',$updateData);
                    }
                }//end if
                $transaction->commit();
            }else{
                $question = new HiConfTopic();
                $question->setAttributes($data,false);
                $result = $question->save();
                $topicId = $question->ID;
                //添加答案
                foreach ($data['answerName'] as $k=>$v){
                    $answer = array(
                        'Tid' => $topicId,
                        'Name' => $v,
                        'Image' => $data['answerImage'][$k],
                        'Show' => $data['answerShow'][$k],
                        'Pair1Text' => $data['answerPair1Text'][$k],
                        'Pair1Audio' => $data['answerPair1Audio'][$k],
                        'Pair1Img' => $data['answerPair1Img'][$k],
                        'Pair2Text' => $data['answerPair2Text'][$k],
                        'Pair2Audio' => $data['answerPair2Audio'][$k],
                        'Pair2Img' => $data['answerPair2Img'][$k],
                    );
                    $extensiveTopicAnswer = new HiConfTopicAnswer();
                    $extensiveTopicAnswer->setAttributes($answer,false);
                    $extensiveTopicAnswer->save();
                    $answerId = Yii::$app->hiread->getLastInsertID();
                    //标记正确答案
                    if($data['isTrue'][$k] == '1'){
                        $correctAnswer[] = $answerId;
                    }
                }
                //更新题目的正确答案
                if(!empty($correctAnswer)){
                    $correctAnswerStr = implode('|',$correctAnswer);
//                    HiConfTopic::updateAll(['Correct' => $correctAnswerStr], ['ID' => $topicId]);
                    $sourse = HiConfTopic::findOne($topicId);
                    $sourse->Correct = $correctAnswerStr;
                    $sourse->save();
                }
                //保存题目列表
                if(empty($data['Min'])) {$min = 0;}else{$min = $data['Min'];};
                if(empty($data['Sec'])) {$sec = 0;}else{$sec = $data['Sec'];};
                $topic = HiConfSubUnitTrain::findOne(['SUnitId' => $subUnitId,'Min' => $min,'Sec' => $sec]);
                if(empty($topic)){
                    //插入数据
                    $insertData = array('SUnitId' => $subUnitId,'Questions' => (string)$topicId,'Min' => $min,'Sec' => $sec);
                    $extensiveTopicListModel = new HiConfSubUnitTrain();
                    $extensiveTopicListModel->setAttributes($insertData,false);
                    $result = $extensiveTopicListModel->save();
                }else{
                    //更新数据
                    if(!empty($topic->Questions)){
                        $updateData = array('Questions' => $topic->Questions.'|'.$topicId);
                    }else{
                        $updateData = array('Questions' => $topicId);
                    }
                    $sourse = HiConfSubUnitTrain::findOne($topic->ID);
                    $sourse->Questions = $updateData['Questions'];
                    $rtn = $sourse->save();
//                    $rtn = $sourse->updateAttributes($updateData);
                    if (!$rtn){
                        $this->exitJSON(0, 'fail!',$updateData);
                    }
                }//end if
                $transaction->commit();
            }
        }catch (Exception $e){
            $error = $e->getMessage();
            $transaction->rollBack();
            //添加失败
            $this->exitJSON(0, $error);
        }
        $this->exitJSON(1, 'success!');
    }
    /**
     * 删除题目
     */
    public function actionDelUnitQuestion()
    {
        $courseId = Yii::$app->getRequest()->get('courseId');
        $subUnitId = Yii::$app->getRequest()->get('subUnitId');
        $questionId = Yii::$app->getRequest()->get('questionId');
        $transaction = Yii::$app->hiread->beginTransaction();
        try{
            HiConfTopicAnswer::deleteAll(['Tid' => $questionId]);
//            HiConfTopic::deleteAll(['ID' => $questionId]);
            HiConfTopic::findOne($questionId)->delete();
            //更新题目列表
            $list = HiConfSubUnitTrain::find()->where(['SUnitId' => $subUnitId])->all();
            if(!empty($list)){
                foreach ($list as $k=>$v){
                    $questionIds = explode('|',$v['Questions']);
                    if(!empty($questionIds)){
                        foreach ($questionIds as $key=>$val){
                            if($val == $questionId) unset($questionIds[$key]);
                        }
                        //更新数据表
                        $questionIdStr = implode('|',$questionIds);
                        if(!empty($questionIdStr)){
//                            HiConfSubUnitTrain::updateAll(['Questions' => $questionIdStr], ['ID' => $v['ID']]);
                            $sourceObj = HiConfSubUnitTrain::findOne($v['ID']);
                            $sourceObj->Questions = $questionIdStr;
                            $sourceObj->save();
                        }else{
//                            HiConfSubUnitTrain::deleteAll(['ID' => $v['ID']]);
                            HiConfSubUnitTrain::findOne($v['ID'])->delete();
                        }
                    }//end if
                }
            }
            $transaction->commit();
        }catch (Exception $e){
            $error = $e->getMessage();
            $transaction->rollBack();
            //添加失败
            $this->exitJSON(0, $error);
        }
        $this->exitJSON(1, 'success!');
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
            case 'unit_topic_img':
                $base_address = Yii::$app->params['unit_topic_img'];//单元题目地址
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