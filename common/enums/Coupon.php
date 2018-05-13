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
    //优惠券类型
    const COUPON_TYPE_CASH = 1;
    const COUPON_TYPE_RED = 2;
    const COUPON_TYPE_FREIGHT = 3;
    //优惠券状态
    const COUPON_STATE_CREATED = 1;
    const COUPON_STATE_EFFECTIVE = 2;
    const COUPON_STATE_LOSE_EFFECTIVE = 3;
    //生效方式
    const COUPON_EFFECTIVE_WAY_SECTION = '1';
    const COUPON_EFFECTIVE_WAY_GET = '2';

    public static function labels(){

        return [
            'COUPON_TYPE_CASH' => '现金券',
            'COUPON_TYPE_RED' => '红包券',
            'COUPON_TYPE_FREIGHT' => '运费券',

            'COUPON_EFFECTIVE_WAY_SECTION' => '设定区间',
            'COUPON_EFFECTIVE_WAY_GET' => '领取生效',

            'COUPON_STATE_CREATED' => '已创建',
            'COUPON_STATE_EFFECTIVE' => '已生效',
            'COUPON_STATE_LOSE_EFFECTIVE' => '已失效',
        ];
    }
}