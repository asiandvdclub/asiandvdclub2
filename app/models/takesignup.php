<?php
/**
 * Created by PhpStorm.
 * User: DESKTOP-BUF27
 * Date: 4/25/2019
 * Time: 12:58 PM
 */


class takesignup
{
    private $db;
    private $data;
    private $confirm_hash;
    public function takesignup($data){
        $this->db = new Database();
        $this->data = $data;
    }
    public function registerUser()
    {
        $secret = mksecret(random_int(10, 20));
        try {
            $this->db->querry("INSERT INTO `users` (`username`, `passhash`, `email`, `gender`, `secret`, `confirmHash`,`idLanguage`, `idCountry`,  `passkey`, `ip`, `added` , `last_login`, `last_access`,`idClass`) 
                                      VALUES (:user, :passhash, :email, :gender, :secret, :confirm, :language, :country, :passkey, :ip, NOW(), NOW(), NOW(), 2)");
            $this->db->bind(':user', $this->data['username']);
            $this->db->bind(':passhash', hash("sha3-256", $secret . $this->data['password'] . $secret . $this->data['username'] . $secret)); // This should changed in the future, but when the first release will be no more.
            $this->db->bind(':email', $this->data['email']);
            $this->db->bind(':gender', $this->data['gender']);
            $this->db->bind(':language', $_SESSION['language']);
            $this->db->bind(':country', $this->data['country']);
            $this->db->bind(':secret', $secret);
            $this->db->bind(':ip', getip());
            $this->db->bind(':passkey', hash("sha3-256", mksecret(55, 75) . $this->data['password'] . mksecret(9, 28)));

            $this->confirm_hash = $this->generateConfirmHash();
            $this->db->bind(':confirm', $this->confirm_hash);
            //TODO IP need to get recorded
            if($this->db->execute())
                return true;
            else
                return false;
        } catch (PDOException $e){
            echo 'Exception -> ';
            var_dump($e->getMessage());
        }
    }
    public function sendConfirmEmail($lang){
        require_once $lang;

        $message = $lang_takesignup['mail_one'] . $this->data['username'] .
                   $lang_takesignup['mail_two'] . $this->data['email'] .
                   $lang_takesignup['mail_three'] . getip() .
                   $lang_takesignup['mail_four'] . "<a href=\"" . URL_ROOT . "/confirm/" . $this->confirm_hash . "\">". $lang_takesignup['mail_this_link']. "</a>".
                   $lang_takesignup['mail_four_1'] . "<a href=\"" . URL_ROOT . "/resend>This link</a>" . $lang_takesignup['mail_five'];
        $headers = "From: webmaster@" . URL_ROOT . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        if(@mail($this->data['email'], $lang_takesignup['mail_title'], $message, $headers))
        {
            //print_r("email has been sent");
            unset($this->confirm_hash);
        }else{
            die("Failed to send confirmation email");
        }
    }
    private function generateConfirmHash(){
        return hash("sha3-256", mksecret(15) . mksecret(20));
    }
    public function checkUser(){
        $this->db->querry("SELECT `username` FROM `users` WHERE `username` = :user");
        $this->db->bind(":user", $this->data['username']);
        $row = $this->db->getRow();
        if(empty($row['username']))
            return false;
        else
            return true;
    }
    public function checkEmail(){
        $this->db->querry("SELECT `value` FROM `allowed_emails` WHERE `value` = :email");
        $email = '@';
        $email .= substr(strrchr($this->data['email'], "@"), 1);
        $this->db->bind(":email", $email);
        $row = $this->db->getAll();

        if(empty($row))
            return true;
        else
            return false;
    }
    public function confirm_resend($lang){
        require_once $lang;

        $this->db->querry("SELECT username FROm users WHERE email = :email");
        $this->db->bind(':email', $this->data);
        $resp = $this->db->getRow();

        if(empty($resp) || isset($resp['username']))
            return array("emailErr" =>"User doesn't exist or banned!");
        $this->confirm_hash = generateConfirmHash();

        $message =  $lang_takesignup['mail_one'] . !empty($resp['username']) ? $resp['username'] : "error" .
                    $lang_takesignup['mail_two'] . $this->data .
                    $lang_takesignup['mail_three'] . getip() .
                    $lang_takesignup['mail_four'] . "<a href=\"" . URL_ROOT . "/confirm/" . $this->confirm_hash . "\">". $lang_takesignup['mail_this_link']. "</a>".
                    $lang_takesignup['mail_four_1'] . "<a href=\"" . URL_ROOT . "/resend>This link</a>" . $lang_takesignup['mail_five'];
        $headers = "From: webmaster@" . URL_ROOT . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        if(!empty($resp) && @mail($this->data, $lang_takesignup['mail_title'], $message, $headers)) {

            $this->db->querry("UPDATE users SET confirmHash = :hash WHERE email = :email");
            $this->db->bind(':hash', $this->confirm_hash);
            $this->db->bind(':email', $this->data['email']);
            $this->db->execute();
            return true;
        }else {
            return false;
        }
    }
    public function recover(){

    }
}