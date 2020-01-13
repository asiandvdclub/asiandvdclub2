<?php
/**
 * Created by PhpStorm.
 * User: DESKTOP-BUF27
 * Date: 4/24/2019
 * Time: 8:06 PM
 */
@session_start();
class language{
    private $db;
    public function language(){
        $this->db = new Database();
    }
    public function getLangDropdown(){
        if(empty($_SESSION['language']))
            die("It didn't set ".$_SESSION['language']);

        $this->db->querry('SELECT idLanguage, lang_name FROM language WHERE trans_state = "up-to-date"');
        $rows = $this->db->getAll();
        //print_r($rows);
        $prepare =  "<select name = \"sitelanguage\" onchange='submit()'>";

        foreach ($rows as $row)
            $prepare .= "<option value=" . $row['idLanguage']. " " . (($_SESSION['language']==$row['idLanguage'] || base64_decode($_COOKIE['c_site_language'])==$row['idLanguage'])? "selected" : "") . ">" . $row['lang_name'] . "</option>";
        $prepare .= "</select>";

        return $prepare;
    }
    public function getCountries(){

        $this->db->querry('SELECT idCountry, name FROM countries');
        $rows = $this->db->getAll();
        //print_r($rows);
        $prepare =  "<select name = \"country\">";
        $prepare .= "<option value=\"99\">---- None selected ----</option>";
        foreach ($rows as $row)
            $prepare .= "<option value=".$row['idCountry'].">".$row['name']."</option>";
        $prepare .= "</select>";

        return $prepare;
    }
    public function getLangPath($curentFile){
        if(!empty($_COOKIE['language']) || isset($_COOKIE['c_site_language'])) {
            $this->db->querry("SELECT l.site_lang_folder FROM language l WHERE l.idLanguage = :lang");
            $this->db->bind(":lang", base64_decode($_COOKIE['c_site_language']));
            $langFolder = $this->db->getRow();
            $langFolder = $langFolder['site_lang_folder'] . "/lang_";

            return LANG_ROUTE . $langFolder . $curentFile . ".php";
        }
        if(!empty($_SESSION['language'])) {

            $this->db->querry("SELECT l.site_lang_folder FROM language l WHERE l.idLanguage = :lang");
            $this->db->bind(":lang", htmlentities($_SESSION['language']));
            $langFolder = $this->db->getRow();
            $langFolder = $langFolder['site_lang_folder'] . "/lang_";
            return LANG_ROUTE . $langFolder . $curentFile . ".php";
        }
        //The $_SESSION needs to be removed in the future
    }
    public function getSiteLangHeader(){
        $this->db->querry("SELECT l.site_lang_folder FROM language l WHERE l.idLanguage = :lang");
        $this->db->bind(":lang", base64_decode($_COOKIE['c_site_language']));
        $langFolder = $this->db->getRow();
        $langFolder = $langFolder['site_lang_folder'] . "/lang_";
        return LANG_ROUTE . $langFolder . "functions.php";
    }
    public function setLanguage($currentPage){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sitelanguage'])) {
            $expires = time() + 0x7fffffff;
            setcookie("c_site_language", base64_encode($_POST['sitelanguage']), $expires, "/");
            redirect($currentPage);
        }
    }
}