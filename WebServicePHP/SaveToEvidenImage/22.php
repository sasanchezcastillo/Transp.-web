<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Subir una o varias imagenes al servidor</title>
</head>
 
<body>
    <?php
    require '../Conexiones/ControladoresBD.php';
    # definimos la carpeta destino
    $carpetaDestino="../ImgFirmDriver";
 
    # si hay algun archivo que subir
    
    
    $response=Controlador::PosImageEvidencia($valorImagen,$valorIdFactura,$tipoTiempo);
    if($response)
    {
        # recorremos todos los arhivos que se han subido
        for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)
        {
                # si exsite la carpeta o se ha creado
                    $origen=$_FILES["archivo"]["tmp_name"][$i];
                    $destino=$carpetaDestino.$_FILES["archivo"]["name"][$i];
                    # movemos el archivo
                    if(@move_uploaded_file($origen, $destino))
                    {
                        echo "<br>".$_FILES["archivo"]["name"][$i]." movido correctamente";
                    }else{
                        echo "<br>No se ha podido mover el archivo: ".$_FILES["archivo"]["name"][$i];
                    }
                }
            
    }
    else{
      print json_encode(
                array(
                    'Datos' => 'Ocurrio un error al intentar registrar, vuelve a intentarlo'
                )
            );
}
    
    
    ?>
 
    <form action="22.php" method="post" enctype="multipart/form-data" name="inscripcion">
        <input type="file" name="archivo[]" multiple="multiple">
        <input type="submit" value="Enviar"  class="trig">
        <input type="text" name="id_factura_cargue" placeholder="factura">
        <input type="text" name="tiempo_evidencia_fotografica" placeholder="tiempo">
    </form>
</body>
</html>