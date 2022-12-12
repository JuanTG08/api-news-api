<?php

class Mensaje {
    private $db;
    private $nombre;
    private $documento;
    private $telefono;
    private $correo;
    private $tema;
    private $mensaje;
    private $id_muncipio;

    public function __construct(){
        $this->db=Connect::DB();
    }

    public function setNombre($nombre){
        $this->nombre=$nombre;
    }
    public function setDocumento($documento){
        $this->documento=$documento;
    }
    public function setTelefono($telefono){
        $this->telefono=$telefono;
    }
    public function setCorreo($correo){
        $this->correo=$correo;
    }
    public function setTema($tema){
        $this->tema=$tema;
    }
    public function setId_municipio($id_municipio){
        $this->id_municipio=$id_municipio;
    }
    public function setMensaje($mensaje){
        $this->mensaje=$mensaje;
    }

    public function saveMsg(){
        $response = false;
        /* echo "INSERT INTO mensaje VALUES(NULL,'{$this->nombre}',{$this->documento},{$this->telefono},'{$this->correo}','{$this->tema}','{$this->mensaje}',{$this->id_municipio})"; */
        $sql = $this->db->query("INSERT INTO e1mensaje VALUES(NULL,'{$this->nombre}',{$this->documento},{$this->telefono},'{$this->correo}','{$this->tema}','{$this->mensaje}',{$this->id_municipio})");
        if ($sql) {
            $response = true;
        }
        return $response;
    }
}