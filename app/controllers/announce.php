<?php

class announce extends Controller
{
    private $db;
    private $cacheManager;
    private $bencode;
    public function announce(){
        $this->db = new Database();
        $this->cacheManager = $this->model('cacheManager');
        $this->bencode = $this->model('bencode');
    }
    // Here goes all the benconde packet it should return an echo back to torrent client and update the database
    public function announceSession($passkey){
        ob_clean();
        //echo $this->bencode->benc_error("Announce offline");
        //exit;
        //$response = $this->bencode->benc($response);
        header('Content-type: text/plain');
        $client = $_GET;
        $passkey = str_replace("announce/", "", $client['url']);
        $this->db->querry("SELECT id, info_hash FROM torrents WHERE info_hash = :info");
        $this->db->bind(':info', bin2hex($client['info_hash']));
        $torrent_data = $this->db->getRow();
        if(empty($torrent_data)){
          echo trim($this->bencode->error_benc("Torrent not registred!"));
          exit;
        }
        $this->db->querry("SELECT id FROM users WHERE passkey = :pkey");
        $this->db->bind(':pkey', $passkey);
        $uid = $this->db->getRow()['id'];
        if(empty($uid)){ // TODO: add bened column in the `users` table and check here
            echo trim($this->bencode->error_benc("User banned or doesn't exists!"));
            exit;
        }
        //insert to db then send it back
        $this->db->querry("SELECT * FROM peers WHERE passkey = :pkey AND torrent = :tId");
        $this->db->bind(':pkey', $passkey);
        $this->db->bind(':tId', $torrent_data['id']);
        $is_seeding = $this->db->getRow()['id'];

        if(empty($is_seeding)){
            //insert peers
            $peers = $this->getPeers($torrent_data['id'], $passkey, $client['compact']);
            $response = $this->bencode->announce_request($peers, $client['compact']);
            $sp = $this->getSP($torrent_data['id']);
            $this->update_torrent($sp['complete'], $sp['incomplete'], $torrent_data['id']);
            $this->insert_peers($torrent_data, $client, $uid, $passkey);
            echo $response;
            //echo $response;
            //echo trim($this->bencode->error_benc("Done!"));
        }elseif ($client['event'] == "stopped"){
            $this->delete_peers($torrent_data['id'], $uid);
            $peers = $this->getPeers($torrent_data['id'], $passkey, $client['compact']);
            $response = $this->bencode->announce_request($peers, $client['compact']);

            $sp = $this->getSP($torrent_data['id']);
            $this->update_torrent($sp['complete'], $sp['incomplete'], $torrent_data['id']);
            echo $response;
            exit;
        }else{
            $this->update_peers($client, $torrent_data['id'], $uid);
            $peers = $this->getPeers($torrent_data['id'], $passkey, $client['compact']);
            $response = $this->bencode->announce_request($peers, $client['compact']);
            //update torrent seeders and leechers
            $sp = $this->getSP($torrent_data['id']);
            $this->update_torrent($sp['complete'], $sp['incomplete'], $torrent_data['id']);

            if(getip() == "37.48.95.213") {
                $file = fopen(DIR_TORRENTS . "log.txt", 'w');
                fwrite($file, print_r($response, true));
                fclose($file);
            }

           echo  $response;
        }
    }
    private function getSP($tid){
        $this->db->querry("SELECT seeder FROM peers WHERE torrent = :tid");
        $this->db->bind(':tid', $tid);
        $peersData = $this->db->getAll();
        $sp = array(
            "complete" => 0,
            "incomplete" => 0,
        );
        foreach ($peersData as $value){
            if($value['seeder'] == "yes")
                $sp['complete']++;
            else
                $sp['incomplete']++;
        }
        return $sp;
    }
    private function getPeers($tId, $passkey, $compact){
        $this->db->querry("SELECT * FROM peers WHERE torrent = :tId AND passkey != :pkey");
        $this->db->bind(':pkey', $passkey);
        $this->db->bind(':tId', $tId);
        $peersData = $this->db->getAll();
        $complete = 0;
        $incomplete = 0;
        foreach ($peersData as $value)
            if($value["seeder"] == "yes")
                $complete++;
            else
                $incomplete++;
        $peers = array(
            "complete" => $complete,
            "incomplete" => $incomplete,
            "peers" => array()
        );
        if ($compact == 1){
            $peer_list = "";
            foreach ($peersData as $value) {
                $longip = ip2long($value['ip']);
                if ($longip) //Ignore ipv6 address
                    $peer_list .= pack("Nn", sprintf("%d", $longip), $value['port']);
            }
            $peers['peers'] = $peer_list;
            return $peers;
        }else {
            foreach ($peersData as $value) {
                array_push($peers['peers'], array(
                    "peer id" => hex2bin($value['peer_id']),
                    "ip" => $value['ip'],
                    "port" => (int)$value['port']
                ));
            }
            return $peers;
        }
    }
    private  function insert_snatched($peer){
        $this->db->querry("INSERT INTO `snatched` (`torrentid`, `userid`, `ip`, `port`, `uploaded`, `downloaded`, `to_go`, `seedtime`, `leechtime`, `last_action`, `startdat`, `completedat`, `finished`)
                                  VALUES (:tid, :uid, :ip, :port, :uploaded, :downloaded, :to_go, :seedtime, :leechtime, NOW(), NOW(), NOW(), :finished)");
        $this->db->bind(':tid', $tid);
        $this->db->bind(':uid', $uid);

        $this->db->execute();
    }
    private function update_snatched($tid, $uid){
        $this->db->querry("UPDATE `snatched` SET `uploaded` = :up, `downloaded` = :down WHERE torrentid = :tid AND userid = :uid");
        $this->db->bind(':tid', $tid);
        $this->db->bind(':uid', $uid);
        $this->db->execute();
    }
    private function insert_peers($torrent_data, $client, $uid, $passkey){
        $ip = getip();
        $conn = $this->is_connectable($ip, $client['port']);
        $this->db->querry("INSERT INTO peers (torrent, userid, peer_id, ip, port,connectable, uploaded, downloaded, to_go, started, last_action, seeder, agent, downloadoffset, uploadoffset, passkey)
                               VALUES (:tId, :uid, :peerId, :ip, :port, :conn, 0, 0, :to_go,  NOW(), NOW(), :seeder, :agent, 0, 0, :passkey)");
        $this->db->bind(':tId', $torrent_data['id']);
        $this->db->bind(':peerId', bin2hex($client['peer_id']));
        $this->db->bind(':ip', $ip);
        $this->db->bind(':port', $client['port']);
        if($client['left']){
            $this->db->bind(':to_go', $client['left']);
            $this->db->bind(':seeder', "no");
        }else{
            $this->db->bind(':to_go', $client['left']);
            $this->db->bind(':seeder', "yes");
        }
        $this->db->bind(':uid', $uid);
        $this->db->bind(':agent', $_SERVER['HTTP_USER_AGENT']);
        $this->db->bind(':passkey', $passkey);
        $this->db->bind(':conn', $conn);
        $this->db->execute();
    }

    private function update_peers($client, $tid, $uid)
    {
        $ip = getip();
        $this->db->querry("UPDATE `peers` SET ip = :ip, port = :port, uploaded = :uploaded, downloaded = :downloaded, to_go = :to_go, seeder = :seeder WHERE torrent = :tid AND userid = :uid ");
        $this->db->bind('ip', $ip);
        $this->db->bind('port', $client['port']);
        $this->db->bind(':uploaded', $client['uploaded']);
        $this->db->bind(':downloaded', $client['downloaded']);
        $this->db->bind(':to_go', $client['left']);
        $this->db->bind(':tid', $tid);
        $this->db->bind(':uid', $uid);
        $this->db->bind(':seeder', $client['left'] ? "no" : "yes");
        $this->db->execute();
    }
    private function delete_peers($tid, $uid){
        $this->db->querry("DELETE FROM `peers` WHERE userid = :uid AND torrent = :tid");
        $this->db->bind(':uid', $uid);
        $this->db->bind(':tid', $tid);
        $this->db->execute();
    }
    private function update_torrent($seeders, $leechers, $tid)
    {
        $this->db->querry("UPDATE `torrents` SET seeders = :seeders, leechers = :leechers WHERE id = :tid");
        $this->db->bind(':seeders', $seeders);
        $this->db->bind(':leechers', $leechers);
        $this->db->bind(':tid', $tid);
        $this->db->execute();
    }
    private function is_connectable($ip, $port){
        $sockres = @pfsockopen($ip, $port, $errno, $errstr, 5);
        if (!$sockres)
        {
            return "no";
        }
        else
        {
            @fclose($sockres);
            return "yes";
        }
    }
}