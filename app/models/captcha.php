<?php
/**
 * Created by PhpStorm.
 * User: DESKTOP-BUF27
 * Date: 4/27/2019
 * Time: 1:23 AM
 */
@session_start();
require_once "../../vendor/captcha/captcha.php";
class captcha{
    public function captcha() {

    }
    public function getCaptcha(){
        return new captcha();
    }
}