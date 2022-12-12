<?php
require_once 'model/mensaje.php';
class mensajesController{
    public function saveMensaje($data){
        $saveMensaje = new Mensaje();
        $saveMensaje -> setNombre($data->name);
        $saveMensaje -> setDocumento($data->document);
        $saveMensaje -> setTelefono($data->phone);
        $saveMensaje -> setCorreo($data->mail);
        $saveMensaje -> setTema($data->tema);
        $saveMensaje -> setId_municipio($data->mun);
        $saveMensaje -> setMensaje($data->msg);
        $saveMensaje = $saveMensaje->saveMsg();

        if ($saveMensaje) {
            /* echo json_encode(array("error" => true, "status" => 200));
            return true; */
        }else{
            /* echo json_encode(array("error" => false, "status" => 500));
            return false; */
        }
    }
}