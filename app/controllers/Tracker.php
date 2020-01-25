<?php


class Tracker extends Controller
{
    private $db;
    private $cacheManager;
    private $languageMod;
    private $userClass;
    public function Tracker(){

        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');

        $this->cacheManager->setUserStats();

        $this->userClass = $this->cacheManager->getUserStats()['class'];
    }
    public function torrents(){
        require_once $this->languageMod->getLangPath(__FUNCTION__);

        $this->languageMod->setLanguage(__FUNCTION__);
        $this->view('tracker/torrents',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }
    public function upload(){
        require_once $this->languageMod->getLangPath(__FUNCTION__);

        $this->languageMod->setLanguage(__FUNCTION__);
        $this->view('tracker/upload',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }
}