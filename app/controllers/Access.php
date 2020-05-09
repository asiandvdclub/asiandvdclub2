<?php
/**
 * Created by PhpStorm.
 * User: DESKTOP-BUF27
 * Date: 4/21/2019
 * Time: 8:32 PM
 */
session_start();
class Access extends Controller{
    private $languageMod;
    private $dataMod;
    private $usernameErr = "";
    private $passwordErr = "";
    private $passwordMatchErr = "";
    private $countryErr = "";
    private $genderErr = "";
    private $emailErr = "";
    private $captchaErr = "";
    private $usernameValue = "";
    private $captchaMod = "";

    public function Access(){
        $this->languageMod = $this->model('language');

       // $this->languages = $this->languageMod->getLanguage();

    }
    public function login(){
        //check if language is set to cookie

        //Selected button
        if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['sitelanguage'])) {

            //if(empty($data))
            ////  die("Didn't get post");
            $data = array();
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if (!empty($_POST['logout']) && $_POST['logout'] == "yes")
                $logout = true;
            else
                $logout = false;

            if (!empty($_POST['username']) && !empty($_POST['password'])) {

                $data = array(
                    "username" => htmlentities(trim($_POST['username'])),
                    "password" => $_POST['password'], //clear
                    "logout" => htmlentities($logout),
                    "language"=> $_SESSION['language']//TODO Language can't set
                );
            } else {
                $this->usernameErr = (empty($_POST['username'])) ? "Enter username!" : "";
                $this->passwordErr = (empty($_POST['password'])) ? "Enter password!" : "";
                //change to "" if both are empty
                $this->view("/access/login",
                    ["usernameErr" => $this->usernameErr,
                        "passwordErr" => $this->passwordErr,
                        "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
                    ]
                );
            }
            if (!empty($data['username']) && !empty($data['password'])) {
                $this->dataMod = $this->dataModel("takelogin", $data);
                //Maybe this will bring stack problems to CPU in the code, well see

                $this->dataMod->checkUser();

            }
            //TODO This check needs to be changed
        }elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sitelanguage'])) {

            //HERE
            $_SESSION['language'] = $_POST['sitelanguage'];

            $this->view("/access/login",
                ["usernameErr" => $this->usernameErr,
                    "passwordErr" => $this->passwordErr,
                    "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
                ]
            );
        }else{
            //if(!empty($_POST['sitelanguage']))
           //   $lang = htmlentities(trim($_POST['sitelanguage']));
            $this->view("/access/login",
                ["usernameErr"=>$this->usernameErr,
                 "passwordErr"=>$this->passwordErr,
                    "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
                ]
            );
        }
    }
    public function signup(){
         $this->usernameErr = "";
         $this->passwordErr = "";
         $this->passwordMatchErr = "";
         $this->captchaErr = "";
         $this->genderErr = "";
         $this->emailErr = "";
         $this->countryErr = "";

        if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['sitelanguage'])) {
            $data = array();
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            if(!empty($_POST['wantusername']) && strlen($_POST['wantusername']) <= 12) {

                preg_match_all('/[[:space:]\W]/', $_POST['wantusername'], $matches, PREG_SET_ORDER, 0);
                if($matches)
                    $this->usernameErr =  "use just letters and numbers";
            }
            else
                $this->usernameErr = (empty($_POST['wantusername'])) ? "*" : "username to long";

            if(empty($this->usernameErr))
                $data['username'] = $_POST['wantusername'];
                //array_push($data, "" => $_POST['wantusername']);

            if(!empty($_POST['wantpassword']) && strlen($_POST['wantpassword']) < 5) {
                $this->passwordErr = "password to short";
            }
            if(!empty($_POST['passagain']) && empty($this->passwordErr))
                if($_POST['passagain'] != $_POST['wantpassword']){
                    $this->passwordErr = "";
                    $this->passwordMatchErr = "Password don't match";
                }

            if(empty($_POST['wantpassword']))
                $this->passwordErr = "*";
            if(empty($_POST['passagain']))
                $this->passwordMatchErr = "*";
            if(empty($_POST['captcha']))
                $this->captchaErr = "*";
            if(empty($_POST['email']))
                $this->emailErr = "*";
            if(empty($_POST['gender']))
                $this->genderErr = "*";
            if(empty($_POST['country']) || $_POST['country'] == 99)
                $this->countryErr = "*";

            //------------------------------
            if(empty($this->passwordErr) && empty($this->passwordMatchErr))
                $data['password'] = $_POST['wantpassword'];
            if(empty($this->captchaErr))
                $data['captcha'] = $_POST['captcha'];
            if(empty($this->emailErr))
                $data['email'] = $_POST['email'];
            if(empty($this->genderErr))
                $data['gender'] = $_POST['gender'];
            if(empty($this->countryErr) || $_POST['country'] != 99)
                $data['country'] = $_POST['country'];

            $data['sitelanguage'] = $_POST['sitelanguage'];

            if(empty($this->usernameErr))
                $this->usernameValue = $_POST['wantusername'];

            if(count($data) == 7) {
                $this->dataMod = $this->dataModel('takesignup', $data);
            }else{
                if(empty($this->captchaMod))
                    $this->captchaMod = new captcha();
                $this->view("access/signup",
                    ["usernameErr" => $this->usernameErr,
                        "passwordErr" => $this->passwordErr,
                        "passwordMatchErr" => $this->passwordMatchErr,
                        "genderErr" => $this->genderErr,
                        "captchaErr" => $this->captchaErr,
                        "countryErr" => $this->countryErr,
                        "usernameValue" => $this->usernameValue,
                        "captchaErr" => $this->captchaErr,
                        "captchaImage" => $this->captchaMod->captchaImage($_SESSION['captcha']),
                        "getCountries" => $this->languageMod->getCountries(),
                        "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
                    ]
                );
            }

            if($this->dataMod->checkUser())
                $this->usernameErr = "User already exists";
            if($this->dataMod->checkEmail())
                $this->emailErr = "Email not allowed. See rules.";
            //die($_SESSION['captcha'] . "----------".md5($data['captcha'])." / ".$data['captcha']);
            if(htmlentities(trim($_SESSION['captcha'])) == md5($data['captcha']) && (empty($this->emailErr) && empty($this->usernameErr))) {
                if ($this->dataMod->registerUser()) {
                    unset($_SESSION['captcha']);
                    $this->dataMod->sendConfirmEmail($this->languageMod->getLangPath("takesignup"));
                    $this->view("access/confirm",[
                        "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
                    ]);
                }
                else
                    die("somethings wrong");
            }
            else if(!empty($this->emailErr) || !empty($this->usernameErr)){
                if(empty($this->captchaMod))
                    $this->captchaMod = new captcha();
                $this->view("access/signup",
                    ["usernameErr" => $this->usernameErr,
                        "passwordErr" => $this->passwordErr,
                        "passwordMatchErr" => $this->passwordMatchErr,
                        "genderErr" => $this->genderErr,
                        "captchaErr" => $this->captchaErr,
                        "countryErr" => $this->countryErr,
                        "emailErr" => $this->emailErr,
                        "usernameValue" => $this->usernameValue,
                        "captchaErr" => $this->captchaErr,
                        "usernameErr" => $this->usernameErr,
                        "captchaImage" => $this->captchaMod->captchaImage($_SESSION['captcha']),
                        "getCountries" => $this->languageMod->getCountries(),
                        "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
                    ]
                );
            }
            else{
                if(empty($this->captchaMod))
                    $this->captchaMod = new captcha();
                $this->captchaErr = "Wrong captcha";
                $this->view("access/signup",
                    ["usernameErr" => $this->usernameErr,
                        "passwordErr" => $this->passwordErr,
                        "passwordMatchErr" => $this->passwordMatchErr,
                        "genderErr" => $this->genderErr,
                        "captchaErr" => $this->captchaErr,
                        "countryErr" => $this->countryErr,
                        "usernameValue" => $this->usernameValue,
                        "captchaErr" => $this->captchaErr,
                        "captchaImage" => $this->captchaMod->captchaImage($_SESSION['captcha']),
                        "getCountries" => $this->languageMod->getCountries(),
                        "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
                    ]
                );
            }

        }elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sitelanguage'])) {
            $_SESSION['language'] = $_POST['sitelanguage'];
           // if(empty($this->captchaMod))
         //       $this->captchaMod = new captcha();
            if(empty($this->captchaMod))
                $this->captchaMod = new captcha();
            $this->view("access/signup",
                ["usernameErr" => $this->usernameErr,
                    "passwordErr" => $this->passwordErr,
                    "passwordMatchErr" => $this->passwordMatchErr,
                    "genderErr" => $this->genderErr,
                    "captchaErr" => $this->captchaErr,
                    "countryErr" => $this->countryErr,
                    "usernameValue" => $this->usernameValue,
                    "captchaErr" => $this->captchaErr,
                    "captchaImage" => $this->captchaMod->captchaImage($_SESSION['captcha']),
                    "getCountries" => $this->languageMod->getCountries(),
                    "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
                ]
            );

        }else {
            if(empty($this->captchaMod))
                $this->captchaMod = new captcha();
           // $this->captchaMod = new captcha();//$this->model('getCaptcha');
            $this->view("access/signup",
                ["usernameErr" => $this->usernameErr,
                    "passwordErr" => $this->passwordErr,
                    "passwordMatchErr" => $this->passwordMatchErr,
                    "genderErr" => $this->genderErr,
                    "captchaErr" => $this->captchaErr,
                    "countryErr" => $this->countryErr,
                    "usernameValue" => $this->usernameValue,
                    "captchaErr" => $this->captchaErr,
                    "captchaImage" => $this->captchaMod->captchaImage($_SESSION['captcha']),
                    "getCountries" => $this->languageMod->getCountries(),
                    "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
                ]
            );
        }
    }
    public function failedlogin(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sitelanguage'])) {
            //HERE
            $_SESSION['language'] = $_POST['sitelanguage'];

            $this->view("/access/failedlogin",
                [
                    "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
                ]
            );
        }else{
            $this->view("/access/failedlogin",
                [
                    "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
                ]
            );
        }
    }
    private function viewSignup(){

    }
    public function closedSignUp(){
        die("Closed");
    }
    public function confirm($hash){
       $db = new Database();
       $db->querry("SELECT confirmHash FROM users WHERE confirmHash = :hash");
       $db->bind(":hash", $hash);
       $confirm_hash = $db->getRow();
       $confirm_hash = $confirm_hash['confirmHash'];

       if(!empty($confirm_hash) && $confirm_hash == $hash) {
           $db->querry("UPDATE users SET status='confirmed' WHERE confirmHash = :hash");
           $db->bind(":hash", $hash);
           $db->execute();
           $this->view("access/confirmed",[
               "getLangPath"=>$this->languageMod->getLangPath(__FUNCTION__)
           ]);
       }else{
           redirect('failedlogin');
       }
    }
    public function recover(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sitelanguage'])) {
            $this->view("access/recover", [
                "getLangPath" => $this->languageMod->getLangPath(__FUNCTION__)
            ]);
        }else{
            $this->view("access/recover", [
                "getLangPath" => $this->languageMod->getLangPath(__FUNCTION__)
            ]);
        }
    }
    public function confirm_resend(){
        $emailErr = "";
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data["email"] = $_POST['email'];
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email!";
                $this->view("access/confirm_resend", [
                    "getLangPath" => $this->languageMod->getLangPath(__FUNCTION__),
                    "emailErr" => $emailErr
                ]);
            }
            $takerecover = $this->dataModel('takesignup', $data);
            $resp = $takerecover->confirm_resend($this->languageMod->getLangPath("takesignup"));
            if(!is_array($resp)) {
                $this->view("access/confirm_resend", [
                    "getLangPath" => $this->languageMod->getLangPath(__FUNCTION__)
                ]);
            }else{
                $this->view("access/confirm_resend", [
                    "getLangPath" => $this->languageMod->getLangPath(__FUNCTION__),
                    "emailErr" => $resp['emailErr']
                ]);
            }
        }else{
            $this->view("access/confirm_resend", [
                "getLangPath" => $this->languageMod->getLangPath(__FUNCTION__)
            ]);
        }
    }
    public function show()
    {
        echo "<h1>What UP?</h1>";
    }
}