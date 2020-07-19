<?php
/*
 * App Core Class
 * Creates URL & loads core controller
 * URL FROMAT - /method/params
 */

require_once "functions.php";
require_once "functions_announce.php";
require_once APP_ROUTE . "/models/cacheManager.php";
@session_start();
//TODO Language system for a "translator" to translate the page

class Core{
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];
    //This is the mapping for Controllers(keys) and Methods(values)
    //If you want to add a page this is where you will add it first.
    private $pages;
    private $memcached;

    public function Core(){
        $this->memcached = new cacheManager();
        require getConfigPath();
        $this->pages = $PAGES;

        $startTime = microtime(true);
        //error_reporting(-1); // remove this

        $url = $this->getUrl();

        $db = new Database();
        if(isLogged()) {
            $auth = new Authority();
        }
        //todo update last seen
        if(isset($_COOKIE['c_secure_uid']) && timeDiff($this->memcached->getLastSeen()) > 10){
            $db->querry("UPDATE users SET last_access = NOW() WHERE id = :uid");
            $db->bind(":uid", base64_decode($_COOKIE['c_secure_uid']));
            $db->execute();
            $this->memcached->setLastSeen();
        }

        $db->querry("SELECT globalSignUp, trackerStatus FROM tracker LIMIT 1");
        $globalSignUp = $db->getRow();
        $globalSignUp = $globalSignUp['globalSignUp'];
        $trackerStatus = $db->getRow();
        $trackerStatus = $trackerStatus['trackerStatus'];

        if(!$trackerStatus)
            die("<h1>Site is offline!</h1>");
        //Set the default language
        if(!isset($_SESSION['language']) && empty($_COOKIE['language']))
            setLanguage();

        if(isLogged() && $url[0] == "logout"){
            $past = time() - 3600;
            foreach ($_COOKIE as $key => $value )
            {
                setcookie( $key, $value, $past, '/' );
            }
            redirect("");
        }
        if($url[0] === 'announce')
            block_browser(); //check if is browser
        if(isLogged() &&   ($this->getControllerName($url[0]) !== "Access" || empty($url[0]))){
            if($auth->getAuthority($url[0])) {
                if (empty($url) || !$this->getControllerName($url[0])) {
                    $this->currentController = "Home";
                    $this->currentMethod = "index";
                    require_once '../app/controllers/' . $this->currentController . '.php';
                    $this->currentController = new $this->currentController();
                } else {
                    $this->currentController = $this->getControllerName($url[0]);
                    require_once '../app/controllers/' . $this->currentController . '.php';
                    $this->currentController = new $this->currentController();
                }
                if (method_exists($this->currentController, $url[0])) {
                    $this->currentMethod = $url[0];
                    // remove this if you want index to show instead of home, also change home in takelogin.php in index
                    unset($url[0]);
                }
            }
        }elseif (!isLogged() && ($this->getControllerName($url[0]) === "Access" || empty($url[0]) )) {
            if (empty($url)) {
                $this->currentController = "Access";
                $this->currentMethod = "login";
            } else {
                $this->currentController = "Access";
            }

            require_once '../app/controllers/' . $this->currentController . '.php';
            $this->currentController = new $this->currentController();
            $this->currentMethod = 'login';

            if (method_exists($this->currentController, $url[0])) {
                $this->currentMethod = $url[0];
                unset($url[0]);
            }
        }elseif ($url[0] === 'announce' && !empty($url[1])){
            $this->currentController = 'announce';
            unset($url[0]);
            require_once '../app/controllers/' . $this->currentController . '.php';
            $this->currentController = new $this->currentController();
            $this->currentMethod = 'announceSession';
            unset($url[0]);
        }else{
            redirect("");
            //die("<h1>Page not found</h1>");
        }

        if(!isLogged() && $this->currentMethod == "signup" && !$globalSignUp['globalSignUp'])
            $this->currentMethod = "closedSignUp";

        // Get params
        //TODO accept array of paramterers ex. : www.host.com/method/variable1/value1/variable2/value2
        $this->params = $url ? $url : [];

        $db->closeDb();
        //Call a callback with array of params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        echo "<br><b><a style='color: #00ccff; font-size: large;'>Time:  " . number_format(((microtime(true) - $startTime)*1000), 2) . "ms\n</a></b>";
    }
    public function getUrl(){
        if(isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url,  FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            return $url;
        }
    }
    private function getControllerName($url){
        if(empty($url)){
            return true;
        }
        foreach ($this->pages as $key => $page){
            if(in_array($url, $page))
                return $key;
        }
        return false;
    }
}
