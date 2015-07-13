<?php

/**
 * 清除HTML中的属性
 * Created by thenbsp (thenbsp@gmail.com)
 *
 * $string      要清除的字符串
 * $attr        要清除的属性名 style/width/height/border/target/id/class
 * $annotate    是否去除注释
 */
function remove_attr($string, $attr = FALSE, $annotate = TRUE) {
    $data = '';
    if( $attr === FALSE )
        $data = $string;
    if( $attr AND ! empty($attr) ) {
        $attr = (array) $attr;
        foreach($attr AS $preg) {
            $string = preg_replace("/\s$preg=.+?['|\"]/i", '', $string);
        }
        $data = $string;
    }
    return $annotate ? preg_replace("/<!--[^>]*-->/i", '', $data) : $data;
}

$str = '<!--asdf--><a href="javascript:;" style="background:#FF0000; width:100; height:200" width="100" height="100" target="_blank">Google 一下，你就知道</a>';

echo remove_attr($str, array('style', 'width', 'height', 'target'), true);
