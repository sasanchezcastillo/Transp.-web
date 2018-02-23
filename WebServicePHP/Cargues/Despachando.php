<?php

require '../Conexiones/ControladoresBD.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
    if(isset($_POST['consecutivo']) && $_POST['consecutivo'] != null && $_POST['consecutivo'] != "" ){
        
        $retorno=Controlador::modificarCargueDespachado($_POST['consecutivo']);
        
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