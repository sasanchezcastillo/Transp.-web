<?php
/* Connect To Database*/
require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado

    
    if(!isset($_POST['cedula']) && empty($_POST['cedula'])){ //verificar que la variable cedula no se encuentre vacía
        
        $errors[] = "La cedula se encuentra vacía. ";
        
    }else if(!isset($_POST['placa']) && empty($_POST['placa'])){ //verificar que la variable placa no se encuentre vacía
        
        $errors[] = "La placa se encuentra vacía. ";
        
    }else if(!isset($_POST['destino']) && empty($_POST['destino'])){ //verificar que la variable destino no se encuentre vacía
        
        $errors[] = "El destino se encuentra vacío. ";
    }else{
        //Consulta el id del conductor para realizar el registro del cargue
        $query=mysqli_query($con, "SELECT id_conductor_vehiculo from conductores_vehiculos where cedula_conductor = '".$_POST['cedula']."' and placa_vehiculo = '".$_POST['placa']."' ");
        $row = mysqli_fetch_array($query);
        
        if($row['id_conductor_vehiculo'] != "" && !empty($row['id_conductor_vehiculo'])){ //verificar que la id del conductor no se encuentre vacía
            
            // Registrar en la tabla cargues            
            $id_conductor_vehiculo = $row['id_conductor_vehiculo'];
            $sql="insert into cargues(id_conductor_vehiculo, id_usuario_usuarios, fecha_hora_cargue, destino) values ('".$id_conductor_vehiculo."','".$_SESSION['user_id_usuario']."',now(),'".$_POST['destino']."')";
    
            $query_new_insert = mysqli_query($con,$sql);
            
            if ($query_new_insert){
                    $messages[] = "Se ha registrado en la tabla cargues exitosamente. ";
                
                    //Consultar el id del consecutivo auto_increment que se registra al registrar el cague
                    $query=mysqli_query($con, "SELECT MAX(consecutivo_cargue) as consecutivo from cargues");
                    $row = mysqli_fetch_array($query);
                    
                    if($row['consecutivo'] != "" && !empty($row['consecutivo'])){ //verificar que el id del consecutivo no se encuentre vacía
                        
                        $id_consecutivo = $row['consecutivo']; 

                        $target_dir = "../facturas-despachos/";
                        $carpeta=$target_dir;

                        if (!file_exists($carpeta)) {
                            mkdir($carpeta, 0777, true);
                        }

                        $cantidad = $_GET['cantidad'];

                        // ciclo que recorre todos los datos que se han agregado en las filas
                        for($i = 0; $i<=$cantidad; $i++){

                            // tomar el nombre del archivo
                            $name_file = $_FILES["adjunto".$i]["name"];
                            $tmp_archivo = $_FILES['adjunto'.$i]['tmp_name'];
                            
                            
                            //concatenarle la url 
                            $url = "http://190.168.100.74/facturas-despachos/".$_POST['id_factura'.$i].".html";
                            $archivo = $_POST['id_factura'.$i].".html";

                            $sql="insert into factura_despacho(consecutivo_cargue, id_factura_despacho, url_documento, tipo_documento) values ('".$id_consecutivo."','".$_POST['id_factura'.$i]."','".$url."','".$_POST['checked_factura'.$i]."')";

                            $query_new_insert = mysqli_query($con,$sql);
                            if ($query_new_insert){
                                
                                $num_fila=$i+1;
                                $messages[] = "Se ha registrado en la tabla factura_despacho exitosamente. ";
                                $target_file = $carpeta . basename($archivo);
                                $uploadOk = 1;
                                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

                                // verificar si el archivo ya existe
                                /*if (file_exists($target_file)) {
                                    
                                    $errors[]= "Lo sentimos, el archivo de la fila ".$num_fila." ya existe, entonces no se registró. ";
                                    $uploadOk = 0;
                                }*/
                                
                                // carga el archivo en el servidor
                                if (move_uploaded_file($tmp_archivo, $target_file)) {    
                                    $messages[] = "Se ha registrado exitosamente el archivo de la fila ".$num_fila.". ";
                                }else{
                                    $errors []= "Algo ha salido mal al registrar el archivo de la fila ".$num_fila.". ";
                                }
                                
                            } else {
                                $errors[]= "ALgo ha salido mal al registrar en la tabla factura_despacho.".mysqli_error($con);
                            }
                        }
                        
                        if($errors == null || !isset($errors)){
                            //registra el estado del cargue
                            $sql="insert into estados_cargues(consecutivo_cargue, fecha_hora_cargue, estado_cargue) values ('".$id_consecutivo."',now(),'0')";

                            $query_new_insert = mysqli_query($con,$sql);
                            if ($query_new_insert){
                                // Todo el registro se realizó sin errores y se redirecciona a la página cargues
                                echo '<script type="text/javascript">javascript:window.location="http://transporte.com.co/cargues.php"</script>';
                            }else{
                                $errors[]= "ALgo ha salido mal al registrar en la estados_cargues.".mysqli_error($con).". ";       
                            }    
                        }
                    }
                
            }else{
                $errors []= "Algo ha salido mal al registrar en la tabla cargues. ".mysqli_error($con).". ";
            }
            
        }
    }

    //muestra todo lo que se realizó con exito durante el registro
    if (isset($messages)){
        error_log("id de messages");
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

    //muestra todos los errores que ocurrieron durante el registro
    if (isset($errors)){
        error_log("id de errors");
        ?>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Error!</strong> 
                <?php
                    foreach ($errors as $error) {
                            echo $error.", ";
                    }
                    ?>
        </div>
        <?php
    }
    
?>