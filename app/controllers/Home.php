<?php
/**
 * Created by PhpStorm.
 * User: DESKTOP-BUF27
 * Date: 4/15/2019
 * Time: 10:33 PM
 */

class Home extends Controller {
    private $db;
    private $cacheManager;
    private $languageMod;
    private $index;
    private $userClass;
    private $tracker_info;

    public function Home(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');
        $this->index = $this->model('index');
        $this->tracker_info = $this->model('tracker_info');

        $this->cacheManager->setUserStats();

        $this->userClass = $this->cacheManager->getUserStats()['idClass'];
    }
    public function index(){
        require_once $this->languageMod->getLangPath(__FUNCTION__);
         //print_r($this->ch->getStatus());
         // Set cache if its empty by grabbing from DB

            //date('m/d/Y h:i:s a', time())." ".date_default_timezone_get();
        $this->languageMod->setLanguage(__FUNCTION__);
        $this->view('pages/index',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "news" => $this->index->news($lang_index, $this->userClass), // I know this $lang_index doesn't look good here but this works on the fly due to require above
                "lang_index" => $lang_index,
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
                "tracker_info" => $this->tracker_info->users_data()
            ]);
    }
    public function rules(){
        require_once $this->languageMod->getLangPath(__FUNCTION__);

        $this->languageMod->setLanguage(__FUNCTION__);
        $this->view('pages/rules',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "news" => $this->index->news($lang_index, $this->userClass), // I know this $lang_index doesn't look good here but this works on the fly due to require above
                "lang_index" => $lang_index,
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }
    public function faq(){
        require_once $this->languageMod->getLangPath(__FUNCTION__);

        $this->languageMod->setLanguage(__FUNCTION__);
        $this->view('pages/faq',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "news" => $this->index->news($lang_index, $this->userClass), // I know this $lang_index doesn't look good here but this works on the fly due to require above
                "lang_index" => $lang_index,
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }
    public function donation(){
        require_once $this->languageMod->getLangPath(__FUNCTION__);
        $this->languageMod->setLanguage(__FUNCTION__);

        $this->view('pages/donation',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "news" => $this->index->news($lang_index, $this->userClass), // I know this $lang_index doesn't look good here but this works on the fly due to require above
                "lang_index" => $lang_index,
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
            ]);
    }
    //TODO don't check for class here, move this to the CORE level, there will be more function that this one, keep it clean.!!!!
    public function create_news(){
        $this->languageMod->setLanguage(__FUNCTION__);
        // Manage evey function that requires high user class with a model
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['sitelanguage'])) {
            $this->db->querry("INSERT INTO `news` (`title`, `text`, `added`, `addedBy`) VALUES (:title, :text, NOW(), :uid)");
            $this->db->bind(":uid", base64_decode($_COOKIE['c_secure_uid']));
            $this->db->bind(":title", $_POST['title']);
            $this->db->bind(":text", $_POST['text_area']);
            if ($this->db->execute())
                redirect('');
            else
                die("fail");
        }else {
            $this->view('pages/create_news',
                [
                    "currentPage" => "/create_news",
                    "userStats" => $this->cacheManager->getUserStats(),
                    "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                    "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
                ]);
        }
    }
    public function delete_news($newsId){
        if(UC_SYSOP == $this->userClass) {
            $this->db->querry("DELETE FROM `news` WHERE :id = idNews");
            $this->db->bind(":id", $newsId);
            $this->db->execute();
            redirect("");
        }else{
            //Print message
            redirect("");
        }
    }
  }