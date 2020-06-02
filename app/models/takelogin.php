<?php
/**
 * Created by PhpStorm.
 * User: DESKTOP-BUF27
 * Date: 4/22/2019
 * Time: 1:20 AM
 */

class takelogin
{
    private $data = [];
    private $db;
    public function takelogin(array $data){
        if(empty($data)) die("Wrong page");

        $this->db = new Database();
        $this->data = $data;
    }

    public function checkUser(){
        $usr = $this->data['username'];

        $this->db->querry("SELECT u.secret FROM users u WHERE u.username = :user");
        $this->db->bind(":user", $usr);
        $secret = $this->db->getRow();
        $secret = $secret['secret'];

        $this->db->querry("SELECT u.id, u.username, u.passhash, u.status FROM users u WHERE u.username = :usr AND u.passhash = :ph");
        //Hash the user input password's
        $getPH = hash("sha3-256", $secret . $this->data['password'] . $secret . $this->data['username'] . $secret);

        $this->db->bind(":usr", $usr);
        $this->db->bind(":ph", $getPH);
        $row = $this->db->getRow();

        //Get the password hash from database

        //Get the password hash for cookie side
        //The session will stay up just for the same ip
        $cookiePH =  hash("sha3-256", $row['passhash'] . getip());

        //This is the second check actually, the first check is in the database, see the querry call above
        if($row['username'] == $usr && $getPH == $row['passhash'] && $row['status'] == "confirmed") {
            unset($getPH);
            if($this->data['logout']) {
                $this->logincookie($row['id'], $cookiePH, 900, 1, true);
            }
            else {
                $this->logincookie($row['id'], $cookiePH, 0x7fffffff, 1, true);
            }
            //Two times closed with this
            $this->db->closeDb();
            if(!empty($_SESSION['language']))  unset($_SESSION['language']);
            if(!empty($_SESSION['captcha']))  unset($_SESSION['captcha']);
            //die($_COOKIE['c_secure_uid'] . "<-->" . $_COOKIE['c_secure_pass']);

            redirect("index");//Changed
        }
        else {
            $this->db->closeDb();
            redirect("failedlogin");
        }
    }
    private function logincookie($id, $passhash, $expires = 0x7fffffff, $securelogin=false, $trackerssl=false)
    {
        if ($expires != 0x7fffffff)
            $expires = time()+$expires;

        setcookie("c_secure_uid", base64_encode($id), $expires, "/");
        setcookie("c_secure_pass", $passhash, $expires, "/");
        setcookie("ce mata ai",  "....no comment", time()+0x7fffffff, '/', "twtpefxuz7.tk");

        //Pentru a schimba numele cookie-urilor trebuie schimbat in urmatoarele fisiere: session_helper.php
        if($trackerssl)
            setcookie("c_secure_tracker_ssl", base64_encode("yeah"), $expires, "/");
        else
            setcookie("c_secure_tracker_ssl", base64_encode("nope"), $expires, "/");

        if ($securelogin)
            setcookie("c_secure_login", base64_encode("yeah"), $expires, "/");
        else
            setcookie("c_secure_login", base64_encode("nope"), $expires, "/");


        if(!empty($this->data['language']) || !empty($_SESSION['language'])) {
            setcookie("c_site_language", base64_encode($this->data['language']), $expires, "/");
        }
        else
            die("No language found");
        //Update the user last login
        $this->db->querry("UPDATE users SET last_login = NOW(), idLanguage = :lang WHERE username = :user");
        $this->db->bind(":lang", $this->data['language']);
        $this->db->bind(":user", $this->data['username']);
        $this->db->execute();
    }
}