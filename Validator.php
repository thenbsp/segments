<?php

/**
 * 简单的数据验证器
 * Created by thenbsp (thenbsp@gmail.com)
 */

// Example:
// 
// require_once APP_PATH.'Library/Validator/Validator.php';

// $data = array(
//     'user' => 'thenbsp',
//     'email' => 'thenbsp111@gmail.com',
//     'phone' => '18629261885',
//     'password' => 'asdfaaaaaaaaa',
//     'repassword' => 'asdfaaaaaaaaa'
// );

// Validator::addData($data);
// Validator::addRule('user', '姓名', 'required|minLength[2]|maxLength[16]');
// Validator::addRule('email', '邮箱', 'required|email|callback[UserModel.validatorHasEmail]');
// Validator::addRule('phone', '手机号', 'required|exactLength[11]|phone');
// Validator::addRule('password', '密码', 'required|minLength[6]|maxLength[16]');
// Validator::addRule('repassword', '确认密码', 'required|matche[password]');

// $isValid = Validator::isValid();

// var_dump($isValid);

// if( ! $isValid ) {
//     print_r(Validator::getErrors());
// } else {
//     print_r(Validator::getData());
// }
//

class Validator {

    /**
     * 待验证的数据
     * @var array
     */
    protected $data = array();

    /**
     * 数据验证规则
     * @var array
     */
    protected $rule = array();

    /**
     * 数据字段名称
     * @var array
     */
    protected $label = array();

    /**
     * 验证错误消息
     * @var array
     */
    protected $error = array();

    /**
     * 存储静态实例
     * @var object
     */
    protected static $instance;

    /**
     * 构告方法（可同时传递待验证数据）
     * @param  array  $data 待验证数据
     */
    protected function __construct() { }

    /**
     * =================================================================
     * 验证规则必需以 “_rule_” 开头，并且区分大小写，返回值为 Boolean，
     * 返回值如果为 FALSE，同必需返回FALSE以跳出循环，同时调用 addError()
     * 方法添加错误信息，如果验证规则有值，将存放于第二个参数，例如：
     * required         => _rule_required($filed)
     * minLength[6]     => _rule_minLength($field, 6)
     * maxLength[16]    => _rule_maxLength($field, 16)
     * =================================================================
     */

    /**
     * 验证规则 required
     */
    protected function _rule_required($field) {
        if( empty($this->_getData($field)) ) {
            $this->_addError($field, "{$field}不能为空");
            return FALSE;
        }
    }

    /**
     * minLength[x]
     */
    protected function _rule_minLength($field, $value) {
        if( strlen($this->_getData($field)) < intval($value) ) {
            $this->_addError($field, "{$field}长度不能小于{$value}个字符");
            return FALSE;
        }
    }

    /**
     * 验证规则 maxLength[x]
     */
    protected function _rule_maxLength($field, $value) {
        if( strlen($this->_getData($field)) > intval($value) ) {
            $this->_addError($field, "{$field}长度不能大于{$value}");
            return FALSE;
        }
    }

    /**
     * 验证规则 exactLength[x]
     */
    protected function _rule_exactLength($field, $value) {
        if( strlen($this->_getData($field)) !== intval($value) ) {
            $this->_addError($field, "{$field}长度必需是{$value}");
            return FALSE;
        }
    }

    /**
     * 验证规则 email
     */
    protected function _rule_email($field) {
        if( ! filter_var($this->_getData($field), FILTER_VALIDATE_EMAIL) ) {
            $this->_addError($field, "{$field}格式不正确");
            return FALSE;
        }
    }

    /**
     * 验证规则 phone
     */
    protected function _rule_phone($field) {
        if( ! preg_match("/^1[3458][0-9]{9}$/", $this->_getData($field)) ) {
            $this->_addError($field, "{$field}格式不正确");
            return FALSE;
        }
    }

    /**
     * 验证规则 matche[x]
     */
    protected function _rule_matche($field, $value) {
        if( $this->_getData($field) !== $this->_getData($value) ) {
            $this->_addError($field, "{$field}和{$value}不匹配");
            return FALSE;
        }
    }

    /**
     * 验证规则 callback(x)
     */
    protected function _rule_callback($field, $value) {
        
        list($class, $method) = array_pad(explode('.', $value), 2, NULL);

        // 调用函数
        if( is_null($method) ) {
            if( ! function_exists($class) ) {
                throw new Exception("Function {$class} Not Found");
            }
            if( ! call_user_func($class, $field) ) {
                return FALSE;
            }
        }
        // 调用类
        else {
            if( ! method_exists($class, $method) ) {
                throw new Exception("Method {$class}::{$method} Not Found");
            }
            $object   = new $class;
            if( ! call_user_func_array(array($object, $method), array($field)) ) {
                return FALSE;
            }
        }
    }

    /**
     * 添加待验证数据
     * @param array $data 待验证数据
     */
    protected function _addData($data) {

        foreach( $data AS $k=>$v ) {
            $this->_setData($k, $v);
        }
    }

    /**
     * 设置待验证数据
     * @param  string $field 验证数据字段
     * @param  string $value 数据字段值
     * @return void
     */
    protected function _setData($field, $value) {

        if( is_string($value) ) {
            $value = trim($value);
        }

        $this->data[$field] = $value;
    }

    /**
     * 获取待验证数据
     * @return array
     */
    protected function _getData($field = NULL) {

        if( is_null($field) ) {
            return $this->data;
        }

        return isset($this->data[$field]) ? $this->data[$field] : NULL;
    }

    /**
     * 添加验证规则
     * @param string $field 验证数据字段
     * @param string $label 数据字段名称
     * @param string $rules 数据验证规则
     */
    protected function _addRule($field, $label, $rules) {

        if( ! isset($this->data[$field]) ) {
            $this->data[$field] = NULL;
        }

        $this->_setRule($field, explode('|', $rules));
        $this->_addLabel($field, $label);
    }

    /**
     * 设置验证规则
     * @param string $field 验证数据字段
     * @param string $rules 数据验证规则
     */
    protected function _setRule($field, $rules) {
        $this->rule[$field] = array_filter($rules);
    }

    /**
     * 获取验证规则
     * @return array
     */
    protected function _getRule() {
        return $this->rule;
    }

    /**
     * 添加数据字段名称
     * @param string $field 验证数据字段
     * @param string $label 数据字段名称
     */
    protected function _addLabel($field, $label) {
        $this->label[$field] = $label;
    }

    /**
     * 获取数据字段名称
     * @return array
     */
    protected function _getLabel($field = NULL) {

        if( is_null($field) ) {
            return $this->label;
        }

        return isset($this->label[$field]) ? $this->label[$field] : NULL;
    }

    /**
     * 设置错误消息（可用于外部）
     * @param string $field        数据字段
     * @param string $errorMessage 错误消息
     */
    protected function _addError($field, $errorMessage) {
        $this->error[$field] = strtr($errorMessage, $this->_getLabel());
    }

    /**
     * 获取错误消息（可用于外部）
     * @return string
     */
    protected function _getError() {
        return empty($this->error) ? NULL : current($this->error);
    }

    /**
     * 获取全部错误（可用于外部）
     * @return array
     */
    protected function _getErrors() {
        return $this->error;
    }

    /**
     * 获取规则中的值 rule[x]
     * @param  string $rule 验证规则
     * @return string
     */
    protected function _getRuleValue($rule) {

        $value = NULL;
        $valid = preg_match_all('/\[(.*?)\]/', $rule, $matches);

        if( $valid AND isset($matches[1][0]) ) {
            $value = $matches[1][0];
        }

        return $value;
    }

    /**
     * 检测数据字段有效性
     * @param string $field 验证数据字段
     * @param string $rules 数据验证规则
     */
    protected function _checkFieldByRule($field, $rules) {

        foreach( $rules AS $k=>$v ) {
            // 验证规则名称
            $type = strpos($v, '[');
            $rule = (FALSE !== $type) ? substr($v, 0, $type) : $v;
            $name = "_rule_{$rule}";

            if( is_callable(array($this, $name)) ) {
                // 获取验证规则的值，也就是 [x] 中的 “x”
                $value = $this->_getRuleValue($v);
                // 如果字符中包含 “[” 但获取失败则直接跳过
                if( is_null($value) AND (FALSE !== $type) ) {
                    continue;
                }
                // 否则就调用验证规则，验证失败必需跳出循环
                if( FALSE === call_user_func_array(array($this, $name), array($field, $value)) ) {
                    break;
                }
            }
        }
    }

    /**
     * 检测验证结果
     * @return boolean
     */
    protected function _isValid() {

        if( count($this->rule) > 0 ) {
            foreach( $this->rule AS $k=>$v ) {
                $this->_checkFieldByRule($k, $v);
            }
        }

        return (count($this->error) === 0);
    }

    /**
     * 魔术方法（对外只暴露这一个方法）
     * @param  string $name      方法名称
     * @param  array  $arguments 参数
     * @return void
     */
    public static function __callStatic($method, $arguments) {

        if( ! self::$instance instanceof self) {
            self::$instance = new self();
        }

        $instance = self::$instance;
        $function = "_{$method}";

        if( ! is_callable(array($instance, $function)) ) {
            throw new Exception( sprintf('Method %s::%s Not Found', __CLASS__, $method) );
        }

        return call_user_func_array(array($instance, $function), $arguments);
    }

}