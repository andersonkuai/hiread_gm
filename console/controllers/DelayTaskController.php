<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/18
 * Time: 15:14
 */

namespace console\controllers;

use common\classes\DelayTask;
use common\classes\DelayTaskProcess;
use yii\console\Controller;
class DelayTaskController extends Controller
{
    public function actionRun(){
        echo "[".date("Y-m-d H:i:s")."][start...]".PHP_EOL;
        $queueClient = DelayTask::instance()->getQueue();
        $taskMap = DelayTask::instance()->getTaskMap();
        $delayTaskProcess =  new DelayTaskProcess();
        $queueClient->watch('SYSTEM');
        foreach( $taskMap as $taskName => $taskValue ){
            $queueClient->watch($taskName);
        }

        while (true) {
            $job = $queueClient->reserve();
            $jobStats = $queueClient->statsJob($job->getId());

            $taskData = json_decode($job->getData(), true);
            //安全退出队列监听
            if(!empty($jobStats['tube']) && $jobStats['tube'] == 'SYSTEM'
                && !empty($taskData['command']) && $taskData['command'] == 'QUIT'){
                $queueClient->delete($job);
                echo "[".date("Y-m-d H:i:s")."][{$jobStats['tube']}]"."[{$job->getData()}]".PHP_EOL;
                break;
            }
            if(!empty($taskData['__id']))
                $model = \common\models\DelayTask::findOne([ 'id'=>$taskData['__id']]);

            //处理任务
            $result = $delayTaskProcess->run($jobStats['tube'], $job->getData());

            if ($result) {
                //删除任务
                $queueClient->delete($job);
                if(!empty($model)) $model->status = 1;
            } else {
                //休眠任务
                $queueClient->bury($job);
                if(!empty($model)) $model->status = 2;
            }
            if(!empty($model)) $model->update();

        }
        //防止脚本结束后被守护进程重启，静静的等待结束
        while (true){
            echo "[".date("Y-m-d H:i:s")."][wating for safe exit]".PHP_EOL;
            sleep(5);
        }
    }

    public function actionTest(){

        while (true){
            echo "[".date("Y-m-d H:i:s")."][pm2 yii test....]".PHP_EOL;
            sleep(5);
        }
    }
}