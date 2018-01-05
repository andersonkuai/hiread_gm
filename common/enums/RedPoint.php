<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/25
 * Time: 16:28
 */

namespace common\enums;


use common\helpers\Enum;

class RedPoint extends Enum
{
    const TRADE_TYPE_CONSUME = 200;
    const TRADE_TYPE_EXCHANGE_RED_STOCK_SXF = 201;
    const TRADE_TYPE_EXCHANGE_RED_STOCK = 202;
    const TRADE_TYPE_PAY = 203;
    const TRADE_TYPE_EXCHANGE_RED_BALANCE = 204;
    const TRADE_TYPE_EXCHANGE_RED_BALANCE_SXF = 205;
    const TRADE_TYPE_TEST = 210;

    const OTHER_TYPE_SYSTEM = 0;
    const OTHER_TYPE_USER = 1;
    public static function labels(){

        return [
            self::TRADE_TYPE_CONSUME => '结算',//白积分转入
            self::TRADE_TYPE_EXCHANGE_RED_STOCK_SXF => '兑换库存积分手续费',
            self::TRADE_TYPE_EXCHANGE_RED_STOCK => '兑换库存积分',
            self::TRADE_TYPE_PAY => '红积分支付',
            self::TRADE_TYPE_EXCHANGE_RED_BALANCE => '兑换美购券',
            self::TRADE_TYPE_EXCHANGE_RED_BALANCE_SXF => '兑换美购券手续费',
            self::TRADE_TYPE_TEST => '测试赠送',

            self::OTHER_TYPE_SYSTEM => '系统',
            self::OTHER_TYPE_USER => '用户',
        ];
    }

}