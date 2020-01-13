<?php
//if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443)
  //  die("false");
// Load config
require_once 'config/config.php';

// Load helpers
require_once 'helpers/session_helper.php';
//Vendor
require_once '../vendor/captcha/captcha.php';
// Auto load core libraries
spl_autoload_register(function ($className){
    require_once 'libraries/' . $className . '.php';
});