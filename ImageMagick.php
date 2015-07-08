<?php

/**
 * 图像操作类（可以操作 GIF），主要基于 PHP Imagick 扩展
 * Created by thenbsp (thenbsp@gmail.com)
 */
class ImageMagick {

    /**
     * Imagick instance
     */
    protected $im;

    /**
     * 显示错误消息
     */
    protected $error;

    /**
     * 另存为名称
     */
    protected $targetName;

    /**
     * 图像水印路径
     */
    protected $watermarkFile = NULL;

    /**
     * 水印位置
     */
    protected $watermarkPosition = 9;

    /**
     * 构造方法
     */
    public function __construct($image = NULL) {

        // This check is an alternative to the previous one.
        if ( ! class_exists('Imagick') ) {
            throw new Exception('Imagick class does not exist');
        }

        if( ! is_file($image) ) {
            throw new Exception('Invalid file');
        }

        if( ! is_writable($image) ) {
            throw new Exception('File unreadable');
        }

        if( is_null($this->targetName) ) {
            $this->targetName = $image;
        }

        $this->im = new Imagick($image);
    }

    /**
     * 析构方法
     */
    public function __destruct() {
        $this->clear();
    }

    /**
     * 销毁对象
     */
    public function clear() {
        if( $this->im instanceof Imagick ) {
            $this->im->clear();
        }
    }

    /**
     * 设置另存为名称
     */
    public function setTargetName($targetName) {
        $this->targetName = $targetName;
    }

    /**
     * 设置图像水印
     */
    public function setWatermarkFile($filepath) {
        if( is_file($filepath) ) {
            $this->watermarkFile = $filepath;
        }
    }

    /**
     * 获取错误消息
     */
    public function getError() {
        return $this->error;
    }

    /**
     * 获取宽度
     */
    public function getWidth() {
        return $this->im->getImageWidth();
    }

    /**
     * 获取高度
     */
    public function getHeight() {
        return $this->im->getImageHeight();
    }

    /**
     * 获取文件大小（单位：字节）
     */
    public function getLength() {
        return $this->im->getImageLength();
    }

    /**
     * 获取帧数
     */
    public function getFrames() {
        return $this->im->getNumberImages();
    }

    /**
     * 获取格式
     */
    public function getFormat($upper = FALSE) {

        $format = $this->im->getImageFormat();
        $format = strtolower($format);

        // jpeg to jpg
        if( $format === 'jpeg' ) {
            $format = 'jpg';
        }

        return $upper ? strtoupper($format) : $format;
    }

    /**
     * 检测是否为指定格式
     */
    public function isFormat($format) {
        return (strtolower($format) === $this->getFormat());
    }

    /**
     * 根据宽度缩放
     */
    public function resize($maxWidth, $minWidth = 0) {

        $width = $this->getWidth();

        // 如果在范围内就不缩放了
        if( ($width <= $maxWidth) AND ($width >= $minWidth) ) {
            return;
        }

        if( $width > $maxWidth ) {
            $width = $maxWidth;
        } else {
            $width = (($minWidth > 0 ) AND ($width < $minWidth)) ? $minWidth : $width;
        }

        if( $this->getFrames() > 1 ) {
            foreach($this->im AS $frame) {
                $frame->resizeImage($width, NULL, Imagick::FILTER_SINC, NULL);
            }
            $this->im->writeImages($this->targetName, TRUE);
        } else {
            $this->im->resizeImage($width, NULL, Imagick::FILTER_SINC, NULL);
            $this->im->writeImage($this->targetName);
        }
    }

    /**
     * 提取预览图
     */
    public function preview() {

        if( $this->getFrames() > 1 ) {
            foreach($this->im AS $frame) {
                $this->im->writeImage($this->targetName);
                break;
            }
        } else {
            $this->im->writeImage($this->targetName);
        }
    }

    /**
     * 添加水印
     */
    public function watermark() {

        if( ! is_file($this->watermarkFile) ) {
            throw new Exception('Watermark file not found');
        }

        $watermark = new Imagick($this->watermarkFile);

        if( $watermark->getImageWidth() > $this->getWidth() ) {
            throw new Exception('Watermark file too width');
        }

        if( $watermark->getImageHeight() > $this->getHeight() ) {
            throw new Exception('Watermark file too height');
        }

        $dw = new ImagickDraw();
        $dw->setFillOpacity (0.8);
        $dw->setGravity($this->watermarkPosition); 
        $dw->composite($watermark->getImageCompose(), 0, 0, 0, 0, $watermark);

        if( $this->getFrames() > 1 ) {
            foreach($this->im AS $frame) {
                $this->im->drawImage($dw); 
            }
            $this->im->writeImages($this->targetName, TRUE);
        } else {
            $this->im->drawImage($dw); 
            $this->im->writeImage($this->targetName);
        }
    }

    /**
     * 根据坐标裁剪
     */
    public function crop($w, $h, $x, $y) {

        if( $this->getFrames() > 1 ) {
            foreach($this->im AS $frame) {
                $frame->cropImage($w, $h, $x, $y);
                $frame->setImagePage($w, $h, 0, 0);
            }
            $this->im->writeImages($this->targetName, TRUE);
        } else {
            $this->im->cropImage($w, $h, $x, $y);
            $this->im->writeImage($this->targetName);
        }
    }

}
