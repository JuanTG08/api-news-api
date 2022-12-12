<?php
class User {

    private $db;
    private $usuario;
    private $correo;
    private $contra;
    private $rol;

    public function __construct(){
        $this->db=Connect::DB();
    }

    public function setUsuario($usuario){
        $this->usuario=$usuario;
    }
    public function setCorreo($correo){
        $this->correo=$correo;
    }
    public function setContra($contra){
        $this->contra = $contra;
    }
    public function setRol($rol){
        $this->rol=$rol;
    }

    public function getContra(){
        return password_hash($this->contra, PASSWORD_BCRYPT); 
    }

    public function verifyMail() {
        $response = false;
        $sql = $this->db->query("SELECT * FROM  e1usuario WHERE correo='{$this->correo}'");
        if ($sql->num_rows == 0) {
            $response = true;
        }
        return $response;
    }

    public function saveReg(){
        $response = false;
        $sql = $this->db->query("INSERT INTO e1usuario VALUES('{$this->usuario}','{$this->correo}','{$this->getContra()}','{$this->rol}', 3)");
        if ($sql) {
            $response = true;
        }
        return $response;
    }

    public function joinUser(){ // Se logea el usuario
        $response = false;
        $sql = $this->db->query("SELECT * FROM e1usuario WHERE correo='{$this->correo}'");
        if ($sql && $sql->num_rows == 1) {
            $res = $sql->fetch_object();
            if (password_verify( $this->contra, $res->password)) {
                $response = $res;
            }
        }
        return $response;
    }

    public function getUsersList() { // Se obtiene todos los usuarios que estan esperando aceptacion por el admin
        $response = false;
        $sql = $this->db->query("SELECT * FROM e1usuario WHERE status=1");
        if ($sql->num_rows > 0) {
            $response = $sql->fetch_all();
        }
        return $response;
    }

    public function getLoadingUsersList() { // Se obtiene todos los usuarios que estan esperando aceptacion por el admin
        $response = false;
        $sql = $this->db->query("SELECT * FROM e1usuario WHERE status=3");
        if ($sql->num_rows > 0) {
            $response = $sql->fetch_all();
        }
        return $response;
    }

    public function setAcceptUserLoading($user) {
        $response = false;
        $sql = $this->db->query("UPDATE e1usuario SET status=1 WHERE correo='{$user}'");
        if ($sql) {
            $response= $sql;
        }
        return $response;
    }

    public function setDennyUserLoading($user) {
        $response = false;
        $sql = $this->db->query("UPDATE e1usuario SET status=2 WHERE correo='{$user}'");
        if ($sql) {
            $response= $sql;
        }
        return $response;
    }

    public function getRegistrosChangePassword($correo) {
        $response = false;
        $sql = $this->db->query("SELECT * FROM e1cambio_password WHERE correo='{$correo}'");
        if ($sql->num_rows > 0) {
            $response = $sql->fetch_all();
        }
        return $response;
    }

    public function changePasswordPin($mail, $pin, $time){
        $response = false;
        $sql = $this->db->query("INSERT INTO e1cambio_password VALUES ('{$mail}', '{$pin}', '{$time}')");
        //echo "INSERT INTO cambio_password VALUES ('{$mail}', '{$pin}', '{$time}')";
        if ($sql) {
            $response = true;
        }
        return $response;
    }

    public function deleteChangePassword($correo) {
        $res = false;
        $sql = $this->db->query("DELETE FROM e1cambio_password WHERE correo='{$correo}'");
        if ($sql) {
            $res = true;
        }
        return $res;
    }
}