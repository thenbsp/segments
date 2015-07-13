<?php

/**
 * 可逆的加密算法
 */
class Crypt {

    public static $auth_key = 'ioOwjLlKs';

    public static function encode($string, $key = '', $expiry = 0) {
        $code = self::authcode($string, 'ENCODE', $key, $expiry);
        return str_replace('=', '', base64_encode($code));
    }

    public static function decode($string, $key = '', $expiry = 0) {
        return self::authcode(base64_decode($string), 'DECODE', $key, $expiry);
    }

    public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
        $ckey_length = 4;
        $key = md5($key != '' ? $key : self::$auth_key);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);

        $string = ($operation == 'DECODE') ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if($operation == 'DECODE') {
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc.base64_encode($result);
        }

    }

}

header("Content-Type:text/html;charset=UTF-8");

$s = '2@RdcWWP';

echo '<p style="font:12px Verdana">';
echo '加密前: ' . $s;
echo '<br /><br />';
echo '加密后: ' . $s1 = Crypt::encode($s, 'aaa');
echo '<br /><br />';
echo '解密后: ' . $s2 = Crypt::decode($s1, 'aaa');
echo '</p>';

?>