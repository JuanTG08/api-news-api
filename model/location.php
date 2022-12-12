<?php

class Location {
    private $db;
    public function __construct(){
        $this->db=Connect::DB();
    }

    public function listDepartamentos(){
        $response = false;
        $sql = $this->db->query("SELECT * FROM e1departamentos");
        if ($sql) {
            $response = $sql->fetch_all();
        }
        return $response;
    }

    public function listMunicipios($idDep){
        $response = false;
        $sql = $this->db->query("SELECT * FROM e1municipios WHERE departamento_id=".$idDep);
        if ($sql) {
            $response = $sql->fetch_all();
        }
        return $response;
    }
}