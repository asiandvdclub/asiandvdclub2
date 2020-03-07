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
        $this->db->querry("INSERT INTO `torrents`(`info_hash`, `name`, `desc`, `small_desc`, `size`, `added`, `numfiles`, `views`, `hits`, `times_completed`, `leechers`, `seeders`, `last_action`, `visible`, `banned`, `owner`, `anonymous`, `last_reseed`, `tCategory`, `specs`,`imdb_id`) 
                                  VALUES (:info_hash, :name, :desc, :small_desc, :size, NOW(), :numfiles, 0, 0, 0, 0, 0, NOW(), 'yes', 'no', :owner, :anonymous, NOW(), 1, :specs, :imdb_id)");
        $this->db->bind(':specs', $torrent_data['specs']);
        $this->db->bind(':imdb_id', $torrent_data['imdb_id']);
        $this->db->bind(':info_hash', $torrent_data['info_hash']);
        $this->db->bind(':name', $torrent_data['name']);
        $this->db->bind(':desc', $torrent_data['big_desc']);
        $this->db->bind(':small_desc', $torrent_data['small_desc']);
        $this->db->bind(':size', $torrent_data['size']);
       // $this->db->bind(":optradio", $torrent_data['optradio']); for DVD BDMW
        $this->db->bind(':numfiles', $torrent_data['numfiles']);
        $this->db->bind(':owner', base64_decode($_COOKIE['c_secure_uid']));
        if(isset($torrent_data['hide_up']))
            $this->db->bind(':anonymous', 'yes');
        else
            $this->db->bind(':anonymous', 'no');

        if($this->db->execute())
            return true;
        else
            false;
    }
}