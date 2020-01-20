<?php


class forum_data
{
    private $db;
    public function forum_data(){
        $this->db = new Database();
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
}