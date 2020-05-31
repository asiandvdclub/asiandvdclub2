<?php


class RequestsMod extends Controller
{
    private $db;
    private $cacheManager;
    private $languageMod;
    private $userClass;
    private $takerequest;
    private $takecontent;
    private $user_cache;

    public function RequestsMod(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');
        $this->takerequest = $this->model('takerequest');
        $this->takecontent = $this->model('takecontent');
        $this->cacheManager->setUserStats();
        $this->user_cache =  $this->cacheManager->getUserStats();
        $this->userClass = $this->user_cache['idClass'];
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
                "requests" => $this->takerequest->getrequest()
            ]);
    }
    public function request($idRequest){
        require_once $this->languageMod->getLangPath(__FUNCTION__);
        $this->languageMod->setLanguage(__FUNCTION__);

        $this->view('requests/request',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }
    public function make_request(){
        require_once $this->languageMod->getLangPath(__FUNCTION__);
        $this->languageMod->setLanguage(__FUNCTION__);

        $error = array(
            "title" => "",
            "content_link" => "",
            "description" => "",
        );

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['sitelanguage'])) {
            $content_data = $this->takerequest->checkForm($_POST);
            if(empty($_POST['req_title']))
                $error['title'] = "Please enter a title!";
            if(empty($content_data['content_id']) || !empty($content_data['error']))
                $error['content_link'] = "Please enter the a vaild link!";
            if(empty($_POST['big_desc']))
                $error['description'] = "Please enter a description!";

            foreach ($error as $value){
                if(!empty($value)){
                    $this->view('requests/make_request',
                        [
                            "currentPage" => "/" . __FUNCTION__,
                            "userStats" => $this->cacheManager->getUserStats(),
                            "getLangDropdown" => $this->languageMod->getLangDropdown(),
                            "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                            "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                            "error" => $error
                        ]);
                    exit();
                    break;
                }
            }

            $this->takecontent->registerContent($_POST['type'], $content_data['content_id']); // No return type to check since the form was checked above but still....
            $_POST['content_id'] = $content_data['content_id'];
            $_POST['uid'] = $this->user_cache['id'];
            $this->takerequest->makerequest($_POST);

            $this->view('requests/make_request',
                [
                    "currentPage" => "/" . __FUNCTION__,
                    "userStats" => $this->cacheManager->getUserStats(),
                    "getLangDropdown" => $this->languageMod->getLangDropdown(),
                    "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                    "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                    "error" => $error,
                    "request_msg" => "<div class=\"box\" style=\"width: 940px; float: inherit\" align=\"center\"><h1>Request Completed</h1></div>"
                ]);
        }else{
            $this->view('requests/make_request',
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