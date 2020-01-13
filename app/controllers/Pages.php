<?php
/**
 * Created by PhpStorm.
 * User: DESKTOP-BUF27
 * Date: 4/15/2019
 * Time: 10:33 PM
 */

class Pages extends Controller {
    private $userModel;
    private $rowUser;
    public function Pages(){

          $this->userModel = $this->model('User');

      }public function isLogged(){
    if($_COOKIE("c_secure_login") == md5("yeah")) {
        if ($_COOKIE["c_secure_pass"] == $this->rowUser)
            return true;
        else
            return false;
    }else{
        return false;
    }
}

    public function index(){
          $posts = $this->userModel->getUserPass();
          $data = [
              'faq' => $posts
          ];

          $this->view('pages/index', $data);
    }
    public function about(){
          $data = [
              'title' => 'About Us'
          ];

          $this->view('pages/about', $data);
    }

  }