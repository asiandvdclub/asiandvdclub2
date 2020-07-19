<?php

class UserManager extends Controller
{
    private $db;
    private $userClass;
    private $cacheManager;
    private $languageMod;
    private $takeprofile;
    private $cache_data;

    public function UserManager(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');

        $this->cacheManager->setUserStats();
        $this->cache_data = $this->cacheManager->getUserStats();
        $this->userClass = $this->cache_data['idClass'];

        $this->takeprofile = $this->dataModel('takeprofile', $this->cache_data);
    }
    public function profile(){
        $this->languageMod->setLanguage(__FUNCTION__);

        $this->view('user_manager/profile',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                "user_data" => $this->cache_data,
                "last_seen" => $this->cacheManager->getLastSeen()
            ]);
    }
}