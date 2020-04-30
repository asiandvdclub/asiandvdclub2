<?php

/*
 * Bonus points and achievements announcer
 */

class achievements
{
    private $db;
    private $seederStatus;
    public function achievements(){
        $this->db = new Database();
    }
    public function setStatus($uid){
        $this->db->querry("SELECT COUNT(id) FROM peers WHERE userid = :uid");
        $this->db->bind(":uid", $uid);
        $this->seederStatus = $this->db->getRow();
    }
    //Announce related
    public function doubleUpload($upload){
        return $upload*2;
    }
    public function doubleDownload($download){
        return $download*2;
    }
    public function halfDownload($download){
        return $download/2;
    }
}