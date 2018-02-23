<?php

require '../Conexiones/ControladoresBD.php';



    

$valorImagen = basename($_FILES['uploadedfile']['name']);
$valorIdFactura = $_POST['id_factura_cargue'];
$valorIdConductor = $_POST['id_conductor_vehiculo'];

//if($_SERVER['REQUEST_METHOD'] == 'POST'){

       $response=Controlador::PostDriverAcepto($valorImagen,$valorIdFactura,$valorIdConductor);

    if($response){ 
        $file_name= $_FILES['uploadedfile']['name'];
        $add="../ImgFirmDriver/$file_name";
        
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $add))
        {
            print json_encode(array('rta' => 'Registro exitoso'));
        }else
        {
            echo "error a subir el archivo";
        }
        
     }
else{
      print json_encode(
                array(
                    'Datos' => 'Ocurrio un error al intentar registrar, vuelve a intentarlo'
                )
            );
}


//}
    //else{
         //print json_encode(
         //   array(
           //     'Resultado' => '3',
             //   'Datos' => 'No se ha podido realizar el registro porque uno o todos los parametros //requeridos no se han encontrado'
            //)
       // );
//}

 ?>
