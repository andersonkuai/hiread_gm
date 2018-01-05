<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/28
 * Time: 13:56
 */

namespace common\enums;

use common\helpers\Enum;

class Balance extends Enum
{
    const TRADE_TYPE_EXCHANGE_FROM_WHITE = 401;
    const TRADE_TYPE_EXCHANGE_FROM_RED = 402;
    const TRADE_TYPE_WITHDRAW = 403;

    const OTHER_TYPE_SYSTEM = 0;
    const OTHER_TYPE_USER = 1;
    public static function labels(){

        return [
            self::TRADE_TYPE_EXCHANGE_FROM_WHITE => '白积分兑换',
            self::TRADE_TYPE_EXCHANGE_FROM_RED => '红积分兑换',
            self::TRADE_TYPE_WITHDRAW => '提现',

            self::OTHER_TYPE_SYSTEM => '系统',
            self::OTHER_TYPE_USER => '用户',
        ];
    }
}