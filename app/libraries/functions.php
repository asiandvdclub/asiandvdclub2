<?php
function getip() {
    if (isset($_SERVER)) {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && validip($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && validip($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
    } else {
        if (getenv('HTTP_X_FORWARDED_FOR') && validip(getenv('HTTP_X_FORWARDED_FOR'))) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_CLIENT_IP') && validip(getenv('HTTP_CLIENT_IP'))) {
            $ip = getenv('HTTP_CLIENT_IP');
        } else {
            $ip = getenv('REMOTE_ADDR');
        }
    }
    return $ip;
}
function mksecret($len = 20) {
    $ret = "";
    for ($i = 0; $i < $len; $i++)
        $ret .= chr(random_int(33, 126));
    return $ret;
}
function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');
    $out = round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    return $out;
}

function dirToArray($dir) {

    $result = array();

    $cdir = scandir($dir);
    foreach ($cdir as $key => $value)
    {
        if (!in_array($value,array(".","..")))
        {
            if (is_dir($dir . DIRECTORY_SEPARATOR . $value))
            {
                $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value);
            }
            else
            {
                $result[] = $value;
            }
        }
    }

    return $result;
}
function getConfigPath(){
    $db = new Database();
    $db->querry("SELECT config FROM tracker");
    $config = $db->getRow();
    $config = $config['config'];
    return APP_ROUTE . "/config/" . $config . "_config.php";
}
function write_to_file($data, $path){
    $fp = fopen($path, 'w');
    fwrite($fp, $data);
    fclose($fp);
}
function convTime($date){
    $t1 = new DateTime($date);
    $t2 = new DateTime(date("Y-m-d h:i:sa"));
    $interval = $t1->diff($t2);
    $types = array('%y', '%m', '%d', '%h', '%i', '%s');
    $x = 0;
    $out = "";

    foreach ($types as $value){
        if($x==2)  break;
        if($interval->format($value)){
            $out .= $interval->format($value) > 1 ? $interval->format($value) . "  " . textTypes($value) . "s " : $interval->format($value) . "  " . textTypes($value) . " ";
            $x++;
        }
    }

    return $out;
}
function date_to_seconds($date){
    $t1 = new DateTime($date);
    $t2 = new DateTime(date("Y-m-d h:i:sa"));
    $interval = $t1->diff($t2);
    $types = array('%y', '%m', '%d', '%h', '%i', '%s');

    $out = 0;

    foreach ($types as $value){
        if($interval->format($value)){
            switch ($value){
                case '%h':
                    $out += $interval->format($value) * 60 * 60;
                    break;
                case '%i':
                    $out += $interval->format($value) * 60;
                    break;
                case '%s':
                    $out += $interval->format($value);
                    break;
            }
        }
    }

    return $out;
}
function textTypes($types){
    switch ($types){
        case '%y':
            return "year";
            break;
        case '%m':
            return "month";
            break;
        case '%d':
            return "day";
            break;
        case '%h':
            return "hour";
            break;
        case '%i':
            return "minute";
            break;
        case '%s':
            return "second";
            break;
    }
}
function dbg_log($log){
    $log_path = APP_ROUTE . "/torrents/log.txt";
    $current = file_get_contents($log_path);
    $current .= "\n" . date("Y-m-d h:i:sa") . ": ";
    $current .= is_array($log) ? print_r($log, true) : $log;
    $current .= "\n";
    file_put_contents($log_path, $current);
}
function dbg_log_break($log){
    echo "<pre>";
    print_r($log);
    echo "</pre>";
    die();
}
function check_image_link($url){
    $ext_img = array(
        ".png", ".jpg", ".jpeg"
    );

    $p = substr($url, 0, 8);
    $ext = "";
    if($p != "https://")
        return false;
    foreach($ext_img as $value){
        if($value == substr($url, strlen($url)-4, strlen($url)))
            $ext = $value;

    }
    return !empty($ext) ? true : false;
}