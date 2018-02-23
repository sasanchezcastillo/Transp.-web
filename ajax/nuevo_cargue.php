<?php
/* Connect To Database*/
require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
echo $_POST['id_factura0'];
echo $_POST['adjunto0'];
echo $_FILES['adjunto0']['name'];
echo $_POST['cedula'];


	if (empty($_POST['valor_cedula_conductores_vehiculos'])) {
           $errors[] = "La cédula se encuentra vacía";
      //  } else if(empty($_POST['num_factura'])){
      //      $errors[] = "No has digitado el número de la factura";
        }else if (empty($_POST['placa_vehiculo'])){
            $errors[] = "No has seleccionado una placa";
        }else if (empty($_POST['contadorFilas'])){
            $errors[] = "No se puedo obtener la cantidad de filas agregadas";
        }else if (empty($_POST['destino_cargue'])){
            $errors[] = "El destino se encuentra vacío";
        }else{
            
            // escaping, additionally removing everything that could be (html/javascript-) code
            $cedula=mysqli_real_escape_string($con,(strip_tags($_POST["cedula"],ENT_QUOTES)));
            $placa=mysqli_real_escape_string($con,(strip_tags($_POST["placa"],ENT_QUOTES)));
            /*$num_factura=mysqli_real_escape_string($con,(strip_tags($_POST["num_factura"],ENT_QUOTES)));*/

            /*$query=mysqli_query($con, "select id_factura_cargue from cargues where id_factura_cargue ='".$num_factura."'");
            $rw_user=mysqli_fetch_array($query);
            $count=$count=mysqli_num_rows($query);
            if ($count==0){
                */
                $query=mysqli_query($con, "select id_conductor_vehiculo from conductores_vehiculos where cedula_conductor ='".$cedula."' and placa_vehiculo = '".$placa."'");
                $rw_user=mysqli_fetch_array($query);
                $count=$count=mysqli_num_rows($query);
                if ($count>=1){
                    

                    $dataIdFactura = json_decode($_POST['idFactura']);
                    echo ($dataIdFactura[0]);

                    $dataAdjunto = json_decode($_POST['adjunto']);
                    echo ($dataAdjunto[0]);

                    $dataCheck_factura = json_decode($_POST['check_factura']);
                    echo ($dataCheck_factura[0]);
                    
                    $id_conductor_vehiculo = $rw_user['id_conductor_vehiculo']; 
                    
                    $destino_cargue = $_POST['destino_cargue'];
                    
                    $sql="insert into cargues 
                        (id_conductor_vehiculo, id_usuario_usuarios, fecha_hora_cargue, destino) values('".$id_conductor_vehiculo."','".$_SESSION['user_id_usuario']."',now(),'".$destino_cargue."')";

                    $query_new_insert = mysqli_query($con,$sql);
                        if ($query_new_insert){
                            $messages[] = "Se ha registrado el cargue exitosamente.";
                        }else{
                            $sql="delete from estado_cargues where id_factura_cargue = '".$num_factura."'";
                    
                            $query_new_insert = mysqli_query($con,$sql);
                            if ($query_new_insert){
                                
                            }else{
                                $errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
                            }
                        } 
                    
                    $consecutivo = consultarConsecutivo();
                    
                    $contadorFilas = $_POST['contadorFilas'];
                    
                    
                    for ($i=0; $i <= $contadorFilas ; $i++) { 
                        
                        $upload_folder ='uploads';

                        $nombre_archivo = $_FILES['documento'.$i]['name'];

                        $tipo_archivo = $_FILES['documento'.$i]['type'];

                        $tamano_archivo = $_FILES['documento'.$i]['size'];

                        $tmp_archivo = $_FILES['documento'.$i]['tmp_name'];

                        $archivador = $upload_folder . '/' . $nombre_archivo;

                        if (!move_uploaded_file($tmp_archivo, $archivador)) {

                            $return = Array('ok' => FALSE, 'msg' => "Ocurrio un error al subir el archivo. No pudo guardarse.", 'status' => ‘error’);
                            $nombre_archivo = "";
                        }

                        registrarFactura($consecutivo, $dataIdFactura[$i], $nombre_archivo, $tipoDocumento);

                    }

                    /*
                        insert into cargues 
                        (id_conductor_vehiculo, id_usuario_usuarios, fecha_hora_cargue, destino)
                        values ();

                        $id_consecutivo = select max(consecutivo_cargue) from cargues;

                        insert into factura_despacho(consecutivo_cargue, id_factura_despacho, url_documento, tipo_documento)
                        values (".id_consecutivo.")
                    */

                    //$errors[] = echo var_dump($dataIdFactura);
                    
/*
                    $sql="INSERT INTO cargues(id_factura_cargue, id_conductor_vehiculo, id_usuario_usuarios, fecha_hora_cargue) values ('$num_factura','$id_conductor_vehiculo','".$_SESSION['user_id_usuario']."',now())";
                    
                    $query_new_insert = mysqli_query($con,$sql);
                    if ($query_new_insert){
                        $sql="INSERT INTO estados_cargues(id_factura_cargue, estado_cargue, fecha_hora_cargue) values ('$num_factura',0,now())";
                    
                        $query_new_insert = mysqli_query($con,$sql);
                        if ($query_new_insert){
                            $messages[] = "Se ha registrado el cargue exitosamente.";
                        }else{
                            $sql="delete from estado_cargues where id_factura_cargue = '".$num_factura."'";
                    
                            $query_new_insert = mysqli_query($con,$sql);
                            if ($query_new_insert){
                                
                            }else{
                                $errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
                            }
                        } 
                    } else {
                        $errors []= "Error desconocido.";
                    }*/
           /* }else{
                $errors []= "Ya se encuentra registrado un cargue con este número de factura";
            }*/
        }
    }

        if (isset($errors)){

            ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Error!</strong> 
                    <?php
                        foreach ($errors as $error) {
                                echo $error;
                        }
                        ?>
            </div>
            <?php
        }

        if (isset($messages)){

            ?>
            <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>¡Bien hecho!</strong>
                    <?php
                        foreach ($messages as $message) {
                                echo $message;
                            }
                        ?>
            </div>
            <?php
        }


function registrarFactura($consecutivo_cargue, $id_factura_despacho, $documento, $tipo_documento){
    
    $upload_folder='uploads';
    $nombre_archivo=$_FILES['documento']['name'];
    
    
    $sql="insert into factura_despacho(consecutivo_cargue, id_factura_despacho, url_documento, tipo_documento)
                        values (".id_consecutivo.")";
    
    $query_new_insert = mysqli_query($con,$sql);
    if ($query_new_insert){
        echo "registrada factura: ".id_factura_despacho;
    }
}

function consultarConsecutivo(){
    $query=mysqli_query($con, "SELECT MAX(consecutivo_cargue) as consecutivo from cargues");
    $row = mysqli_fetch_array($query);
    return $row['consecutivo'];         
}




?>