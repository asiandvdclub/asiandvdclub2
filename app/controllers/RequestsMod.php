<?php


class RequestsMod extends Controller
{
    private $db;
    private $cacheManager;
    private $languageMod;
    private $userClass;

    public function RequestsMod(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');
        $this->cacheManager->setUserStats();
        $this->userClass = $this->cacheManager->getUserStats()['idClass'];
    }
    public function requests(){

        require_once $this->languageMod->getLangPath(__FUNCTION__);
        $this->languageMod->setLanguage(__FUNCTION__);

        $this->view('requests/requests',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }
    public function request(){
        
    }
}