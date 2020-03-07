<?php


class forum_data
{
    private $db;
    private $forumStatus = [];

    public function forum_data(){
        $this->db = new Database();
        $this->setForumStatus();
    }
    public function display_forums(){
        $this->db->querry("SELECT `name`, `title` FROM `category` JOIN `forums` WHERE category.idCategory = forums.category_idCategory");
        $this->db->execute();
        $cat = $this->db->getAll();
        $divCat = "";

        $skip = $cat[0]['name'];
        $flag = true;
        $array = [];
        foreach ($cat as $item){
            if($skip != $item['name']){
                $array += array($item['name'] => array($item['title']));
                $skip = $item['name'];
            }
            elseif($skip == $item['name'] && $flag){
                $array = array($item['name'] => array($item['title']));
                $flag = false;
            }else{
                array_push($array[$skip], $item['title']);
            }
        }
        $divCat .= "<div id=\"news\" class=\"container bg-dark\">";
        foreach ($array as $item => $value){
            $divCat .= "<a class=\"badge bg-light font-big mg\">" . $item . "</a>";

            foreach ($value as $forums){
                $divCat .= "<div id=\"news\" class=\"container bg-dark\"><a class=\"badge bg-light font-big mg\">". $forums . "</a></div><br>";
            }
        }
        $divCat .= "</div>";
        return $divCat;
    }
    //TODO: This need to be in a cacheManager, let this be for now.
    private function setForumStatus(){
        $this->db->querry("SELECT COUNT(*) as total FROM forums"); $this->db->execute();
        $temp = $this->db->getAll();
        $this->forumStatus = array("forums" => $temp[0]['total']);
        $this->db->querry("SELECT COUNT(*) as total FROM posts");  $this->db->execute();
        $temp = $this->db->getAll();
        $this->forumStatus += array("posts" => $temp[0]['total']);
        $this->db->querry("SELECT COUNT(*) as total FROM users");  $this->db->execute();
        $temp = $this->db->getAll();
        $this->forumStatus += array("users" => $temp[0]['total']);
    }
    public function getForumStatus(){
        return $this->forumStatus;
    }
    public function display_forums_manager(){
        $this->db->querry("SELECT `idForum`, `name`, `title` FROM `category` JOIN `forums` WHERE category.idCategory = forums.category_idCategory");
        $this->db->execute();
        $cat = $this->db->getAll();
        $divCat = "";
        if(empty($cat))
            return "<div id=\"news\" class=\"container\"><h3>Create a forum text.</h3>" . $this->addForumButton() . "</div>";
        $skip = $cat[0]['name'];
        $flag = true;
        $array = [];
        foreach ($cat as $item){
            if($skip != $item['name']){
                $array += array($item['name'] => array($item['title'] => $item['idForum']));
                $skip = $item['name'];
            }
            elseif($skip == $item['name'] && $flag){
                $array = array($item['name'] => array($item['title'] => $item['idForum']));
                $flag = false;
            }else{
                $array[$skip] += array($item['title'] => $item['idForum']);
            }
        }

        $divCat .= "<div id=\"news\" class=\"container\">";
        foreach ($array as $item => $value){
            $divCat .= "<a class=\"font-weight-normal\">" . $item . "</a>";

            foreach ($value as $forums => $forumID){
                $divCat .= "<div  class=\"container\"><a class=\"font-weight-normal\">". $forums . "</a>";
                $divCat .= $this->deleteForumButton($forumID) . "</div>";
            }
        }
        $divCat .= $this->addForumButton();
        $divCat .= "</div>";
        return $divCat;
    }
    private function deleteForumButton($forumId){
        return "<button id='deleteButton' onclick=\"location.href='". URL_ROOT . "/forum_delete/" . $forumId ."'\" type=\"button\" style=\"margin-left:10px;\" class=\"btn btn-info text-center\">Delete Text</button>";
    }
    private function addForumButton(){
        return "<button id='deleteButton' onclick=\"location.href='". URL_ROOT . "/forum_add/'\" type=\"button\" style=\"margin-left:10px;\" class=\"btn btn-info text-center\">Add Forum Text</button>";
    }
}