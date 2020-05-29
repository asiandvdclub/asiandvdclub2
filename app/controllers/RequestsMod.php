<?php


class RequestsMod extends Controller
{
    private $db;
    private $cacheManager;
    private $languageMod;
    private $userClass;
    private $takerequest;

    public function RequestsMod(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');
        $this->takerequest = $this->model('takerequest');
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

        require_once $this->languageMod->getLangPath(__FUNCTION__ . "s");
        $this->languageMod->setLanguage(__FUNCTION__ . "s");
        $error = array(
            "title" => "",
            "content_link" => "",
            "description" => "",
        );

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['sitelanguage'])) {
            if(empty($_POST['req_title']))
                $error['title'] = "Please enter a title!";
            if(empty($_POST['content_link']))
                $error['content_link'] = "Please enter the a vaild link!";
            if(empty($_POST['description']))
                $error['title'] = "Please enter a description!";
            foreach ($error as $value){
                if(!empty($value)){
                    $this->view('requests/request',
                        [
                            "currentPage" => "/" . __FUNCTION__,
                            "userStats" => $this->cacheManager->getUserStats(),
                            "getLangDropdown" => $this->languageMod->getLangDropdown(),
                            "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                            "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                            "error" => $error
                        ]);
                    break;
                }
            }

            $this->view('requests/request',
                [
                    "currentPage" => "/" . __FUNCTION__,
                    "userStats" => $this->cacheManager->getUserStats(),
                    "getLangDropdown" => $this->languageMod->getLangDropdown(),
                    "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                    "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                    "error" => $error
                ]);
        }else{
            $this->view('requests/request',
                [
                    "currentPage" => "/" . __FUNCTION__,
                    "userStats" => $this->cacheManager->getUserStats(),
                    "getLangDropdown" => $this->languageMod->getLangDropdown(),
                    "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                    "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                    "error" => $error
                ]);
        }
    }
}