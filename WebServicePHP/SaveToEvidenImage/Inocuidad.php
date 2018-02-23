<?php

require '../Conexiones/ControladoresBD.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['id_factura_cargue']) && isset($_POST['aspecto_verificado_calidad_inocuidad']) && isset($_POST['estado_calidad_inocuidad'])
    &&  $_POST['id_factura_cargue'] != null && $_POST['aspecto_verificado_calidad_inocuidad'] != null && $_POST['estado_calidad_inocuidad'] != null ) {

        $retorno = Controlador::registrarInocuida($_POST['id_factura_cargue'],$_POST['aspecto_verificado_calidad_inocuidad'],$_POST['estado_calidad_inocuidad']);
        
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
       
    }else
    {
         print json_encode(
                array(
                    'Resultado' => '3',
                    'Datos' => 'No se ha podido realizar el registro porque uno o todos los parametros requeridos no se han encontrado'
                )
            );
    }


}
    

        
    
?>