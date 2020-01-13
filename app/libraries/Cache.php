<?php
/**
 * Created by PhpStorm.
 * User: DESKTOP-BUF27
 * Date: 5/5/2019
 * Time: 3:57 PM
 */

class Cache
{
    private $cache;
    private $new_page = array();
    public function Cache(){
        if (!extension_loaded('memcached')) {
            throw new Exception('Memcached extension failed to load.');
        }

        $this->cache = new Memcached();
        $this->cache->addServer("localhost", 11211);
        if (Memcached::HAVE_IGBINARY) {
            $this->cache->setOption(Memcached::OPT_SERIALIZER, Memcached::SERIALIZER_IGBINARY);
        }
        $this->cache->setOption(Memcached::OPT_DISTRIBUTION, Memcached::DISTRIBUTION_CONSISTENT);
        $this->cache->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE, true);
        $this->cache->setOption(Memcached::OPT_NO_BLOCK, true);
        $this->cache->setOption(Memcached::OPT_TCP_NODELAY, true);
        $this->cache->setOption(Memcached::OPT_COMPRESSION, true);
        $this->cache->setOption(Memcached::OPT_CONNECT_TIMEOUT, 2);

        if(!$this->cache)
            die("fail");
    }
    public function getStatus(){
        return $this->cache->getStats();
    }
    public function setKey($key, $value, $duration){
        $this->cache->add($key, $value, $duration);
    }
    public function setPage($key, $value, $duration, $language){
        //$this->cache->add($key, $value, )
    }
    public function clearKey($key){
        $this->cache->delete($key);
    }

    public function getKey($key){
        return $this->cache->get($key);
    }
    public function getPage(){

    }
    public function getResultCode(){
        return $this->cache->getResultCode();
    }
}