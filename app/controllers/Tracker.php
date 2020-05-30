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

        $this->db->querry("SELECT t.anonymous, t.info_hash, t.numfiles, t.content_id, t.name, t.small_desc, t.seeders, t.leechers, t.size, t.added, t.specs, usr.username FROM torrents as t JOIN users as usr WHERE t.id = :tid AND t.owner = usr.id");
        $this->db->bind(":tid", $idTorrent);
        $tdata = $this->db->getRow();
        $tdata['specs'] = json_decode($tdata['specs'], true);
        $tdata['torrent_id'] = $idTorrent;
        $type = $tdata['specs']['type'];
        $contentData = array();
        if($tdata['anonymous'] == "yes")
            $tdata['username'] = "Anonymous";

        switch ($type){
            case "movie":
                $this->db->querry("SELECT * FROM imdb WHERE id = :content_id");
                $this->db->bind(':content_id', $tdata['content_id']);
                $contentData = $this->db->getRow();
                $contentData['genre'] = json_decode($contentData['genre'], true);
                if(empty($contentData['synopsis']))
                    $contentData['synopsis'] = $contentData['plot'];
                $contentData['directors'] = json_decode($contentData['directors'], true);
                break;
            case "anime":
                $this->db->querry("SELECT * FROM anidb WHERE anidb_id = :content_id");
                $this->db->bind(":content_id", $tdata['content_id']);
                $contentData = $this->db->getRow();
                $contentData['directors'] = json_decode($contentData['directors'], true);
            break;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['sitelanguage'])) {
            //die($this->cacheManager->getUserStats()['id'] . "------" . $idTorrent . "========" . $_POST['comment_desc']);
            $this->db->querry("INSERT INTO `torrentComment` (`userid`, `comment`, `added`, `tid`) VALUES (:uid, :comment, NOW(), :tid)");
            $this->db->bind(":uid", $this->cacheManager->getUserStats()['id']);
            $this->db->bind(":tid", $idTorrent);
            $this->db->bind(":comment", $_POST['comment_desc']);
            $this->db->execute();

            $this->view('tracker/torrent',
                [
                    "currentPage" => "/" . __FUNCTION__,
                    "userStats" => $this->cacheManager->getUserStats(),
                    "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                    "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                    "torrentData" => $tdata,
                    "content_data" => $contentData,
                    "torrent_lang" => $lang_torrent,
                    "tID" => $idTorrent
                ]);
        }else{
            $this->view('tracker/torrent',
                [
                    "currentPage" => "/" . __FUNCTION__,
                    "userStats" => $this->cacheManager->getUserStats(),
                    "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                    "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                    "torrentData" => $tdata,
                    "content_data" => $contentData,
                    "torrent_lang" => $lang_torrent,
                    "tID" => $idTorrent
                ]);
        }
    }
    public function upload(){

         /*
          *  TODO:
          * - check for errors in form
          * - check if folder name match the patterns (regex)
          */
        require_once $this->languageMod->getLangPath(__FUNCTION__);
        $this->languageMod->setLanguage(__FUNCTION__);

        $error = array();
        $imdb = false;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['sitelanguage'])) {
            $check =  $this->takeupload->checkForm($_POST, $_FILES['torrent_file']);
            $error = $check['error'];

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
            $torrent_data['content_id'] = $check['content_id'];
            if (URL_ROOT . "/announce" != $f['announce']){
                $error['file'] = "Invalid announce url";
                $this->uploadView($error);
            }
            $targetFile = DIR_TORRENTS . $torrent_data['info_hash'] . ".torrent";

            //Encoding torrent data
            $f = $this->bencode->benc($f);
            $keys = array_keys($error);

            if (empty($error[$keys[0]]) && empty($error[$keys[1]]) && empty($error[$keys[2]]) && empty($error[$keys[3]]) && empty($error[$keys[4]])) {
                $this->takeupload->registerContent($specs['type'], $check['content_id']);

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
    private function getTorrentComments($tid){
        $html_out = "";

        $this->db->querry("SELECT tc.comment, tc.added, (CASE WHEN  t.anonymous = \"yes\" AND u.id = t.owner THEN \"Anonymous\" ELSE u.username END) as username FROM torrentComment as tc 
                                INNER JOIN torrents as t ON tc.tid = t.id AND t.id = :t_id
                                LEFT JOIN users as u ON u.id = tc.userid ");
        $this->db->bind(':t_id', $tid);
        $data = $this->db->getAll();
        return $data;
    }
}