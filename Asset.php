<?php

/**
 * Asset 静态资源管理
 * Created by thenbsp
 * Created at 2015-09-01
 */
class Asset
{
    /**
     * 资源文件根 URL
     */
    protected $baseUrl;

    /**
     * 版本号
     */
    protected $version;

    /**
     * 构造方法
     */
    public function __construct($baseUrl = null)
    {
        if( !empty($baseUrl) ) {
            $this->baseUrl = trim($baseUrl, '/') . '/';
        }
    }

    /**
     * 获取资源文件根 URL
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * 获取版本号
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * 设置版本号
     */
    public function setVersion($version, $key = 'version')
    {
        $this->version = http_build_query(array($key=>$version));
    }

    /**
     * 获取 URL
     */
    public function getUrl($fileName, $formatVersion = null)
    {
        $fileName = trim($fileName, '/');
        $fileName = explode('?', $fileName);
        $segments = array($this->baseUrl, current($fileName));

        if( !empty($this->version) ) {
            $segments[] = '?'.$this->version;
        }

        return implode('', $segments);
    }

}
