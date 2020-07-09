<?php


class forumManager
{
    private $db;
    public function forumManager(){
        $this->db = new Database();
    }
    public function addCategory($cat_name){
        $this->db->querry("INSERT INTO forumCategory (name) VALUES (:name)");
        $this->db->bind(":name", $cat_name);
        $this->db->execute();
        redirect("forum_manager");
    }
    public function removeCategory($cid){
        $this->db->querry("DELETE FROM forumCategory WHERE id = :cid");
        $this->db->bind(":cid", $cid);
        $this->db->execute();
        redirect("forum_manager");
    }
    public function selectCategory(){
        $this->db->querry("SELECT * FROM forumCategory");
        return $this->db->getAll();
    }
    public function addForum(){

    }
    public function removeForum(){

    }
    public function add_category_view($id){
        if(!is_string($id) && empty($this->selectCategory())) return "<a href='" . URL_ROOT . "/forum_manager/add_category'>Add catergory</a>";
        $html_out = "";
        switch ($id){
            case "add_category":
                $html_out .= "
                <label for='add_category'>Add Category</label>
                <input type='text' id='add_category' name='add_category'>
                <button type='submit'>Add</button>
                ";
                break;
            default:
                $html_out = "";
                break;
        }
        return $html_out;
    }
    public function error_manager(){
        $html_out = "";
        if(empty($this->selectCategory())){
            $html_out .= "<p style='color: red'>You need to create a category first.</p>";
        }
        return $html_out;
    }
}