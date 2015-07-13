<?php

/**
 * 检测目录是否可写
 * Created by thenbsp (thenbsp@gmail.com)
 */
function directory_is_writable($dir, $chmod = 0755) {
    // If it doesn't exist, and can't be made
    if(! is_dir($dir) AND ! mkdir($dir, $chmod, TRUE)) return FALSE;

    // If it isn't writable, and can't be made writable
    if(! is_writable($dir) AND !chmod($dir, $chmod)) return FALSE;

    return TRUE;
}
