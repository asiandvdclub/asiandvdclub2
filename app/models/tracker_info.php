<?php


class tracker_info
{
    private $db;
    public function tracker_info(){
        $this->db = new Database();
    }
    public function users_data(){
        $data = array();
        $this->db->querry("SELECT COUNT(id) as ct FROM users");
        $temp = $this->db->getAll();
        $data['users'] = $temp[0]['ct'];
        $this->db->querry("SELECT COUNT(status) as un FROM users WHERE status = 'pending'");
        $temp = $this->db->getAll();
        $temp[0]['un'] ? $data['unconfirmed'] = $temp[0]['un'] : 0;
        $this->db->querry("SELECT COUNT(id) as total_peers,
                                  sum(case when seeder = \"yes\" then 1 else 0 end) AS seeders,
                                  sum(case when seeder = \"now\" then 1 else 0 end) AS leechers
                                  FROM peers GROUP BY id");
        $peers = $this->db->getRow();
        $data['peers'] = $peers['total_peers'] > 0 ? $peers['total_peers'] : 0;
        $data['seeders'] = $peers['seeders'] ? $peers['seeders'] : 0;
        $data['leechers'] = $peers['leechers'] ? $peers['leechers'] : 0;
        $this->db->querry("SELECT user_limit FROM tracker LIMIT 1");
        $data['user_limit'] = $this->db->getRow()['user_limit'];
        $this->db->querry("SELECT COUNT(*) FROM torrents");
        $data['total_torrents'] = $this->db->getRow()[0];
        $data['ratio'] = ($data['seeders'] != 0 && $data['leechers'] != 0) ? $data['seeders']/$data['leechers'] : 0;
        $this->db->querry("SELECT count(*) FROM users WHERE status = \"pending\"");
        $data['unconfirmed'] = $this->db->getRow()[0];
        $data['users_active_today'] = $this->users_active_today();
        $data['users_active_last_15min'] = $this->users_active_last_15min();
        return $data;
    }
    public function tracker_data_table(){
        $html_out = "<table class=\"torrenttable_helper\"  border=\"1\" cellspacing=\"0\" cellpadding=\"10\">";
    }
    public function users_active_today(){
        $act = 0;
        $this->db->querry("SELECT last_access FROM users");
        $data = $this->db->getAll();
        foreach ($data as $value) {
            $t1 = new DateTime($value['last_access']);
            $t2 = new DateTime(date("Y-m-d h:i:sa"));
            $interval = $t1->diff($t2);
            if($interval->d == 0){
                $act += 1;
            }
        }
        return $act;
    }
    public function users_active_last_15min(){
        $act = 0;
        $this->db->querry("SELECT last_access FROM users");
        $data = $this->db->getAll();
        foreach ($data as $value) {
            if(date_to_seconds($value['last_access']) <= 900)
                $act +=1;
        }
        return $act;
    }
}