<?php
function block_browser()
{
    $agent = $_SERVER["HTTP_USER_AGENT"];
    if (preg_match("/^Mozilla/", $agent) || preg_match("/^Opera/", $agent) || preg_match("/^Links/", $agent) || preg_match("/^Lynx/", $agent) )
        die("Browser access blocked!");
// check headers
    if (function_exists('getallheaders')){ //getallheaders() is only supported when PHP is installed as an Apache module
        $headers = getallheaders();
        //else
        //	$headers = emu_getallheaders();
        if($_SERVER["HTTPS"] != "on")
        {
            if (isset($headers["Cookie"]) || isset($headers["Accept-Language"]) || isset($headers["Accept-Charset"]))
                die("Anti-Cheater: You cannot use this agent");
        }
    }
}