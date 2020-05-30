<?php
define("announce_interval", 900);
define("announce_interval_min", 300);
//Frame work
/*Version schematic
Example for 1.0.30
1 -> version
0 -> beta, 0 for no beta -> wasn't in production
30 -> reset from nr. of comits see git repo
*/
define("ADC_FRAMEWORK", "1.0.31");
//Bitorrent
define("IN_TRACKER", true);
//App route
define('APP_ROUTE',dirname(dirname(__FILE__)));
define('APP_IMAGE', dirname(APP_ROUTE) . "/public/images");
define('IMDB_IMAGES', APP_IMAGE . "/imdb/");
define('LANG_ROUTE', APP_ROUTE . "/lang/");
//URL route
define('URL_ROOT', 'http://192.168.1.2');
define('SITE_NAME', 'forum');
//BD Variables
define('DB_HOST', 'localhost');
define('DB_USER', 'duplex');
define('DB_PASS', '123123');
define('DB_NAME', 'nexusphp_updated');
//Folders
define('DIR_TORRENTS', APP_ROUTE . '/torrents/');
define('DIR_IMAGES', 'images/');
//Header
define('TORRENT_HEADER', 'application/x-bittorrent');

//Register Settings
define('maxUserLenght', 12);
define('minPassLenght', 6);
//User Classes
define ("UC_IGNORANT", 1);
define ("UC_BEGGINER", 2);
define ("UC_CANDIDATE", 3);
define ("UC_ASSOCIATE", 4);
define ("UC_EXPERT", 5);
define ("UC_MASTER", 6);
define ("UC_HIERARCH", 7);
define ("UC_UPLOADER", 8);
define ("UC_SUPPORTER", 9);
define ("UC_SYSOP", 10);

function writeConfig( $filename, $config ) {
    $fh = fopen($filename, "w");
    if (!is_resource($fh)) {
        return false;
    }
    foreach ($config as $key => $value) {
        fwrite($fh, sprintf("%s = %s\n", $key, $value));
    }
    fclose($fh);

    return true;
}

function readConfig( $filename ) {
    return parse_ini_file($filename, false, INI_SCANNER_NORMAL);
}