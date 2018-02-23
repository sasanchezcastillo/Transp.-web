<?php
/**
 * Obtener datos para realizar el login
 */
require '../Conexiones/ControladoresBD.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if ( isset($_GET['factura']) && $_GET['factura'] != null){
        # code...
          // Tratar retorno
        $factura = $_GET['factura'];
        $retorno = Controlador::getConductorId($factura);

        if ($retorno) {
        /*$Datos["Resultado"] = '1';
                $Datos["Datos"] = $retorno;*/
                print json_encode($retorno);
        } else {
        print json_encode(
                        array(
                            'Resultado' => '2',
                            'Datos' => 'Ocurrio un error al intentar consultar la informacion'
                            )
                );
        }
    }else 
    {
        print json_encode(
                        array(
                            'Resultado' => '3',
                            'Datos' => 'parametros incorrectos'
                            )
                );

    }
}

      

?>