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
        if( is_string($key) ) {
            $this->_twig->addGlobal($key, $value);
        } else {
            foreach( $key AS $k=>$v ) {
                $this->addGlobal($k, $v);
            }
        }
    }

    /**
     * 添加函数
     */
    public function addFunction($function)
    {
        if( is_string($function) ) {
            $this->_twig->addFunction($function, new Twig_Function_Function($function));
        } else {
            foreach( $function AS $v ) {
                $this->addFunction($v);
            }
        }
    }

    /**
     * 添加过滤器
     */
    public function addFilter($filter)
    {
        if( is_string($filter) ) {
            $this->_twig->addFilter($filter, new Twig_Filter_Function($filter));
        } else {
            foreach( $filter AS $v ) {
                $this->_addFilter($v);
            }
        }
    }
}
