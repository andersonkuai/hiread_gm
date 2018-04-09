<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/28
 * Time: 13:56
 */

namespace common\enums;

use common\helpers\Enum;

class subUnit extends Enum
{
    public static function params($key)
    {

        $data = [
            'type' => [
                '1' => '课前测',
                '2' => 'FreeTalk',
                '3' => '课前听读',
                '4' => '课前单词',
                '5' => '英文导读视频课',
                '6' => '课后作业',
                '7' => '课后测',
                '8' => 'Free Talk',
            ],
        ];
        return $data[$key];
    }
}