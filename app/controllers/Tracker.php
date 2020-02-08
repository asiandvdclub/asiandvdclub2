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
            $showList .=   "<th>DVD</th>";
            $showList .=   "<th><a href=". URL_ROOT . "/torrent/". $row['id'] .">" . $row['name'] ."</a></th>";
            $showList .=   "<th></th>";
            $showList .=   "<th>" . $row['added'] ."</th>";
            $showList .=   "<th>" . formatBytes($row['size']) ."</th>";
            $showList .=   "<th>" . $row['seeders'] ."</th>";
            $showList .=   "<th>" . $row['leechers'] ."</th>";
            $showList .=   "<th></th>";
            $showList .=   "<th>" . $row['username'] ."</th>";
            $showList .= "</tr>";
        }

        $this->view('tracker/torrents',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
                "showList" => $showList,
            ]);
    }
    public function torrent($idTorrent){
        require_once $this->languageMod->getLangPath(__FUNCTION__);
        $this->languageMod->setLanguage(__FUNCTION__);

        $showList = "";

        $this->db->querry("SELECT name, small_desc, seeders, leechers, size, added FROM torrents WHERE id = :tId");
        $this->db->bind(':tId', $idTorrent);
        $tData = $this->db->getRow();
        if(empty($tData))
            redirect("");


        $this->view('tracker/torrent',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar"=> $this->cacheManager->getSiteManager($this->userClass),
                "torrentData" => $tData,
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

        $fileErr = "";
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['sitelanguage'])) {
            $this->db->querry("SELECT `passkey` FROM `users` WHERE `id` = :uid");
            $this->db->bind(":uid", base64_decode($_COOKIE['c_secure_uid']));
            $passkey = $this->db->getRow()['passkey'];

            if (TORRENT_HEADER != $_FILES['torrent_file']['type']) {
                $fileErr = "Wrong torrent file format!";
                $this->uploadView($fileErr);
            }
            //Decoding torrent data
            $f = $this->bencode->bdec_file($_FILES['torrent_file']['tmp_name'], filesize($_FILES['torrent_file']['tmp_name']));

            $size = 0;
            foreach ($f['info']['files'] as $value) {
                $size += $value['length'];
            }
            $torrent_data['size'] = $size; // size in bits
            $torrent_data['info_hash'] = sha1($this->bencode->benc($f['info']));
            $torrent_data['numfiles'] = count($f['info']['files']);
            if (URL_ROOT . "/announce" != $f['announce']){
                $fileErr = "Invalid announce url";
                $this->uploadView($fileErr);
            }
            $targetFile = DIR_TORRENTS . $torrent_data['info_hash'] . ".torrent";
            //Adding passkey and private
            //$f = $this->takeupload->makeTorrent($f, $passkey);

            //Encoding torrent data
            $f = $this->bencode->benc($f);

            // die(mksecret(20));
            if (empty($fileErr)) {
                $torrent_data = array_merge($torrent_data, $_POST);
                if (empty($torrent_data['name']))
                    $torrent_data['name'] = basename($_FILES['torrent_file']['name']);
                if (is_uploaded_file($_FILES['torrent_file']['tmp_name']) && $this->takeupload->addTorrent($torrent_data)) {
                    write_to_file($f, $targetFile);
                    redirect("");
                } else{
                    die("torrent exits");
                }
            }else{
                $this->uploadView("");
            }
        }
        else {
            $this->view('tracker/upload',
                [
                    "currentPage" => "/" . __FUNCTION__,
                    "userStats" => $this->cacheManager->getUserStats(),
                    "lang_upload" => $lang_upload,
                    "getLangDropdown" => $this->languageMod->getLangDropdown(),
                    "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                    "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                    "fileErr" => $fileErr,
                ]);
        }
    }
    private function uploadView($fileErr){
        $this->view('tracker/upload',
            [
                "currentPage" => "/" . __FUNCTION__,
                "userStats" => $this->cacheManager->getUserStats(),
                "lang_upload" => $lang_upload,
                "getLangDropdown" => $this->languageMod->getLangDropdown(),
                "getSiteLangHeader" => $this->languageMod->getSiteLangHeader(),
                "getSiteManagerBar" => $this->cacheManager->getSiteManager($this->userClass),
                "fileErr" => $fileErr,
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