<?php

/**
 * 根据两个经/纬度获取之间的距离
 * Created by thenbsp (thenbsp@gmail.com)
 * @param  float $lat1 纬度1
 * @param  float $lng1 经度1
 * @param  float $lat2 纬度2
 * @param  float $lng2 经度2
 * @return float
 */
function getDistanceByCoords($lat1, $lng1, $lat2, $lng2) {
    $pi80 = M_PI / 180;
    $lat1 *= $pi80;
    $lng1 *= $pi80;
    $lat2 *= $pi80;
    $lng2 *= $pi80;
    // mean radius of Earth in km
    $r = 6378.137;
    $dlat = $lat2 - $lat1;
    $dlng = $lng2 - $lng1;
    $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $km = $r * $c * 1000;
    return round($km);
}

// Example:

// $coods1 = array('lng'=>109.022411, 'lat'=>34.428162);
// $coods2 = array('lng'=>109.021019, 'lat'=>34.366846);

// $result = getDistanceByCoords($coods1['lat'], $coods1['lng'], $coods2['lat'], $coods2['lng']);
