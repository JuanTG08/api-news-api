<?php
require_once 'model/location.php';
class departamentosController{
    public function getDepartamentos(){
        $Location = new Location();
        $departamentos = $Location->listDepartamentos();

        if ($departamentos) {
            echo json_encode($departamentos);
            return true;
        }
        echo json_encode(array("error" => 500));
    }
    public function getMunicipio($idDep) {
        $Location = new Location();
        $municipios = $Location->listMunicipios($idDep);

        if ($municipios) {
            echo json_encode($municipios);
            return true;
        }
        echo json_encode(array("error" => 500));
    }
}