<?php
/**
 * Created by PhpStorm.
 * User: DESKTOP-BUF27
 * Date: 5/7/2019
 * Time: 10:33 PM
 */

class cacheManager
{
    private $db;
    private $cache;
    private $user_cache;
    private $auth;
    //private $userStats = array();

    public function cacheManager(){
     $this->db = new Database();
     $this->cache = new Cache();
     // $this->auth = new Authority();
     $this->user_cache = 'user_' . base64_decode($_COOKIE['c_secure_uid']) . '_stats';
    }

    public function setUserStats(){
        //Check hash function of hasChange() is diferent from getKey('user_stats') hash if so clear and add key to cache;

       // $this->cache->clearKey($this->user_cache); // <---- remove this after testing

        //TODO Cache user by ID where ID is the key , user_stats_ . ID
        if (empty($this->cache->getKey($this->user_cache))) {

            $this->db->querry("SELECT u.id, u.username, u.uploaded, u.downloaded, u.class FROM users as u WHERE u.id = :userid");
            $this->db->bind(":userid", base64_decode($_COOKIE['c_secure_uid']));
            $row = $this->db->getRow();
            $this->cache->setKey($this->user_cache, $row, 1800);
        }
    }
    public function getSiteManager($userClass){
        //$this->cache->clearKey('site_manager_bar');
        //Manage this
        //$this->cache->clearKey('site_manager_bar');
        if($userClass == UC_STAFFLEADER){
            if(!$this->cache->getKey('site_manager_bar')){  // <----- this need to bee in the user cache
                $htmlBar = "<td><a href=\"" . URL_ROOT . "\staff_panel\" class=\"badge badge-primary\">Staff Panel</a></td>
                            <td><a href=\"" . URL_ROOT . "\site_settings\" class=\"badge badge-primary\">Site Settings</a></td>
                            <td><a href=\"" . URL_ROOT . "\\forum_manager\" class=\"badge badge-primary\">Forum Manager</a></td>";
                $this->cache->setKey('site_manager_bar', $htmlBar, 86400);
                return $this->cache->getKey('site_manager_bar');
            }else{
                return $this->cache->getKey('site_manager_bar');
            }
        }elseif($userClass == UC_MODERATOR){
            if(!$this->cache->getKey('site_manager_bar')){
                $htmlBar = "<td><a href=\"" . URL_ROOT . "\staff_panel\" class=\"badge badge-primary\">Staff Panel</a></td>                            
                            <td><a href=\"" . URL_ROOT . "\\forum_manager\" class=\"badge badge-primary\">Forum Manager</a></td>";
                $this->cache->setKey('site_manager_bar', $htmlBar, 86400);
                return $this->cache->getKey('site_manager_bar');
            }else{
                return $this->cache->getKey('site_manager_bar');
            }
        }else{
            return "";
        }
    }
    public function getUserStats(){
        return $this->cache->getKey($this->user_cache);
    }
    public function setNews(){

    }
}