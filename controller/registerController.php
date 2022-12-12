<?php
require_once 'model/register.php';
class registerController{
    public function saveUser($data){
        $saveUser= new Register();
        $saveUser -> setUsuario($data->user);
        $saveUser-> setCorreo($data->correo);
        $saveUser -> setContra($data->contra);
        $saveUser -> setRol('user');

        $verifyUser = $saveUser->verifyMail();

        if ($verifyUser == true) {
            $userSave = $saveUser->saveReg();
            if ($userSave) {
                echo json_encode(array("error" => false, "errorCode" => 200, "res" => "Se creo correctamente el Usuario"));
            }else {
                echo json_encode(array("error" => true, "errorCode" => 501, "res" => "Error en la Conexion."));
            }
        }else {
            echo json_encode(array("error" => true, "errorCode" => 500, "res" => "El usuario ya Existe"));
        }
    }
}