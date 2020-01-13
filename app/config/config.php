<?php
//Frame work
define("NEXUS_PHP_VERSION", "1.6");
//Bitorrent
define("IN_TRACKER", true);
//App route
define('APP_ROUTE',dirname(dirname(__FILE__)));
define('LANG_ROUTE', APP_ROUTE . "/lang/");
//URL route
define('URL_ROOT', 'https://twtpefxuz7.tk');
define('SITE_NAME', 'forum');
//BD Variables
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'dupex!23');
define('DB_NAME', 'nexusphp_updated');

//Register Settings
define('maxUserLenght', 12);
define('minPassLenght', 6);
//User Classes
define ("UC_PEASANT", 0);
define ("UC_USER", 1);
define ("UC_POWER_USER", 2);
define ("UC_ELITE_USER", 3);
define ("UC_CRAZY_USER", 4);
define ("UC_INSANE_USER", 5);
define ("UC_VETERAN_USER", 6);
define ("UC_EXTREME_USER", 7);
define ("UC_ULTIMATE_USER", 8);
define ("UC_NEXUS_MASTER", 9);
define ("UC_VIP", 10);
define ("UC_RETIREE",11);
define ("UC_UPLOADER",12);
//define ("UC_FORUM_MODERATOR", 12);
define ("UC_MODERATOR",13);
define ("UC_ADMINISTRATOR",14);
define ("UC_SYSOP",15);
define ("UC_STAFFLEADER",16);



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

?>