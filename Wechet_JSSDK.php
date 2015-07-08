<?php

/**
 * 微信新版 JS SDK 配置起来太麻烦（要开启 SESSION）
 * Created by thenbsp (thenbsp@gmail.com)
 */
class Wechat_JSSDK
{
    /**
     * 公众号 APP ID
     */
    private $appid;

    /**
     * 公众号 APP SECRET
     */
    private $appsecret;

    /**
     * 公众号 Access Token（注意：公众号和用户 Access Token不一样）
     */
    private $accessToken;
    
    /**
     * JS SDK 调试模式
     */
    private $debug = false;

    /**
     * JS SDK API
     * 参考：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html#.E9.99.84.E5.BD.952-.E6.89.80.E6.9C.89JS.E6.8E.A5.E5.8F.A3.E5.88.97.E8.A1.A8
     */
    private $api = array();

    /**
     * 构造方法
     */
    function __construct($appid, $appsecret)
    {
        $this->appid        = $appid;
        $this->appsecret    = $appsecret;

        if( !session_id() ) {
            throw new Exception('Must be session start');
        }
    }

    /**
     * 是否开启调试
     */
    public function enableDebug()
    {
        $this->debug = true;
    }

    /**
     * 添加 api 接口
     */
    public function addApi($apiName)
    {
        if( is_array($apiName) ) {
            foreach($apiName AS $name) {
                array_push($this->api, strval($name));
            }
        } else {
            array_push($this->api, strval($apiName));
        }
    }

    /**
     * 获取 JSSDK 配置
     */
    public function getConfig()
    {
        if( !$accessToken = $this->getAccessToken() ) {
            return;
        }

        // set Access Token
        $this->setAccessToken($accessToken);

        if( !$ticket = $this->getTicket() ) {
            return;
        }

        $config = array(
            'debug'     => $this->debug,
            'appId'     => $this->appid,
            'nonceStr'  => $this->getRandomString(),
            'timestamp' => time(),
            'jsApiList' => $this->api
        );

        $params = array(
            'jsapi_ticket'  => $ticket,
            'noncestr'      => $config['nonceStr'],
            'timestamp'     => $config['timestamp'],
            'url'           => $this->getCurrentUrl()
        );

        $query = urldecode(http_build_query($params));

        $config['signature'] = sha1($query);

        return json_encode($config);
    }

    /**
     * 获取公众号 access token
     */
    public function getAccessToken()
    {
        $accessToken = 'mp_access_token';

        if( isset($_SESSION[$accessToken]) ) {
            return $_SESSION[$accessToken];
        }

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appid}&secret={$this->appsecret}";
        $res = file_get_contents($url);

        if( false === $res ) {
            return;
            // throw new Exception('Unable to get AccessToken');
        }

        $res = json_decode($res);

        if( ! isset($res->access_token) ) {
            return;
        }

        $_SESSION[$accessToken] = $res->access_token;

        return $res->access_token;
    }

    /**
     * 当前 Access Token
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * 获取公众号 JS API Ticket
     */
    public function getTicket()
    {
        $JSAPITicket = 'mp_jsapi_ticket';

        if( isset($_SESSION[$JSAPITicket]) ) {
            return $_SESSION[$JSAPITicket];
        }

        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$this->accessToken}&type=jsapi";
        $res = file_get_contents($url);

        if( false === $res ) {
            return;
        }

        $res = json_decode($res);

        if( ! ($res->errcode == 0 && isset($res->ticket)) ) {
            return;
        }

        $_SESSION[$JSAPITicket] = $res->ticket;

        return $res->ticket;
    }

    /**
     * 获取随机字符串
     */
    public function getRandomString($length = 16)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /**
     * 获取当前 URL（不包含 “#” 号之后）
     */
    public function getCurrentUrl()
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $url = explode('#', $url);

        return $url[0];
    }

}
