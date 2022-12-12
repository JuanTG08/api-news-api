<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
require_once 'config/db.php';
require_once 'controller/departamentosController.php';
require_once 'controller/mensajeController.php';
require_once 'controller/newsController.php';
require_once 'controller/userController.php';
require_once 'hook.php';

//Departamentos y municipios
if (isset($_POST['redirection']) && !empty($_POST['redirection'])) {
    $redirect = $_POST['redirection'];
    switch ($redirect) {
        case 'getDepartamentos':
            $controller = new departamentosController();
            $controller->getDepartamentos();
            break;
        case 'getMunicipios':
            $controller = new departamentosController();
            $controller->getMunicipio($_POST['id']);
            break;
    }
}else if (isset($_GET['saveMessages'])){ // Guardamos los mensajes que nos envian en el Contactenos
    $controller = new mensajesController();
    $data = descomprimir($_GET['msg']);
    $controller->saveMensaje($data);
}
// Usuario
else if (isset($_GET['loginUser']) && !empty($_GET['userNameLog'])) { // Un usuario se loguea
    $data = descomprimir($_GET['userNameLog']);
    $controller = new userController();
    $controller->loginUser($data);
}else if (isset($_GET['registerUser'])){ // Un usuario se registra
    $controller = new userController();
    $data = descomprimir($_GET['use']);
    $controller->saveUser($data);
}
else if (isset($_GET['getUsers'])) { // Obtenemos los usuarios en espera de aceptado
    $controller = new userController();
    $controller->getUsers();
}
else if (isset($_GET['getUsersLoading'])) { // Obtenemos los usuarios en espera de aceptado
    $controller = new userController();
    $controller->getLoadingUsers();
}else if (isset($_GET['setAcceptUserLoading']) && !empty($_POST['user'])){ // Se acepta crear el usuario en espera
    $controller = new userController();
    $controller->setAcceptLoadungUser($_POST['user']);
}else if (isset($_GET['setDennyUserLoading']) && !empty($_POST['user'])){ // Se deniega el crear el usuario en espera
    $controller = new userController();
    $controller->setAcceptDennyUser($_POST['user']);
}else if (isset($_GET['recoverPassword']) && !empty($_GET['mail'])) { // Recuperar la Contraseña
    $controller = new userController();
    $mail = $_GET['mail'];
    $controller->recoverPassword($mail);
}else if (isset($_GET['changeRecoverPassword']) && !empty($_POST)) { // Cambio de Contraseña al intentar Recuperarla.
    echo json_encode($_POST);
}
else if (isset($_GET['getUserId'])){ // Obtenemos el userID
    echo json_encode((!empty($_SESSION['UserID'])) ? $_SESSION['UserID'] : array("error" => true, "errorCode" => 404, "res" => "Usuario no logeado"));
}else if (isset($_GET['deleteSession'])){ // Eliminamos la sesion del Usuario
    if (isset($_SESSION['UserID'])) {
        unset($_SESSION['UserID']);
    }
}
// Noticias
else if (isset($_GET['getOneNews']) && !empty($_GET['idNew'])) { // Se obtiene la noticia con sus parrafos
    $id = $_GET['idNew'];
    $controller = new newsController();
    $controller->getOneNews($id);
}
else {
    echo json_encode(array("error" => 404));
}

function descomprimir($data) {
    return json_decode($data);
}
