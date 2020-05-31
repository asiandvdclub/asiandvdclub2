<?php


class takeContent
{
    private $db;
    public function takeContent(){
        $this->db = new Database();
    }
    public function registerContent($type, $content_id){
        switch ($type){
            case "movie":
                $this->db->querry("SELECT id FROM imdb WHERE imdb_id = :imdbId");
                $this->db->bind(":imdbId", $content_id);
                $check = $this->db->getRow();
                if(empty($check))
                    $this->registerMovie($content_id);
                break;
            case "anime":
                $this->db->querry("SELECT id FROM anidb WHERE anidb_id = :anidbID");
                $this->db->bind(":anidbID", $content_id);
                $check = $this->db->getRow();
                if(empty($check))
                    $this->registerAnime($content_id);
                break;
        }
    }
    private function registerMovie($imdb_url){
        $command = "python3 " . APP_ROUTE . "/libraries/imdb_to_json.py " . $imdb_url;
        $data = exec($command);
        $data = json_decode($data, true);
        $this->db->querry("INSERT INTO `imdb` (`title`, `genre`, `synopsis`, `year`, `directors`, `imdb_id`, `plot`, `url`)
                                                        VALUES (:title, :genre, :synopsis, :year, :directors, :imdb_id, :plot, :url)");
        $this->db->bind(":title", $data['name']);
        $this->db->bind(":genre", strval(json_encode(array("genre" => $data['genre']))));
        $this->db->bind(":synopsis", $data['synopsis'][0]);
        $this->db->bind(":plot", $data['plot']);
        $this->db->bind(":year", $data['year']);
        $this->db->bind(":directors", strval(json_encode(array("directors" => $data['directors']))));
        $this->db->bind(":url", $data['url']);
        $this->db->bind(":imdb_id", $imdb_url); // link this to `torrents`

        $this->db->execute();
    }
    //TODO Change insert later
    private function registerAnime($anidb_url){
        $command = "python3 " . APP_ROUTE . "/libraries/anidb_to_json.py " . $anidb_url;
        $data = exec($command);
        $data = json_decode($data, true);

        $this->db->querry("INSERT INTO `anidb` (`title`, `title_jp`, `synopsis`, `year`, `directors`, `anidb_id`, `url`, `type`)
                                                        VALUES (:title, :title_jp, :synopsis, :year, :directors, :anidb_id, :url, :type)");
        $this->db->bind(":title", $data['title']);
        $this->db->bind(":title_jp", $data['title_jp']);
        // $this->db->bind(":genre", strval(json_encode(array("genre" => $data['genre'])))); // TODO need to get the genre of anime
        $this->db->bind(":synopsis", $data['synopsis']);
        $this->db->bind(":year", $data['year']);
        $this->db->bind(":directors", strval(json_encode(array("directors" => $data['directors']))));
        $this->db->bind(":url", $data['url']);
        $this->db->bind(":anidb_id", $anidb_url); // link this to `torrents`
        $this->db->bind(":type", $data['type']);
        $this->db->execute();

    }
}