<?php

class UserManager extends Controller
{
    private $db;
    private $userClass;
    private $cacheManager;
    private $languageMod;

    public function UserManager(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');

        $this->cacheManager->setUserStats();
        $this->userClass = $this->cacheManager->getUserStats()['idClass'];
    }
    public function profile(){
        $this->languageMod->setLanguage(__FUNCTION__);

        $this->view('user_manager/profile',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }
}