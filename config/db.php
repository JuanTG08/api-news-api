<?php

class Connect{
    public static function DB(){
        $db = new mysqli('localhost', 'root', '', 'e1');
        $db->query("SET NAMES 'utf8'");
        return $db;
    }
}