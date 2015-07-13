<?php

/**
 * CURL 请求
 * Created by thenbsp (thenbsp@gmail.com)
 */
function curlRequest($url, $options = NULL) {

    $ch = curl_init($url);
    $defaults = array(
        CURLOPT_HEADER => 0,
        CURLOPT_TIMEOUT => 5,
        CURLOPT_RETURNTRANSFER => 1
    );

    // Connection options override defaults if given
    curl_setopt_array($ch, (array) $options + $defaults);

    // Create a response object
    $object = new stdClass;

    // Get additional request info
    $object->response = curl_exec($ch);
    $object->error_code = curl_errno($ch);
    $object->error = curl_error($ch);
    $object->info = curl_getinfo($ch);

    curl_close($ch);

    return $object;
}
