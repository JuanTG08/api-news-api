<?php
require_once 'model/user.php';
require_once './controller/mailController.php';
class userController{
    public function loginUser($data){
        $loginUser= new User();
        $loginUser-> setCorreo($data->correo);
        $loginUser -> setContra($data->contra);
        $loginUser= $loginUser->joinUser();

        if ($loginUser) {
            $_SESSION['UserID'] = $loginUser;
            /*var_dump($_SESSION['UserID']); */
            echo json_encode($loginUser);
        }else{
            echo json_encode(array("error" => true, "errorCode" => 500, "res" => "Valores invalidos."));
        }
    }

    public function getUsers() {
        if (isset($_SESSION['UserID']->rol)) {
            if ($_SESSION['UserID']->rol === "admin") {
                $User = new User();
                $listLoadingUsers = $User->getUsersList();
                if ($listLoadingUsers) {
                    echo json_encode(array("error" => false, "errorCode" => 200, "res" => $listLoadingUsers));
                }else {
                    echo json_encode(array("error" => false, "errorCode" => 404, "res" => "No hay registros."));
                }                
            }else {
                echo json_encode(array ("error" => true, "errorCode" => 502, "res" => "No tienes permisos para esto."));
            }
        }else {
            echo json_encode(array ("error" => true, "errorCode" => 404, "res" => "No estas logueado."));
        }
    }


    public function getLoadingUsers() {
        if (isset($_SESSION['UserID']->rol)) {
            if ($_SESSION['UserID']->rol === "admin") {
                $User = new User();
                $listLoadingUsers = $User->getLoadingUsersList();
                if ($listLoadingUsers) {
                    echo json_encode(array("error" => false, "errorCode" => 200, "res" => $listLoadingUsers));
                }else {
                    echo json_encode(array("error" => false, "errorCode" => 404, "res" => "No hay registros."));
                }                
            }else {
                echo json_encode(array ("error" => true, "errorCode" => 502, "res" => "No tienes permisos para esto."));
            }
        }else {
            echo json_encode(array ("error" => true, "errorCode" => 404, "res" => "No estas logueado."));
        }
    }

    public function setAcceptLoadungUser($user) {
        if (isset($_SESSION['UserID']->rol)) {
            if ($_SESSION['UserID']->rol === "admin") {
                $User = new User();
                $setAccept = $User->setAcceptUserLoading($user);
                if ($setAccept) {
                    echo json_encode(array("error" => false, "errorCode" => 200, "res" => $setAccept));
                }else {
                    echo json_encode(array("error" => false, "errorCode" => 404, "res" => "No se puede aceptar el usuario."));
                } 
            }else {
                echo json_encode(array ("error" => true, "errorCode" => 502, "res" => "No tienes permisos para esto."));
            }
        }else {
            echo json_encode(array ("error" => true, "errorCode" => 404, "res" => "No estas logueado."));
        }
    }

    public function setAcceptDennyUser($user) {
        if (isset($_SESSION['UserID']->rol)) {
            if ($_SESSION['UserID']->rol === "admin") {
                $User = new User();
                $setDenny = $User->setDennyUserLoading($user);
                if ($setDenny) {
                    echo json_encode(array("error" => false, "errorCode" => 200, "res" => $setDenny));
                }else {
                    echo json_encode(array("error" => false, "errorCode" => 404, "res" => "No se puede denegar el usuario."));
                } 
            }else {
                echo json_encode(array ("error" => true, "errorCode" => 502, "res" => "No tienes permisos para esto."));
            }
        }else {
            echo json_encode(array ("error" => true, "errorCode" => 404, "res" => "No estas logueado."));
        }
    }

    public function saveUser($data){
        $saveUser= new User();
        $saveUser -> setUsuario($data->user);
        $saveUser-> setCorreo($data->correo);
        $saveUser -> setContra($data->contra);
        $saveUser -> setRol('user');

        $verifyUser = $saveUser->verifyMail();

        if ($verifyUser == true) {
            $userSave = $saveUser->saveReg();
            if ($userSave) {
                echo json_encode(array("error" => false, "errorCode" => 200, "res" => "En espera a que un Administrador acepte la petición."));
            }else {
                echo json_encode(array("error" => true, "errorCode" => 501, "res" => "Error en la Conexion."));
            }
        }else {
            echo json_encode(array("error" => true, "errorCode" => 500, "res" => "El usuario ya Existe"));
        }
    }
    public function recoverPassword($mail) {
        $echo = false;
        $Pin = Hook::getPin();
        $body = 'El codigo de cambio de contraseña seria: '.$Pin;

        $User = new User();
        $User->setCorreo($mail);
        $verifyUser = $User->verifyMail();

        $verifyPass = $this->verifyChangePassword($mail); // Verificamos los registros en la tabla
        require_once 'views/formRevoveryPass.php';
        $formRecovery = trim($html);
        if (!$verifyPass) {
            if (!$verifyUser) { // Si existe el usuario
                $mailController = new mailController();
                $mailSend = $mailController->sendMail('Codigo de Recuperacion', $body, $body, $mail); // Se envia el mensaje al correo
                $response = json_decode($mailSend); // La respuesta del envio
                if ($response->status == 200) {
                    $time = date('H:i:s', time() + (6 * 60 * 60));
                    $res = $User->changePasswordPin($mail, $Pin, $time); // Se crea un nuevo registro en la tabla
                    if ($res == true) {
                        $echo = array("error" => false, "errorCode" => 200, "res" => "Se envio correctamente el Mensaje a su correo.", "body" => $formRecovery); // Mensaje satisfactorio
                    }else {
                        $echo = array("error" => true, "errorCode" => 501, "res" => "Error de Conexion"); // No se pudo acceder a la BD
                    }
                }else {
                    $echo = array("error" => true, "errorCode" => 502, "res" => "No se pudo enviar el correo."); // Error en el correo
                }
            }else {
                $echo = array("error" => true, "errorCode" => 503, "res" => "El correo no existe."); // Se debe registrar con un correo valido
            }
        }else {
            $echo = array("error" => false, "errorCode" => 200, "res" => "Peticion en proceso.", "body" => $formRecovery); // Ya hay una peticion de cambio de contraseña.
        }
        echo json_encode($echo);
    }

    public static function verifyChangePassword($mail) {
        $res = false;
        $User = new User();
        $verifyUser = $User->getRegistrosChangePassword($mail);
        if ($verifyUser) {
            $timeActual = date('H:i:s', (time()-600)  + (6 * 60 * 60));
            if ($verifyUser[0][2] >$timeActual) {
                $res = true;
            }else {
                echo "a";
                $User->deleteChangePassword($mail);
            }
        }
        return $res;
    }
}