<?php

/**
 * 根据 ID 获取目录路径（最大 999999999）
 * Created by thenbsp (thenbsp@gmail.com)
 */
function get_directory_by_id($id) {

    $id = abs(intval($id));
    $id = sprintf("%09d", $id);

    $s1 = substr($id, 0, 3);
    $s2 = substr($id, 3, 3);
    $s3 = substr($id, 6, 3);

    return $s1.'/'.$s2.'/'.$s3;
}
