<?php
/*
 * Memcached not implemented
 *
 * Announce Notes
 * - user can't seed from more than one location
 * - user can't download from another account on the same client
 */
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
    public function announceSession($passkey)
    {
        ob_clean();
        header('Content-type: text/plain');
        //echo $this->bencode->benc_error("Announce offline");
        //exit;
        //$response = $this->bencode->benc($response);
        $client = $_GET;

        //TODO decode passkey
        $passkey = str_replace("announce/", "", $client['url']);
        $this->db->querry("SELECT id, info_hash FROM torrents WHERE info_hash = :info");
        $this->db->bind(':info', bin2hex($client['info_hash']));
        $torrent_data = $this->db->getRow();
        if (empty($torrent_data)) {
            echo trim($this->bencode->benc_error("Torrent not registred!"));
            exit;
        }
        $this->db->querry("SELECT id, banned FROM users WHERE passkey = :pkey");
        $this->db->bind(':pkey', $passkey);
        $user = $this->db->getRow();
        $uid = $user['id'];
        if (empty($uid) || $user['banned'] == "yes") {
            echo trim($this->bencode->benc_error("User banned or doesn't exists!"));
            exit;
        }
        /*
        $this->db->querry("SELECT p.torrent FROM peers as p JOIN torrents as t WHERE p.torrent != t.id AND p.userid = :uid");
        $this->db->bind(":uid", $uid);
        $clean = $this->db->getAll();

        if(!empty($clean)) {
            dbg_log($clean);
            $compact = array();
            foreach ($clean as $value)
                array_push($compact, $value['torrent']);
            foreach ($compact as $value)
                $this->delete_peers($value, $uid);
        }
        */
        //insert to db then send it back

        $this->db->querry("SELECT * FROM peers WHERE passkey = :pkey AND torrent = :tId AND userid = :uid AND peer_id = :pid");
        $this->db->bind(':pkey', $passkey);
        $this->db->bind(':tId', $torrent_data['id']);
        $this->db->bind(':uid', $uid);
        $this->db->bind(':pid',  bin2hex($client['peer_id']));
        $peer = $this->db->getRow();

        //check seeding
        $this->db->querry("SELECT * FROM peers WHERE passkey = :pkey AND torrent = :tId AND userid = :uid");
        $this->db->bind(':pkey', $passkey);
        $this->db->bind(':tId', $torrent_data['id']);
        $this->db->bind(':uid', $uid);
        $check = $this->db->getRow();
        if(empty($peer) && !empty($check)) {
            echo trim($this->bencode->benc_error("You can't seed from more that one location!"));
            exit;
        }
        //announce related
        if(isset($peer) && $client['event'] == "stopped"){
            $this->delete_peers($torrent_data['id'], $uid);
            $peers = $this->getPeers($torrent_data['id'], $passkey, $client['compact']);
            $response = $this->bencode->announce_request($peers, $client['compact']);
            $sp = $this->getSP($torrent_data['id']);
            $this->update_torrent($sp['complete'], $sp['incomplete'], $torrent_data['id']);
            dbg_log($response);
            echo $response;
            exit;
        }elseif (!empty($peer)){
            $this->update_peers($client, $torrent_data['id'], $uid);
            $sp = $this->getSP($torrent_data['id']);
            $this->update_torrent($sp['complete'], $sp['incomplete'], $torrent_data['id']);
            $sn = $this->get_snatched($torrent_data['id'], $uid);

            $uploaded =  $sn['uploaded'] + ($client['uploaded'] - $peer['uploaded']);
            $downloaded = $sn['downloaded'] + ($client['downloaded'] - $peer['downloaded']);

            $this->update_snatched($torrent_data['id'], $uid, $uploaded, $downloaded); // Change up and down

            $peers = $this->getPeers($torrent_data['id'], $passkey, $downloaded);
            $response = $this->bencode->announce_request($peers, $client['compact']);

            echo $response;
            exit;
        }else{
            $peers = $this->getPeers($torrent_data['id'], $passkey, $client['compact']);
            $this->insert_peers($torrent_data, $client, $uid, $passkey);
            $sp = $this->getSP($torrent_data['id']);
            $this->update_torrent($sp['complete'], $sp['incomplete'], $torrent_data['id']);
            //under test
            if(!$this->check_snatched($torrent_data['id'], $uid))
                $this->insert_snatched($client, $torrent_data['id'], $uid);
            else {
                $sn = $this->get_snatched($torrent_data['id'], $uid);//useless
                $this->update_snatched($torrent_data['id'], $uid, $sn['uploaded'] + ($client['uploaded'] - $sn['uploaded']), $sn['downloaded']); // Change up and down
            }
            $response = $this->bencode->announce_request($peers, $client['compact']);
            dbg_log($response);
            echo $response;
            exit;
        }
    }
    private function checkPeer(){

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
        $complete = 0;
        $incomplete = 0;
        $peers = array(
            "complete" => $complete,
            "incomplete" => $incomplete,
            "peers" => array()
        );
        $this->db->querry("SELECT * FROM peers WHERE torrent = :tId AND passkey != :pkey");
        $this->db->bind(':pkey', $passkey);
        $this->db->bind(':tId', $tId);
        $peersData = $this->db->getAll();

        if(empty($peersData)) {
            $peers['peers'] = "";
            return $peers;
        }

        foreach ($peersData as $value)
            if($value["seeder"] == "yes")
                $complete++;
            else
                $incomplete++;

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
    private  function insert_snatched($client, $tid, $uid){
        $this->db->querry("INSERT INTO `snatched` (`torrentid`, `userid`, `ip`, `port`, `uploaded`, `downloaded`, `to_go`, `seedtime`, `leechtime`, `last_action`, `startdat`, `completedat`, `finished`)
                                  VALUES (:tid, :uid, :ip, :port, 0, 0, :to_go, 0, 0, NOW(), NOW(), NOW(), :finished)");
        $this->db->bind(':tid', $tid);
        $this->db->bind(':uid', $uid);
        $this->db->bind(':to_go', is_null($client['to_go']) ? 0 : $client['to_go']);
        $this->db->bind(':port', $client['port']);
        $this->db->bind(':ip', getip());
        $this->db->bind(':finished', is_null($client['to_go']) ? "yes" : "no");
        //  dbg_log("hello");
        $this->db->execute();
    }
    private function update_snatched($tid, $uid, $up, $down){
        $this->db->querry("UPDATE `snatched` SET `uploaded` = :up, `downloaded` = :down WHERE torrentid = :tid AND userid = :uid");
        $this->db->bind(':tid', $tid);
        $this->db->bind(':uid', $uid);
        $this->db->bind(':up', $up);
        $this->db->bind(':down', $down);
        $this->db->execute();
    }
    private function get_snatched($tid, $uid){
        $this->db->querry("SELECT uploaded, downloaded FROM `snatched` WHERE torrentid = :tid AND userid = :uid");
        $this->db->bind(':tid', $tid);
        $this->db->bind(':uid', $uid);
        return $this->db->getRow();
    }
    private function check_snatched($tid, $uid){
        $this->db->querry("SELECT * FROM `snatched` WHERE torrentid = :tid AND userid = :uid");
        $this->db->bind(':tid', $tid);
        $this->db->bind(':uid', $uid);
        $check = $this->db->getRow();
        if(empty($check) || is_null($check))
            return false;
        else
            return true;
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