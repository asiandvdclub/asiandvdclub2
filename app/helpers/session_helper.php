<?php
/**
 * Created by PhpStorm.
 * Date: 4/20/2019
 * Time: 8:44 PM
 */
session_start();

function isLogged(){
    $tempDB = new Database();
    if(empty($_COOKIE["c_secure_login"]) or empty($_COOKIE['c_secure_uid']))
        return false;

    $tempDB->querry('SELECT u.passhash FROM users as u WHERE u.id = :user');
    // c_secure_id <-- find other method to get the passhash
    $tempDB->bind(':user', base64_decode($_COOKIE['c_secure_uid']));
    $val = $tempDB->getRow();
    $tempDB->closeDb(); // TODO if something is up remove this
    //setcookie("lang", $lang);

    if($_COOKIE["c_secure_login"] == base64_encode("yeah")) {
        if ($_COOKIE["c_secure_pass"] == hash("sha3-256", $val['passhash'] . getip())) {
            unset($val);
            return true;
        }else {
            return false;
        }
    }else{
        return false;
    }
}

//Set the default language, look to table language in database
function setLanguage(){
    //6 is for Engish
    $_SESSION['language'] = 6;
}
function getLanguage(){
    if(isset($_SESSION['language']))
        return $_SESSION['language'];
    else
        //This should trow an error to site panel
        return "Enable cookie";
}

function redirect($page){
    header('location: ' . URL_ROOT . '/' . $page);
}
