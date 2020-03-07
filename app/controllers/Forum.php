<?php

class Forum extends Controller
{
    private $db;
    private $cacheManager;
    private $languageMod;
    private $userClass;
    private $forum_data;

    public function Forum(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');
        $this->forum_data = $this->model('forum_data');

        $this->cacheManager->setUserStats();
        $this->userClass = $this->cacheManager->getUserStats()['idClass'];
    }
    public function forums(){
        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sitelanguage'])) {
            $expires = time() + 0x7fffffff;
            setcookie("c_site_language", base64_encode($_POST['sitelanguage']), $expires, "/");
            redirect(__FUNCTION__);
        }else {
            $this->view('forum/forums',
                [
                    "currentPage" => "/" . __FUNCTION__,
                    "userStats" => $this->cacheManager->getUserStats(),
                    "getLangDropdown" => $this->languageMod->getLangDropdown(),
                    "getLangPath" => $this->languageMod->getLangPath(__FUNCTION__),
                    "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                    "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
                    "category" => $this->forum_data->display_forums(),
                ]);
        }
    }
    public function in_forum(){

    }
    public function post(){

    }
}