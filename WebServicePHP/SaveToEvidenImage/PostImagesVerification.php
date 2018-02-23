<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Subir una o varias imagenes al servidor</title>
</head>
<body>
<?php
require '../Conexiones/ControladoresBD.php';
    

$valorIdFactura = $_POST['id_factura_cargue'];
$tipoTiempo = $_POST['tiempo_evidencia_fotografica'];



//if($_SERVER['REQUEST_METHOD'] == 'POST')
        for($i=0;$i< count($_FILES['uploadedfile']['name']);$i++)
        {
            $file_name = $_FILES['uploadedfile']['name'][$i];
            $response=Controlador::PosImageEvidencia($file_name,$valorIdFactura,$tipoTiempo);
            if($response)
            { 
             $add="../SaveToImageEvidencia/$file_name";
            if(@move_uploaded_file($_FILES['uploadedfile']['tmp_name'][$i], $add))
                {
            print json_encode(array('rta' => 'Registro exitoso'));
                }else
                    {
                echo "error a subir el archivo";
                    }
            }
                else
                {
                print json_encode(
                array(
                    'Datos' => 'Ocurrio un error al intentar registrar, vuelve a intentarlo'
                )
            );
        }

}
?>
   <form action="PostImagesVerification.php" method="post" enctype="multipart/form-data">
        <input type="file" name="uploadedfile[]" multiple="multiple">
        <input type="text" name="id_factura_cargue" placeholder="factura">
        <input type="text" name="tiempo_evidencia_fotografica" placeholder="tiempo">
        <input type="submit" value="Enviar"  class="trig">
    </form>
</body>
</html>  
