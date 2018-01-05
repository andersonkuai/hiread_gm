<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/8
 * Time: 11:42
 */

namespace common\enums;


use common\helpers\Enum;

class AsyncTask extends Enum
{
    const STATUS_CREATED  = 0;
    const STATUS_PROGRESS = 1;
    const STATUS_SUCCESS  = 2;
    const STATUS_FAIL     = 3;

    public static function labels(){

        return [
            self::STATUS_CREATED    => '未开始',
            self::STATUS_PROGRESS   => '进行中',
            self::STATUS_SUCCESS    => '已成功',
            self::STATUS_FAIL       => '已失败',
        ];
    }
}