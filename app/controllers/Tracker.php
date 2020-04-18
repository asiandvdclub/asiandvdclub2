<?php
class Tracker extends Controller
{
    private $db;
    private $cacheManager;
    private $languageMod;
    private $userClass;
    private $bencode;
    private $takeupload;
    private $passkey;

    public function Tracker(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->languageMod = $this->model('language');
        $this->bencode = $this->model('bencode');
        $this->takeupload = $this->model('takeupload');

        $this->cacheManager->setUserStats();
        $this->userClass = $this->cacheManager->getUserStats()['idClass'];
        $this->passkey = $this->cacheManager->getUserStats()['passkey'];
    }
    public function torrents(){
        require_once $this->languageMod->getLangPath(__FUNCTION__);
        $this->languageMod->setLanguage(__FUNCTION__);

        $showList = "";

        $this->db->querry("SELECT tor.id, tor.name, tor.seeders, tor.leechers, usr.username, tor.size, tor.added FROM torrents as tor JOIN users as usr WHERE tor.owner = usr.id");
        $tList = $this->db->getAll();
        foreach ($tList as $row){
            $showList .= "<tr>";
            $showList .=   "<td>DVD</td>";
            $showList .=   "<td><a href=". URL_ROOT . "/torrent/". $row['id'] .">" . $row['name'] ."</a></td>";
            $showList .=   "<td></td>";
            $showList .=   "<td>" . convTime($row['added']) ."</td>";
            $showList .=   "<td>" . formatBytes($row['size']) ."</td>";
            $showList .=   "<td>" . $row['seeders'] ."</td>";
            $showList .=   "<td>" . $row['leechers'] ."</td>";
            $showList .=   "<td></td>";
            $showList .=   "<td>" . $row['username'] ."</td>";
            $showList .= "</tr>";
        }

        $this->view('tracker/torrents',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
                "torrents_lang" => $lang_torrents,
                "showList" => $showList,
            ]);
    }
    public function torrent($idTorrent){
        require_once $this->languageMod->getLangPath(__FUNCTION__);
        $this->languageMod->setLanguage(__FUNCTION__);

        $showList = "";

        $this->db->querry("SELECT t.info_hash, t.numfiles, t.imdb_id, t.name, t.small_desc, t.seeders, t.leechers, t.size, t.added, t.specs, i.title, i.genre, i.year, i.synopsis, i.plot, i.url FROM torrents as t JOIN imdb as i WHERE t.id = :tId && i.imdb_id = t.imdb_id");
        $this->db->bind(':tId', $idTorrent);
        $tData = $this->db->getRow();
        $tInfo = $tData['specs'];
        $tInfo = json_decode($tInfo, true);
        $imdb_info['title'] = $tData['title'];
        $imdb_info['genre'] = json_decode($tData['genre'], true);
        $imdb_info['year'] = $tData['year'];
        $imdb_info['plot'] = $tData['plot'];
        if(empty($tData))
            redirect("");

        $this->view('tracker/torrent',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
                "torrentData" => $tData,
                "torrentInfo" => $tInfo,
                "imdb_info" => $imdb_info,
                "torrent_lang" => $lang_torrent,
                "tID" => $idTorrent
            ]);
    }
    public function upload(){
         /*
          *  TODO:
          * - check for errors in form
          * - check if folder name match the patterns (regex)
          */
        require_once $this->languageMod->getLangPath(__FUNCTION__);
        $this->languageMod->setLanguage(__FUNCTION__);
        $error = array(
            "file" => "",
            "imdb" => "",
            "anidb" => "",
            "torrent_name" => ""
        );
        $imdb = false;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['sitelanguage'])) {
            $this->db->querry("SELECT `passkey` FROM `users` WHERE `id` = :uid");
            $this->db->bind(":uid", base64_decode($_COOKIE['c_secure_uid']));
            $passkey = $this->db->getRow()['passkey'];

            if(empty($_POST['imdb_url']))
                $error['imdb'] = "Empty field";
            if(empty($_POST['url_anidb']) && empty($_POST['imdb_url']))
                $error['anidb'] = "Empty field";
            if(empty($_FILES['torrent_file']['name']))
                $error['file'] = "Empty field";

            if (TORRENT_HEADER != $_FILES['torrent_file']['type']) {
                $error['file'] = "Wrong torrent file format!";
                $this->uploadView($error);
            }
            $imdb_url = $_POST['imdb_url'];

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
                $error['imdb'] = "Wrong imdb url";
            }

            foreach ($error as $value){
                if(!empty($value)){
                    $this->uploadView($error);
                    break;
                }
            }
            //this needs to be moved
            switch ($_POST['type']){
                case "movie":
                case "anime":
                    $specs = array(
                        "type" => $_POST['type'],
                        "format" => $_POST['optradio'],
                        "codec" => $_POST['codec'],
                        "standard" => $_POST['standard'],
                        "processing" => $_POST['processing']
                    );
                    break;
                case "music":
                    $specs = array(
                        //"format" => $_POST['optradio'],
                        "type" => $_POST['type'],
                        "codec" => $_POST['codec'],
                        "codec_audio" => $_POST['codec_audio'],
                        "processing" => $_POST['processing'],
                    );
                    break;
                default:
                    $specs = "";
                    break;
            }
            if($_POST['type'] = "movie")
                $imdb = true;
            else
                $imdb = false;
            //Decoding torrent data
            $f = $this->bencode->bdec_file($_FILES['torrent_file']['tmp_name'], filesize($_FILES['torrent_file']['tmp_name']));

            $size = 0;
            if(is_null($f['info']['files'])){
                $size += $f['info']['length'];
            }else{
                foreach ($f['info']['files'] as $value) {
                    $size += $value['length'];
                }
            }

            $torrent_data['name'] = $_POST['torrent_name'];
            $torrent_data['size'] = $size; // size in bits
            $torrent_data['info_hash'] = sha1($this->bencode->benc($f['info']));
            $torrent_data['numfiles'] = is_null($f['info']['files']) ? 1 : count($f['info']['files']);
            $torrent_data['optradio'] = $_POST['optradio'];
            $torrent_data['specs'] = json_encode($specs); // jsond encode
            $torrent_data['imdb_id'] = $imdb_url;
            if (URL_ROOT . "/announce" != $f['announce']){
                $error['file'] = "Invalid announce url";
                $this->uploadView($error);
            }
            $targetFile = DIR_TORRENTS . $torrent_data['info_hash'] . ".torrent";

            //Encoding torrent data
            $f = $this->bencode->benc($f);
            $keys = array_keys($error);

            $this->db->querry("SELECT id FROM imdb WHERE imdb_id = :imdbID");
            $this->db->bind(":imdbID", $imdb_url);
            $check = $this->db->getRow();

            if(empty($check))
                $this->registerMovie($imdb_url);

            if (empty($error[$keys[0]]) && empty($error[$keys[1]]) && empty($error[$keys[2]]) && empty($error[$keys[3]]) && empty($error[$keys[4]])) {
                $torrent_data = array_merge($torrent_data, $_POST);
                if (empty($torrent_data['name'])) {
                    $torrent_data['name'] = basename($_FILES['torrent_file']['name']);
                    $torrent_data['name'] = str_replace(".torrent", "", $torrent_data['name']);
                }

                if (is_uploaded_file($_FILES['torrent_file']['tmp_name']) && $this->takeupload->addTorrent($torrent_data)) {
                    write_to_file($f, $targetFile);
                    redirect("");
                } else{
                    die("torrent exits");
                }
            }else{
                $this->uploadView($error);
            }
        }
        else {
            $this->uploadView($error);
        }
    }
    private function uploadView($error){
        $this->view('tracker/upload',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "lang_upload" => $lang_upload,
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                "error" => $error,
            ]);
    }
    private function registerMovie($imdb_url){
        $command = "python " . APP_ROUTE . "/libraries/imdb_to_json.py " . $imdb_url;
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

    public function download($torrentID){
        ob_clean();
        $this->db->querry("SELECT `name`, `info_hash` FROM `torrents` WHERE id = :tId");
        $this->db->bind(":tId", $torrentID);
        $torrent_data = $this->db->getRow();
        $path = DIR_TORRENTS . $torrent_data['info_hash'] . ".torrent";
        $bdec = $this->bencode->bdec_file($path, filesize($path));

        unset($bdec['announce-list']);
        if(!array_key_exists($bdec['info']['private'], $bdec) || $bdec['info']['private'] != 1){
            $bdec['private'] = 1;
        }
        //TODO encrypt passkey
        $bdec['announce'] = $bdec['announce'] . "/" . $this->passkey;
        $bdec = $this->bencode->benc($bdec);

       // $bdec = preg_replace("/\r|\n/", "", $clean_format);

        header('Content-Description: File Transfer');
        header("Pragma: public");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Type: ' . TORRENT_HEADER . "charset=UTF-8");
        header("Content-Disposition: attachment; filename=\"" . $torrent_data['name'] . ".torrent");

       // header('Content-Length: ' . filesize($bdec));
        echo trim($bdec);
        exit;
    }
}