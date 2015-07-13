<?php

/**
 * 格式化字节数
 * Created by thenbsp (thenbsp@gmail.com)
 */
function format_size($size) {

    $units = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB');

    for( $i = 0; $size > 1024; $i++ ) {
        $size /= 1024;
    }

    return sprintf('Size unit '.$units[$i], round($size, 2));
}