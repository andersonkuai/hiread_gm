<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/28
 * Time: 13:56
 */

namespace common\enums;

use common\helpers\Enum;

class Topic extends Enum
{
    //题目类型
    const TYPE_TF = '1';
    const TYPE_SINGLE_CHOICE = '2';
    const TYPE_VIDEO = '3';
    const TYPE_FLASH_CARD = '4';
    const TYPE_COMPLETE_WORD = '5';
    const TYPE_COMPLETE_SENTENCE = '6';
    const TYPE_MAKING_SENTENCES = '7';
    const TYPE_CLICKING_PAIRS = '8';
    const TYPE_MOVING_TABS = '9';

    public static function labels(){

        return [
            'TYPE_TF' => '对错题',
            'TYPE_SINGLE_CHOICE' => '单选题',
            'TYPE_VIDEO' => '视频课',
            'TYPE_FLASH_CARD' => '单词卡',
            'TYPE_COMPLETE_WORD' => '填空-单词',
            'TYPE_COMPLETE_SENTENCE' => '填空-句子',
            'TYPE_MAKING_SENTENCES' => '造句',
            'TYPE_CLICKING_PAIRS' => '图片记忆',
            'TYPE_MOVING_TABS' => '拖动配对',
        ];
    }
    public static function params($key)
    {

        $data = [
            'type' => [
                '1' => '对错题',
                '2' => '单选题',
                '3' => '视频课',
                '4' => '单词卡',
                '5' => '填空-单词',
                '6' => '填空-句子',
                '7' => '造句',
                '8' => '图片记忆',
                '9' => '拖动配对',
                '10' => '开放性问题',
                '11' => '时序题',
                '12' => '任意判断题',
                '13' => '任意选择题',
                '14' => 'Free Talk',
            ],
        ];
        return $data[$key];
    }
}