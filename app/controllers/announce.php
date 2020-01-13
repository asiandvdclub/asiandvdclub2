<?php


class announce extends Controller
{

    private $db;
    private $cacheManager;
    private $bencoude;
    public function announce(){

        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->bencoude = $this->model('bencode');
    }
    public function announceSession(){
        header('Content-type: Text/Plain');
        // Here goes all the benconde packet it should return an echo back to torrent client and update database
    }
}