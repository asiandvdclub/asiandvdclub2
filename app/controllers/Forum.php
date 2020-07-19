<?php

class Forum extends Controller
{
    private $db;
    private $cacheManager;
    private $languageMod;
    private $userClass;
    private $forum_data;

    public function Forum(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');
        $this->forum_data = $this->model('forum_data');

        $this->cacheManager->setUserStats();
        $this->userClass = $this->cacheManager->getUserStats()['idClass'];
    }
    public function forums(){

        if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sitelanguage'])) {
            $expires = time() + 0x7fffffff;
            setcookie("c_site_language", base64_encode($_POST['sitelanguage']), $expires, "/");
            redirect(__FUNCTION__);
        }else {
            $this->view('forum/forums',
                [
                    "currentPage" => "/" . __FUNCTION__,
                    "userStats" => $this->cacheManager->getUserStats(),
                    "getLangDropdown" => $this->languageMod->getLangDropdown(),
                    "getLangPath" => $this->languageMod->getLangPath(__FUNCTION__),
                    "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                    "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
                    //"category" => $this->forum_data->display_forums(),
                    "display_forums" => $this->displayForums()
                ]);
        }
    }
    public function in_forum(){

    }
    public function post(){

    }
    private function displayForums(){

        //TODO ADD to querryes on for category and one for forums this will requeired to foreach to display the resust need to be set in memchacheed. that all. 
        $this->db->querry("SELECT cat.id, f.title, f.description, cat.name FROM forums as f join forumCategory as cat where f.idCategory = cat.id");
        $tb = $this->db->getAll();
        $html_out = "";

        for($i = 0; $i < count($tb); $i++){
            $html_out .= "<table class=\"torrenttable_helper\"  border=\"0\" cellspacing=\"0\" cellpadding=\"10\"><tbody style=\"border: none;\"><tr><th colspan=\"4\" style=\"text-align: left\">"
                . $tb[i]['name'] . "</th></tr><tr style=\" background: #D7D7D7;\">
            <td style=\"text-align: left;border-right: none; width: 1000px; overflow: auto\">Forum</td>
            <td style=\"border: none; text-align: center;\">Topics</td>
            <td style=\"border: none; text-align: center;\">Posts</td>
            <td style=\"border-left: none; text-align: center;\">Last Post</td></tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tbody>
    </table>";
        }
        return $html_out;
    }
}