<?php


class bencode extends Controller
{
    public function bencode(){

    }
    public function benc_string($str){
        return strlen($str) . ':' . $str;
    }
    public function benc_int($i){
        return 'i' . $i . 'e';
    }
    public function benc_list($a) {
        $s = "l";
        foreach ($a as $e) {
            $s .= $this->benc($e);
        }
        $s .= "e";
        return $s;
    }
    public function benc_dict(){
        return "domo";
    }
    public function bdec_file($f, $ms)
    {
        $fp = fopen($f, "rb");
        if (!$fp)
            return "error" ;
        $e = fread($fp, $ms);
        fclose($fp);
        return $this->bdec($e);
    }
    private function bdec($str, &$_len = 0) //bdecoding
    {
        $type = substr($str, 0, 1);

        if (is_numeric($type)) {
            $type = 's';
        }

        switch ($type) {
            case 'i': //integer
                $p = strpos($str, 'e');
                $_len = $p + 1; //lenght of bencoded data
                return intval(substr($str, 1, $p - 1));
                break;

            case 's': //string
                $p = strpos($str, ':');
                $len = substr($str, 0, $p);
                $_len = $len + $p + 1; //lenght of bencoded data
                return substr($str, $p + 1, $len);
                break;

            case 'l': //list
                $l = 1;
                $ret_array = array();
                while (substr($str, $l, 1) != 'e') {
                    $ret_array[] = $this->bdec(substr($str, $l), $len);
                    $l += $len;
                }
                $_len = $l + 1; //lenght of bencoded data
                return $ret_array;
                break;

            case 'd': //dictionary
                $l = 1;
                $ret_array = array();
                while (substr($str, $l, 1) != 'e') {
                    $var = $this->bdec(substr($str, $l), $len);
                    $l += $len;

                    $ret_array[$var] = $this->bdec(substr($str, $l), $len);
                    $l += $len;
                }
                $_len = $l + 1; //lenght of bencoded data
                return $ret_array;
                break;
        }
    }
    function benc($str) //bencoding
    {
        if (is_string($str)) { //string
            return strlen($str) . ':' . $str;
        }

        if (is_numeric($str)) { //integer
            return 'i' . $str . 'e';
        }

        if (is_array($str)) {
            $ret_str = ''; //the return string

            $k = key($str); //we check the 1st key, if the key is 0 then is a list if not a dictionary
            foreach($str as $var => $val) {

                if ($k) { //is dictionary
                    $ret_str .= $this->benc($var); //bencode the var
                }
                $ret_str .= $this->benc($val); //we recursivly bencode the contents
            }

            if ($k) { //is dictionary
                return 'd' . $ret_str . 'e';
            }

            return 'l' . $ret_str . 'e';
        }
    }
    function benc_error($reason){
        return $this->benc(array('failure reason' => $reason));
    }
    function announce_request($peers, $compact){
        return "d" . $this->benc_string("interval") . $this->benc_int(announce_interval) . $this->benc_string("min interval") . $this->benc_int(announce_interval_min) .
            $this->benc_string("complete") . $this->benc_int($peers['complete']) . $this->benc_string("incomplete") . $this->benc_int($peers['incomplete']) . $this->benc_string("peers") .
            ($compact ? $this->benc_string($peers['peers']) : $this->benc_list($peers['peers'])) . "e";
    }
}