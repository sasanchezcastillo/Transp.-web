<?php

require '../Conexiones/ControladoresBD.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST['id_factura_cargue']) && isset($_POST['aspecto_verificado']) && isset($_POST['estado']) && isset($_POST['observaciones'])
    &&  $_POST['id_factura_cargue'] != null && $_POST['aspecto_verificado'] != null && $_POST['estado'] != null && $_POST['observaciones'] != null ) {

        $retorno = Controlador::registrarIspection($_POST['id_factura_cargue'],$_POST['aspecto_verificado'],$_POST['estado'],$_POST['observaciones']);
        
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