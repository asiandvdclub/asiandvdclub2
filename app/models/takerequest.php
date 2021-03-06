<?php


class takerequest
{
    private $db;
    public function takerequest(){
        $this->db = new Database();
    }
    public function makerequest($data){
        $this->db->querry("INSERT INTO `requests` (date, userid, votes, filled, title, description, content_id, type, reseed, tid) 
                                               VALUES (NOW(), :uid, 0, \"no\", :title, :desc, :content_id, :type, :reseed, :tid)");
        $this->db->bind(":uid", $data['uid']);
        $this->db->bind(":title", $data['req_title']);
        $this->db->bind(":desc", $data['big_desc']);
        $this->db->bind(":content_id", $data['content_id']);
        $this->db->bind(":type", $data['type']);
        if(isset($data['reseed']) && $data['reseed'] == "yes") {
            $this->db->bind(":reseed", "yes");
            $this->db->bind(":tid", $data['tid']);
        }else{
            $this->db->bind(":reseed", "no");
            $this->db->bind(":tid", '0');
        }
      //  dbg_log_break($data);
        $this->db->execute();
    }
    public function getRequests(){
        $html_out = "";
        $this->db->querry("SELECT r.id, r.date, r.filled, r.title, u.username, (SELECT COUNT(*) FROM requests_votes as rv WHERE r.id = rv.requests_id) as votes, (SELECT username FROM users WHERE r.filled_by = id) as filled_by FROM requests as r JOIN users as u WHERE u.id = r.userid ORDER BY r.id DESC LIMIT 50");
        $data = $this->db->getAll();
        $this->db->querry("SELECT username FROM users WHERE id = :uid");
        $this->db->bind(":uid", $data['filled_by']);

        foreach ($data as $value){
            $html_out .= "<tr><td>" . $value['id'] . "</td><td><a href='" . URL_ROOT . "/request/" . $value['id'] . "'>" . $value['title'] . "</a></td><td>" . convTime($value['date']) .
                         "</td><td>" . $value['username'] . "</td><td>" . $value['filled'] . "</td><td>" . $value['filled_by'] . "</td><td>" . $value['votes'] . "</td></tr>";
        }
        return $html_out;
    }
    public function getRequestData($id){
        $this->db->querry("SELECT r.id, r.content_id, r.type, r.date, r.filled, r.title, r.description, u.username, (SELECT username FROM users WHERE r.filled_by = id) as filled_by FROM requests as r JOIN users as u WHERE r.id = :rid");
        $this->db->bind(":rid", $id);
        $data = $this->db->getRow();
        if($data['type'] == "movie") {
            $data['content_url'] = URL_IMDB . $data['content_id'];
            $data['web_name'] = "IMDb Link";
        }
        else {
            $data['content_url'] = URL_ANIDB . $data['content_id'];
            $data['web_name'] = "AniDB";
        }
        return $data;
    }
    public function checkForm($data){
        $content_data = array(
            "content_id" => "",
            "error" => ""
        );
        switch ($data['type']){
            case "movie":
                $imdb_url = $data['imdb_url'];
                if(empty($imdb_url)){
                    $content_data['error'] = "Empty field";
                }
                $pos = strpos($imdb_url, "/tt");
                $imdb_url = substr($imdb_url, $pos + 3,  strlen($imdb_url));
                $chars = str_split($imdb_url);
                $imdb_url = "";
                foreach ($chars as $value){
                    if(is_numeric($value))
                        $imdb_url .= $value;
                    else
                        break;
                }
                if(!is_numeric($imdb_url)) {
                    $content_data['error'] = "Wrong imdb url";
                }else{
                    $content_data['content_id'] = $imdb_url;
                }
                break;
            case "anime":
                $anidb_url = $data['anidb_url'];
                $pos = strpos($anidb_url, "e/");
                $anidb_url = substr($anidb_url, $pos + 2,  strlen($anidb_url));
                if(empty($_POST['url_anidb']) && empty($_POST['url_anidb']))
                    $content_data['error'] = "Empty field";
                $content_data['content_id'] = $anidb_url;
                break;
            case "music":
                break;
        }
        return $content_data;
    }
    public function checkVote($rid, $uid){
        $this->db->querry("SELECT * FROM requests_votes WHERE uid = :uid AND requests_id = :rid");
        $this->db->bind(":uid", $uid);
        $this->db->bind(":rid", $rid);
        return $this->db->getRow();
    }
}