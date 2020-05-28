<?php


class takerequest
{
    private $db;
    public function takerequest(){
        $this->db = new Database();
    }
    public function makerequest(){
        $this->db->querry("INSERT INTO `requests` (date, userid, votes, filled, title, description, content_id) 
                                               VALUES (NOW(), :uid, 0, `no`, :title, :desc, :content_id)");
        $this->db->bind(":uid", "");
        $this->db->bind(":title", "");
        $this->db->bind(":desc", "");
        $this->db->bind(":content_id", "");
        $this->db->execute();
    }
}