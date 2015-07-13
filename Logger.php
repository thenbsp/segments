<?php

/**
 * 日志操作
 * Created by thenbsp (thenbsp@gmail.com)
 */
class Logger
{

    /**
     * 日志文件路径
     */
    public $savepath;

    /**
     * 构造方法
     */
    public function __construct($savepath)
    {
        if( NULL === $savepath ) {
            throw new Exception('Log save path is required');
        }

        if( ! is_writable($savepath) ) {
            throw new Exception('Log save path unwritable');
        }

        $this->savepath = realpath($savepath) . DIRECTORY_SEPARATOR;
    }

    /**
     * 调试日志
     */
    public function debug($message)
    { 
        return $this->_set('info', $message, debug_backtrace());
    }

    /**
     * 错误日志
     */
    public function error($message)
    { 
        return $this->_set('error', $message, debug_backtrace());
    }

    /**
     * 警告日志
     */
    public function warning($message)
    {
        return $this->_set('warning', $message, debug_backtrace());
    }

    /**
     * 写入日志方法
     */
    private function _set($level = 'debug', $message, $debug) {

        $level = strtolower($level);
        $level = in_array($level, array('debug', 'error', 'warning')) ? $level : 'debug';

        $filename = date('Y-m-d');
        $fullname = $this->savepath."{$filename}-{$level}.php";

        if( ! $fp = fopen($fullname, 'ab') ) {
            return FALSE;
        }

        $file = isset($debug[0]['file']) ? $debug[0]['file'] : '';
        $line = isset($debug[0]['line']) ? $debug[0]['line'] : '';

        $message = "Created: ".date('Y-m-d H:i')." {$file}:{$line}".PHP_EOL."Message: {$message}".PHP_EOL.PHP_EOL;

        flock($fp, LOCK_EX);
        fwrite($fp, $message);
        flock($fp, LOCK_UN);
        fclose($fp);

        chmod($fullname, '0666');

        return TRUE;
    }

}
