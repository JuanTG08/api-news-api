<?php
require_once 'model/login.php';
class loginController{
    public function loginUser($data){
        $loginUser= new login();
        $loginUser-> setCorreo($data->correo);
        $loginUser -> setContra($data->contra);
        $loginUser= $loginUser->joinUser();

        if ($loginUser) {
            echo json_encode($loginUser);
        }else{
             echo json_encode($loginUser);
        }
    }
}