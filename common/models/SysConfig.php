<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/23
 * Time: 15:29
 */

namespace common\models;


use backend\models\SysConfigForm;

class SysConfig extends DbModel
{
    protected function tableName()
    {
        return '{{%sys_config}}';
    }
    private $allowKeys = array();
    private $params = array();
    private static $_instance = null;
    private function __construct() {
        $this->allowKeys = (new SysConfigForm())->attributes();
        $rows = $this->findAll('1');

        foreach( (array)$rows as $row ){
            $this->params[$row['name']] = $row['value'];
        }
    }
    private function __clone() {}

    public static function instance() {
        if (is_null ( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function get( $name = null ){

        return empty($name) ? $this->params :
            (isset($this->params[$name]) ? $this->params[$name] : null);
    }

    public function set( $name, $value ){

        if( !in_array($name, $this->allowKeys) ) return false;

        $row = $this->findRow("name = '{$name}'");

        if( !empty($row) ){
            return $this->update(array('value' => $value ), "name='{$name}'");
        }else{
            return $this->insert(array('name' => $name, 'value' => $value ));
        }
    }

}