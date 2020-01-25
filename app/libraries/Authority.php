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

    public function Authority(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');

        require getConfigPath();
        $this->auth = $AUTHORITY;
    }
    //TODO Skip default pages which all users can access
    public function getAuthority($access){
        if(empty($access)) return true;
        $this->cacheManager->setUserStats();
        $this->userClass = $this->cacheManager->getUserStats()['idClass'];
        foreach ($this->auth as $fkey => $fpage){
            foreach ($fpage as $key => $page) {
                //If you want to change access level to default pages remove this if
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