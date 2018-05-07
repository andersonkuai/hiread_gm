<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/28
 * Time: 13:56
 */

namespace common\enums;

use common\helpers\Enum;

class Generalize extends Enum
{
    //账户类型
    const USER_TYPE_ORGANIZATION = '1';


    public static function labels(){

        return [
            'USER_TYPE_ORGANIZATION' => '机构',
        ];
    }
}