<?php

require 'Conexiones/ControladoresBD.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    
    if(isset($_GET['cedula']) && isset($_GET['id_razon']) && isset($_GET['nombre']) && isset($_GET['apellido'])
      && $_GET['cedula'] != null && $_GET['id_razon'] != null && $_GET['nombre'] != null && $_GET['apellido'] != null
       && $_GET['cedula'] != "" && $_GET['id_razon'] != "" && $_GET['nombre'] != "" && $_GET['apellido'] != ""){
        
        $retorno = Controlador::registrar($_GET['cedula'],$_GET['id_razon'],$_GET['nombre'],$_GET['apellido']);
        
        if($retorno){
            $Datos["Resultado"] = '1';
            $Datos["Datos"] = $retorno;
            print json_encode($Datos);
        }else{
            print json_encode(
                array(
                    'Resultado' => '2',
                    'Datos' => 'Ocurrio un error al intentar registrar, vuelve a intentarlo'
                )
            );
        }
    }else{
        print json_encode(
                array(
                    'Resultado' => '3',
                    'Datos' => 'No se ha podido realizar el registro porque uno o todos los parametros requeridos no se han encontrado'
                )
            );
    }
}

?>