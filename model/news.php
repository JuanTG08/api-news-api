<?php

class News{
    private $db;
    public function __construct() {
        $this->db=Connect::DB();
    }

    public function getOneNews($id){
        $res = false;
        $query = $this->db->query("SELECT * FROM e1noticia WHERE id_noticia={$id}");
        if ($query && $query->num_rows == 1) {
            $res = $query->fetch_object();
        }
        return $res;
    }

    public function getParrafos($id){
        $res = false;
        $query = $this->db->query("SELECT * FROM e1parrafos WHERE id_noticia={$id}");
        if ($query && $query->num_rows > 1) {
            $res = $query->fetch_all();
        }
        return $res;
    }
}