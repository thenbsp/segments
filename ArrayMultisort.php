<?php

/**
 * 多维数组排序，根据指定 Key
 * Created by thenbsp (thenbsp@gmail.com)
 */
function arrayMultisort(&$array, $sortBy, $sortOrder = SORT_DESC)
{
    if (!count(array_filter($array))) {
        return;
    }

    $temp = array();
    foreach ($array AS $k=>$v) {
        $temp[$k] = (gettype($v) === 'object') ? $v->$sortBy : $v[$sortBy];
    }

    array_multisort($temp, $sortOrder, $array);
}
