<?php

/*
 * Authority Class restrict people to access pages by their level.
 * That means every page on the site goes through this class,
 * the levels are from the config file default or custom.
 */
class Authority extends Controller
{
    private $db;
    private $cacheManager;
    private $userClass;
    private $auth;
    private $pages;


    public function Authority(){

        $this->db = new Database();

        $this->cacheManager = $this->model('cacheManager');

        require getConfigPath();
        $this->auth = $AUTHORITY;
    }
    //TODO Skip default pages witch all users can access
    //
    public function getAuthority($access){

        if(empty($access)) return true;
        $this->cacheManager->setUserStats();
        $this->userClass = $this->cacheManager->getUserStats()['class'];
        foreach ($this->auth as $fkey => $fpage){
            foreach ($fpage as $key => $page) {
                //If you want to change access level to default pages remove thi if
                if($fkey == 'pages' && $key == $access) return true;
                if (in_array($this->userClass, $page) && $key == $access) {
                    return $key;
                }
            }
        }
        return false;
    }
    public function changeAuth($toChange, $value){
        foreach ($this->auth as $fkey => $fpage){
            foreach ($fpage as $key => $page){
                if($toChange === $key) {
                    $this->auth[$fkey][$key] =  $value;
                }
            }
        }
    }
}