<?php
/**
 * Date: 5/14/2019
 * Time: 10:04 PM
 */

class index extends Controller
{
    private $db;
    private $auth;
    public function index(){
        $this->db = new Database();
        $this->auth = new Authority();
    }
    public function news($lang, $userClass){
        $news_format =  '';
        $button = "<button onclick=\"location.href='" . URL_ROOT . "/create_news'" . "\" type=\"button\" style=\"margin-left:10px;\" class=\"btn btn-primary mg\">".$lang['text_new']."</button>";

        //get news add row pattern
        $this->db->querry("SELECT idNews, title, text, added FROM news GROUP BY idNews DESC");
        $row = $this->db->getAll();

        if($this->auth->getAuthority("create_news")){
            $news_format .= $button;
        }
        if(!empty($row)) {
           $trig = true;
           foreach ($row as $row_news){
                $news_format .= "<p><button class=\"btn btn-info text-center\"  type=\"button\" data-toggle=\"collapse\" data-target=\"#buttoncollapse" . $row_news['idNews'] . "\" aria-expanded=\"false\" aria-controls=\"buttoncollapse\">";
                $news_format .= "<a class=\"text_news_button\">". $row_news['added'] . " - " .  $row_news['title'] . "</a></button>".($this->auth->getAuthority("delete_news") ? $this->deleteButton($row_news['idNews'], $lang) : "")."</p>";
                $news_format .= "<div class=\"collapse" . ($trig ? " show\"" : "\"") . "id=\"buttoncollapse" . $row_news['idNews'] . "\"><div class=\"card card-block\" style=\"margin-bottom: 10px;\">" . $row_news['text'] . "</div></div>";
                $trig = false;
            }
            return $news_format;
        }else{
            $news_format .= "<h3>No recent news</h3>";
            return $news_format;
        }
    }
    private function deleteButton($newsId, $lang){
        //return "<button id='deleteButton' onclick='deleteNews(". $newsId .")' type=\"button\" style=\"margin-left:10px;\" class=\"btn btn-info text-center\">Delete</button>";
        return "<button id='deleteButton' onclick=\"location.href='". URL_ROOT . "/delete_news/" . $newsId ."'\" type=\"button\" style=\"margin-left:10px;\" class=\"btn btn-info text-center\"> ". $lang['text_delete']. " </button>";
    }
    public function polls(){

    }
}