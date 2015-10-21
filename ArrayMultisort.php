<?php

/**
 * 多维数组排序，根据指定 Key
 * Created by thenbsp (thenbsp@gmail.com)
 */
function arrayMultisort(array &$array, $sortBy, $sortOrder = SORT_DESC)
{
    if (!count(array_filter($array))) {
        return;
    }

    $tmp = array();
    foreach ($array AS $k=>$v) {
        $tmp[$k] = $v[$sortBy];
    }

    array_multisort($tmp, $sortOrder, $array);
    unset($tmp);
}
