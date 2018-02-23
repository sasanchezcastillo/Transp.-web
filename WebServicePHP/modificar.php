<?php

require 'Conexiones/ControladoresBD.php';

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    
    if(isset($_GET['nombre']) && $_GET['nombre'] != null && $_GET['nombre'] != "" && $_GET['cedula'] && $_GET['cedula'] != null && $_GET['cedula'] != ""){
        
        $retorno = Controlador::modificar($_GET['nombre'],$_GET['cedula']);
        
        if($retorno){
            $Datos["Resultado"] = '1';
            $Datos["Datos"] = $retorno;
            print json_encode($Datos);
        }else{
            print json_encode(
                array(
                    'Resultado' => '2',
                    'Datos' => 'No se ha podido realizar la modificacion'
                )
            );
        }
    }else{
        print json_encode(
                array(
                    'Resultado' => '3',
                    'Datos' => 'No se ha podido realizar la modificacion porque la cedula o nombre se encuentran vacios'
                )
            );
    }
}

?>