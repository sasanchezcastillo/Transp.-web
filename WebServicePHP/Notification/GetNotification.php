<?php
/**
 * Obtener datos para realizar el login
 */
require '../Conexiones/ControladoresBD.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Tratar retorno
        $retorno = Controlador::getNotify();

        if ($retorno) {
		/*$Datos["Resultado"] = '1';
                $Datos["Datos"] = $retorno;*/
                print json_encode($retorno);
        } else {
		print json_encode($retorno);
                
        }
    
    

}
?>