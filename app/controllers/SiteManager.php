<?php

class SiteManager extends Controller
{
    private $db;
    private $userClass;
    private $cacheManager;
    private $languageMod;
    private $forum_data;
    private $takesettings;
    private $tracker_info;
    private $forumManager;

    public function SiteManager(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');
        $this->forum_data = $this->model('forum_data');
        $this->takesettings = $this->model('takesettings');
        $this->tracker_info = $this->model('tracker_info');
        $this->forumManager = $this->model('forumManager');

        $this->cacheManager->setUserStats();
        $this->userClass = $this->cacheManager->getUserStats()['idClass'];
    }

    public function staff_panel(){
        $this->languageMod->setLanguage(__FUNCTION__);

        $this->view('site_manager/staff_panel',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }
    public function site_settings(){
        exec("cat /etc/lsb-release", $system_info);
        $os_version = str_replace("DISTRIB_DESCRIPTION=", "", $system_info[3]);
        $os_version = str_replace("\"", "", $os_version);
        $system_info = array();
        $system_info['os_version'] = $os_version;
        $os_version = "";
        $system_info['php_version'] = phpversion();
        foreach (get_loaded_extensions() as $value) $os_version .= $value . ", ";
        $system_info['php_modules'] = $os_version;
        $system_info['memcached'] = str_replace("memcached", "", exec(" memcached -V"));
        unset($os_version);

        $this->languageMod->setLanguage(__FUNCTION__);
        $db_status = $this->db->getStatus();
        $db_status_msg = "<table style='table-layout: auto; border-collapse: collapse; width: 100%'><thead><tr></tr><tr></tr></thead><tbody>";

        foreach ($db_status as $key=>$value) {
            $db_status_msg .= "<tr>" . "<td>" . str_replace("PDO::ATTR_", "", $key) . "</td><td>" . $value .  "</td>";
        }
        $db_status_msg .= "</tbody></table";
        $this->view('site_manager/site_settings',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "db_status" => $db_status_msg,
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                "system_info" => $system_info,
                "tracker_info" => $this->tracker_info->users_data()
            ]);
    }
    public function forum_manager($id = 0){
        $this->languageMod->setLanguage(__FUNCTION__);
        $error = $this->forumManager->error_manager();
        $view_selector = $this->forumManager->add_category_view($id);

        $this->view('site_manager/forum_manager',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "forum_status" => $this->forum_data->getForumStatus(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                //"category" => $this->forum_data->display_forums_manager(),
                "forumData" => $this->forum_data->getForumStatus(),
                "view_settings" => $view_selector,
                "error" => $error
            ]);
    }
    public function forum_manager_forums(){
        $this->languageMod->setLanguage(__FUNCTION__);

        $this->view('site_manager/forum_manager_forums',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "forum_status" => $this->forum_data->getForumStatus(),
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