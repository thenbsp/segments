<?php

/**
 * 生成绝对唯一 ID（String ID）
 * Created by thenbsp (thenbsp@gmail.com)
 */
public function generateUniqid($db) {
    $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    while(true) {
        $id = '';
        for($i = 0; $i < 10; $i ++) {
            $id .= $pool[rand(0, strlen($pool) -1)];
        }
        $query = $db->query(sprintf('SELECT * FROM tableName WHERE id = %d', $id));
        if ( ! $query->num_rows() ) {
            return $id;
        }
    }
}

