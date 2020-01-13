<?php

class SiteManager extends Controller
{
    private $db;
    private $userClass;
    private $cacheManager;
    private $languageMod;
    public function SiteManager(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');

        $this->cacheManager->setUserStats();
        $this->userClass = $this->cacheManager->getUserStats()['class'];
    }

    public function staff_panel(){
        $this->languageMod->setLanguage(__FUNCTION__);

        $this->view('site_manager/staff_panel',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
            ]);

    }
    public function site_settings(){
        $this->languageMod->setLanguage(__FUNCTION__);

        $this->view('site_manager/site_settings',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }

    public function forum_manager(){
        $this->languageMod->setLanguage(__FUNCTION__);

        $this->view('site_manager/forum_manager',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }
}