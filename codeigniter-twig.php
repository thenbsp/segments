<?php

// use composer
require FCPATH.'../vendor/autoload.php';

// use package
// require APPPATH.'third_party/Twig/lib/Twig/Autoloader.php';

class Twig
{
    /**
     * Twig Object
     */
    private $_twig;

    /**
     * 构造方法
     */
    public function __construct()
    {
        // Register Autoloader
        Twig_Autoloader::register();
        // twig filesystem
        $loader = new Twig_Loader_Filesystem(APPPATH.'views');
        // twig object
        $twig = new Twig_Environment($loader, array(
            'cache'         => APPPATH.'cache',
            'debug'         => true,
            'autoescape'    => false,
            'optimizations' => -1
        ));
        // debug mode
        $twig->addExtension(new Twig_Extension_Debug());

        $this->_twig = $twig;
    }

    /**
     * 渲染模板
     */
    public function render($view, $data = array(), $return = false)
    {
        $view = $this->_twig->loadTemplate($view);

        if( false === $return ) {
            return $view->display($data);
        }

        return $view->render($data);
    }

    /**
     * 添加全局变量
     */
    public function addGlobal($key, $value = NULL)
    {
        if( is_array($key) ) {
            foreach( $key AS $k=>$v ) {
                $this->addGlobal($k, $v);
            }
        } else {
            $this->_twig->addGlobal((string) $key, (string) $value);
        }
    }

    /**
     * 添加函数
     */
    public function addFunction($function)
    {
        if( is_array($function) ) {
            foreach( $function AS $v ) {
                $this->addFunction($v);
            }
        } else {
            $this->_twig->addFunction((string) $function, new Twig_Filter_Function((string) $function));
        }
    }

    /**
     * 添加过滤器
     */
    public function addFilter($filter)
    {
        if( is_array($filter) ) {
            foreach( $filter AS $v ) {
                $this->addFilter($v);
            }
        } else {
            $this->_twig->addFilter((string) $filter, new Twig_Filter_Function((string) $filter));
        }
    }
}
