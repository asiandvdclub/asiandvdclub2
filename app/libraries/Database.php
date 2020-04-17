<?php

class Database{
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_pass;

    private $db_stm;
    private $dbconn;
    private $error;

    public function Database(){
        $this->db_host = DB_HOST;
        $this->db_name = DB_NAME;
        $this->db_user = DB_USER;
        $this->db_pass = DB_PASS;

        $prep_db = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_PERSISTENT => PDO::ERRMODE_EXCEPTION
        );
        try {
            $this->dbconn = new PDO($prep_db, $this->db_user, $this->db_pass, $options);
            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->dbconn->exec("SET CHARACTER SET utf8");
            $this->dbconn->exec("SET NAMES utf8");
        }catch (PDOException $e){
            $this->error = $e->getMessage();
            die("Can't connect to database </br>Error: " . $this->error);
        }
    }
    public function closeDb(){
        $this->dbconn = null;
        $this->db_stm = null;
    }

    public function querry($querry){
        $this->db_stm = $this->dbconn->prepare($querry);
    }
    // Bind values
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->db_stm->bindValue($param, $value, $type);
    }
    public function execute(){
       return $this->db_stm->execute();
    }
    // This will result an array of objects
    public function getAll(){
        $this->execute();
        return $this->db_stm->fetchAll(PDO::FETCH_ASSOC);
    }
    // Get single row as object
    public function getRow(){
        $this->execute();
        return $this->db_stm->fetch();
    }
    public function rowCount(){
        return $this->db_stm->rowCount();
    }
    public function getStatus(){
        $attributes = array(
            "CLIENT_VERSION", "SERVER_VERSION", "SERVER_INFO",  "CONNECTION_STATUS", "ERRMODE",
        );
        $db_status = array();
        foreach ($attributes as $val) {
            $db_status["PDO::ATTR_$val"] = $this->dbconn->getAttribute(constant("PDO::ATTR_$val"));
        }
        return $db_status;
    }
}