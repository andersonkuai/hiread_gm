<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/25
 * Time: 16:28
 */

namespace common\enums;


use common\helpers\Enum;

class StockPoint extends Enum
{
    const TRADE_TYPE_CHARGE = 100;
    const TRADE_TYPE_CONSUME_GIVE = 101;
    const TRADE_TYPE_EXCHANGE_RED_STOCK = 102;
    const TRADE_TYPE_CONSUME_CANCEL = 105;

    const OTHER_TYPE_SYSTEM = 0;
    const OTHER_TYPE_USER = 1;

    public static function labels(){

        return [
            self::TRADE_TYPE_CHARGE => '充值',
            self::TRADE_TYPE_CONSUME_GIVE => '消费赠送',
            self::TRADE_TYPE_EXCHANGE_RED_STOCK => '红积分兑换',
            self::TRADE_TYPE_CONSUME_CANCEL => '消费撤销',

            self::OTHER_TYPE_SYSTEM => '系统',
            self::OTHER_TYPE_USER => '用户',
        ];
    }

}