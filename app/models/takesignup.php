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
            $this->db->querry("INSERT INTO `users` (`username`, `passhash`, `email`, `gender`, `secret`, `confirmHash`,`idLanguage`, `idCountry`, `added` , `last_login`, `last_access`,`class`) 
                                      VALUES (:user, :passhash, :email, :gender, :secret, :confirm, :language, :country, NOW(), NOW(), NOW(), 0)");
            $this->db->bind(':user', $this->data['username']);
            $this->db->bind(':passhash', hash("sha3-256", $secret . $this->data['password'] . $secret . $this->data['username'] . $secret)); // This should changed in the future, but when the first release will be no more.
            $this->db->bind(':email', $this->data['email']);
            $this->db->bind(':gender', $this->data['gender']);
            $this->db->bind(':language', $_SESSION['language']);
            $this->db->bind(':country', $this->data['country']);
            $this->db->bind(':secret', $secret);
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
                   $lang_takesignup['mail_three'] . "IP here" .
                   $lang_takesignup['mail_four'] . "<a href=\"".URL_ROOT . "/confirm/" . $this->confirm_hash . "\">". $lang_takesignup['mail_this_link']. "</a>".
                    $lang_takesignup['mail_four_1'] . URL_ROOT . "/resend".$lang_takesignup['mail_five'];
        $headers = "From: webmaster@" . URL_ROOT . "\r\n";

        if(@mail($this->data['email'], $lang_takesignup['mail_title'], $message, $headers))
        {
            print_r("email has been sent");
            unset($this->confirm_hash);
        }else{
            die("Failed to send confirmation email");
        }
    }
    private function generateConfirmHash(){
        return hash("sha3-256", mksecret(15) . mksecret(20));
    }
    public function checkUser(){
        $this->db->querry("SELECT username FROM users WHERE username = :user");
        $this->db->bind(":user", $this->data['username']);
        $row = $this->db->getRow();
        if(empty($row['username']))
            return false;
        else
            return true;
    }
    public function checkEmail(){
        $this->db->querry("SELECT `value` FROM allowed_emails WHERE `value` = :email");
        $email = '@';
        $email .= substr(strrchr($this->data['email'], "@"), 1);

        $this->db->bind(":email", $email);
        $rows = $this->db->getAll();

        foreach ($rows as $row){
           // print_r($row . "<------>" . $email);
            if($row['value'] == $email)
                return true;
        }
        return false;
    }
}