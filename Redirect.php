<?php

/**
 * Header 跳转
 * Created by thenbsp (thenbsp@gmail.com)
 */
function redirect($url = NULL, $code = 302, $method = 'location')
{
    header($method == 'refresh' ? "Refresh:0;url = {$url}" : "Location: {$url}", TRUE, $code);
}
