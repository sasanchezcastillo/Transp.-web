<?php
/**
 * Obtener datos para realizar el login
 */
require 'Conexiones/ControladoresBD.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if(isset($_GET['parametro']) && $_GET['parametro'] != null && $_GET['parametro'] != ""){
        
        $parametro = $_GET['parametro'];
        // Tratar retorno
        $retorno = Controlador::consultar($parametro);

        if ($retorno) {
		$Datos["Resultado"] = '1';
                $Datos = $retorno;
                print JSON_FORCE_OBJECT($Datos,JSON_FORCE_OBJECT);
        } else {
		print json_encode(
                        array(
                            'Resultado' => '2',
                            'Datos' => 'Ocurrio un error al intentar consultar la informacion'
                            )
                );
        }
    }else{
        print json_encode(
                        array(
                            'Resultado' => '3',
                            'Datos' => 'No se pudo consultar la informacion, porque no se ha encontrado el parametro para la condicion'
                            )
                );
    }

}
