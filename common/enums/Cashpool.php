<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 15:32
 */

namespace common\enums;


use common\helpers\Enum;

class Cashpool extends Enum
{
    const TRADE_TYPE_CHARGE = 500;
    const TRADE_TYPE_WITHDRAW = 501;

    const OTHER_TYPE_SYSTEM = 0;
    const OTHER_TYPE_USER = 1;
    public static function labels(){

        return [
            self::TRADE_TYPE_CHARGE => '充值',
            self::TRADE_TYPE_WITHDRAW => '提现',


            self::OTHER_TYPE_SYSTEM => '系统',
            self::OTHER_TYPE_USER => '用户',
        ];
    }
}