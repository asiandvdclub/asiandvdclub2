<?php

class SiteManager extends Controller
{
    private $db;
    private $userClass;
    private $cacheManager;
    private $languageMod;
    private $forum_data;

    public function SiteManager(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');
        $this->forum_data = $this->model('forum_data');

        $this->cacheManager->setUserStats();
        $this->userClass = $this->cacheManager->getUserStats()['idClass'];
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
                "forum_status" => $this->forum_data->getForumStatus(),
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                "category" => $this->forum_data->display_forums_manager(),
            ]);
    }
    public function forum_manager_forums(){
        $this->languageMod->setLanguage(__FUNCTION__);

        $this->view('site_manager/forum_manager_forums',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "forum_status" => $this->forum_data->getForumStatus(),
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }
    //TODO: Add forum funcion and interface
    public function forum_add(){
        $this->db->querry("DELETE FROM forums WHERE `idForum` = :forumID");
       // $this->db->bind(":forumID", $forumID);
        $this->db->execute();
        redirect("forum_manager");
    }
    public function forum_delete($forumID){
        $this->db->querry("DELETE FROM forums WHERE `idForum` = :forumID");
        $this->db->bind(":forumID", $forumID);
        $this->db->execute();
        redirect("forum_manager");
    }
}