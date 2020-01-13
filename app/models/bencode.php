<?php


class bencode
{
    public function bencode(){

    }
    public function benc_string($str){
        return strlen($str) . ':' . $str;
    }
    public function benc_int($i){
        return 'i' . $i . 'e';
    }
    public function benc_list(){
        
    }
    public function benc_dict(){

    }
}