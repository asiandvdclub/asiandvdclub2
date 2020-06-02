<?php


class takeprofile
{
    private $db;
    private $user_cache;

    public function takeprofile($user_cache){
        $this->db = new Database();
        $this->user_cache = $user_cache;
    }
    public function getProfile(){
        $this->db->querry("");
    }
}