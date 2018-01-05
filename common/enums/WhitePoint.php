<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/25
 * Time: 16:28
 */

namespace common\enums;


use common\helpers\Enum;

class WhitePoint extends Enum
{
    const TRADE_TYPE_CONSUME = 300;
    const TRADE_TYPE_CONSUME_GET = 301;
    const TRADE_TYPE_SELLER_COMM = 302;
    const TRADE_TYPE_CONSUME_COMM = 303;
    const TRADE_TYPE_SELLER_CHARGE_GET = 304;
    const TRADE_TYPE_CONSUME_CANCEL = 305;
    const TRADE_TYPE_CONSUME_COMM_CANCEL = 306;
    const TRADE_TYPE_EXCHANGE_TO_BALANCE = 307;
    const TRADE_TYPE_EXCHANGE_RED_TO_STOCK_GET = 308;
    const TRADE_TYPE_EXCHANGE_WHITE_BALANCE_SXF = 309;

    const OTHER_TYPE_SYSTEM = 0;
    const OTHER_TYPE_USER = 1;
    public static function labels(){

        return [
            self::TRADE_TYPE_CONSUME => '结算',//转出红积分
            self::TRADE_TYPE_CONSUME_GET => '消费收入',
            self::TRADE_TYPE_SELLER_COMM => '商家充值分成',
            self::TRADE_TYPE_CONSUME_COMM => '客户消费分成',
            self::TRADE_TYPE_SELLER_CHARGE_GET => '消费返还',
            self::TRADE_TYPE_CONSUME_CANCEL => '消费撤销',
            self::TRADE_TYPE_CONSUME_COMM_CANCEL => '消费分成撤销',
            self::TRADE_TYPE_EXCHANGE_TO_BALANCE => '兑换云券',
            self::TRADE_TYPE_EXCHANGE_RED_TO_STOCK_GET => '兑换赠送',
            self::TRADE_TYPE_EXCHANGE_WHITE_BALANCE_SXF => '兑换美购券手续费',

            self::OTHER_TYPE_SYSTEM => '系统',
            self::OTHER_TYPE_USER => '用户',
        ];
    }

}