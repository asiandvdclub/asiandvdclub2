<?php

class takeupload
{
    private $db;
    public function takeupload(){
        $this->db = new Database();
    }
    public function is_uploaded($target){
        if ($_FILES['file']["error"] == UPLOAD_ERR_OK ) {
            if (!move_uploaded_file( $_FILES['torrent_file']["tmp_name"], $target)) {
                return false;
            }
        }
        else {
            return false;
        }
        return true;
    }
    public function addTorrent($torrent_data){
        $this->db->querry("INSERT INTO `torrents`(`info_hash`, `name`, `desc`, `small_desc`, `size`, `added`, `numfiles`, `views`, `hits`, `times_completed`, `leechers`, `seeders`, `last_action`, `visible`, `banned`, `owner`, `anonymous`, `last_reseed`, `tCategory`, `specs`,`content_id`, `media_info`) 
                                  VALUES (:info_hash, :name, :desc, :small_desc, :size, NOW(), :numfiles, 0, 0, 0, 0, 0, NOW(), 'yes', 'no', :owner, :anonymous, NOW(), 1, :specs, :content_id, :media_info)");
        $this->db->bind(':specs', $torrent_data['specs']);
        $this->db->bind(':content_id', $torrent_data['content_id']);
        $this->db->bind(':info_hash', $torrent_data['info_hash']);
        $this->db->bind(':name', $torrent_data['name']);
        $this->db->bind(':desc', $torrent_data['big_desc']);
        $this->db->bind(':small_desc', $torrent_data['small_desc']);
        $this->db->bind(':size', $torrent_data['size']);
       // $this->db->bind(":optradio", $torrent_data['optradio']); for DVD BDMW
        $this->db->bind(':numfiles', $torrent_data['numfiles']);
        $this->db->bind(':owner', base64_decode($_COOKIE['c_secure_uid']));
        $this->db->bind(':media_info', utf8_encode($torrent_data['media_info']));
        if(isset($torrent_data['hide_up']))
            $this->db->bind(':anonymous', 'yes');
        else
            $this->db->bind(':anonymous', 'no');


        if($this->db->execute()) {
            return true;
        }
        else{
            return false;
        }
    }
    public function checkForm($data, $file){
        $error = array(
            "imdb" => "",
            "anidb" => "",
            "file" => "",
        );
        $check = array(
            "error" => $error,
            "content_id" => ""
        );
        switch ($data['type']){
            case "movie":
                $imdb_url = $data['imdb_url'];
                if(empty($imdb_url)){
                    $error['imdb'] = "Empty field";
                }
                $pos = strpos($imdb_url, "/tt");
                $imdb_url = substr($imdb_url, $pos + 3, strlen($imdb_url));
                $chars = str_split($imdb_url);
                $imdb_url = "";
                foreach ($chars as $value) {
                    if (is_numeric($value))
                        $imdb_url .= $value;
                    else
                        break;
                }

                if(!is_numeric($imdb_url) && !empty($imdb_url)) {
                    $error['imdb'] = "Wrong imdb url";
                }else{
                    $check['content_id'] = $imdb_url;
                }
                break;
            case "anime":
                $anidb_url = $data['url_anidb'];
                $pos = strpos($anidb_url, "e/");
                $anidb_url = substr($anidb_url, $pos + 2,  strlen($anidb_url));
                if(empty($_POST['url_anidb']) && empty($_POST['url_anidb']))
                    $error['anidb'] = "Empty field";
                $check['content_id'] = $anidb_url;
                break;
            case "music":
                break;
        }
        if(empty($file['media_info']['name']))
            $error['file_mi'] = "Empty field";
        elseif (TXT_HEADER != $file['media_info']['type']) {
            $error['file_mi'] = "Wrong text file format!";
        }

        if(empty($file['torrent_file']['name']))
            $error['file_t'] = "Empty field";
        elseif (TORRENT_HEADER != $file['torrent_file']['type']) {
            $error['file_t'] = "Wrong torrent file format!";
        }
        $check['error'] = $error;
        return $check;
    }

}