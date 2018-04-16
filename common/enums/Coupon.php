<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/28
 * Time: 13:56
 */

namespace common\enums;

use common\helpers\Enum;

class Coupon extends Enum
{
    //代金券类型
    const COUPON_TYPE_CASH = '1';


    public static function labels(){

        return [
            'COUPON_TYPE_CASH' => '现金券',
        ];
    }
}