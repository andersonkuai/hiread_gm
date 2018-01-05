<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/5
 * Time: 16:31
 * 用来约束创建支付订单的商家订单类型
 */

namespace common\enums;


use common\helpers\Enum;

class OrderType extends Enum
{
    const FUND_RECHARGE = 'FUND_RECHARGE';
}