<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
   /* 
 

		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
    
    if(isset($_GET['cedula']) && isset($_GET['id_factura']) && isset($_GET['condicion'])){

        $url_img = "http://transporte.com.co/uploads/";
        $cedula_verificar = $_GET['cedula'];
        $id_factura_verificar = $_GET['id_factura'];
        $condicion = $_GET['condicion'];
        
        if (isset($_FILES['file_runt']['name']) && isset($_FILES['file_runt']['tmp_name'])){

            $nombre_archivo = $_FILES['file_runt']['name'];
            $tmp_archivo = $_FILES['file_runt']['tmp_name'];
            if(registrarArchivoServidor($nombre_archivo,$tmp_archivo,$cedula_verificar,"runt")){
              $messages[] = "Se ha registrado el RUNT, ";
              $file_runt_insert = $url_img.$cedula_verificar."runt".".pdf";
            } 
            else {
                $errors[] = "Error al registrar el RUNT";
            }
        }else{
            $messages_warning[] = "No se cargó el archivo RUNT por lo tanto no se registró, ";
            $file_runt_insert = "";
        }   

        if (isset($_FILES['file_simit']['name']) && isset($_FILES['file_simit']['tmp_name'])){
            $nombre_archivo = $_FILES['file_simit']['name'];
            $tmp_archivo = $_FILES['file_simit']['tmp_name'];
            if(registrarArchivoServidor($nombre_archivo,$tmp_archivo, $cedula_verificar, "simit")) {
                $messages[] = "Se ha registrado el SIMIT, ";
                $file_simit_insert = $url_img.$cedula_verificar."simit".".pdf";
            }
            else {
                $errors[] = "Error al registrar el SIMIT";
            }
        }else{
            $messages_warning[] = "No se cargó el archivo SIMIT por lo tanto no se registró, ";
            $file_simit_insert = "";
        }

        if (isset($_FILES['file_procuraduria']['name']) && isset($_FILES['file_procuraduria']['tmp_name'])){
            $nombre_archivo = $_FILES['file_procuraduria']['name'];
            $tmp_archivo = $_FILES['file_procuraduria']['tmp_name'];
            if(registrarArchivoServidor($nombre_archivo,$tmp_archivo,$cedula_verificar,"procuraduria")) {
                $messages[] = "Se ha registrado Procuraduría, ";
                $file_procuraduria_insert = $url_img.$cedula_verificar."procuraduria".".pdf";
            }
            else {
                $errors[] = "Error al registrar Procuraduría";
            }
        }else{
            $messages_warning[] = "No se cargó el archivo Procuraduría por lo tanto no se registró, ";
            $file_procuraduria_insert = "";
        }

        if (isset($_FILES['file_contraloria']['name']) && isset($_FILES['file_contraloria']['tmp_name'])){
            $nombre_archivo = $_FILES['file_contraloria']['name'];
            $tmp_archivo = $_FILES['file_contraloria']['tmp_name'];
            if(registrarArchivoServidor($nombre_archivo,$tmp_archivo,$cedula_verificar,"contraloria")) {
                $messages[] = "Se ha registrado Contraloría. ";
                $file_contraloria_insert = $url_img.$cedula_verificar."contraloria".".pdf";
            }
            else {
                $errors[] = "Error al registrar Contraloría";
            }
        }else{
            $messages_warning[] = "No se cargó el archivo Contraloría por lo tanto no se registró. ";
            $file_contraloria_insert = "";
        }
        
        /*$query=mysqli_query($con, "select id_razon_social from razon_social where nombre_razon_social ='".$razon_social."'");
        $rw_user=mysqli_fetch_array($query);
        $count=mysqli_num_rows($query);
        if ($count>=1){*/
            
        $query=mysqli_query($con, "select * from documentos where cedula_conductor_documento = '".$cedula_verificar."'");    
        $rw_con=mysqli_fetch_array($query);
        $count=mysqli_num_rows($query);
        if($count >= 1){
            $sql="UPDATE documentos SET ";
            $accion = false;
            if($file_runt_insert != null && $file_runt_insert != ""){
                $accion = true;
                $sql.= "runt_documento = '".$file_runt_insert."' , ";
            }
            
            if($file_procuraduria_insert != null && $file_procuraduria_insert != ""){
                $accion = true;
                $sql.= "procuraduria_documento = '".$file_procuraduria_insert."' , ";
            }
            
            if($file_contraloria_insert != null && $file_contraloria_insert != ""){
                $accion = true;
                $sql.= "contraloria_documento = '".$file_contraloria_insert."' , ";
            }
            
            if($file_simit_insert != null && $file_simit_insert != ""){
                $accion = true;
                $sql.= "simit_documento = '".$file_simit_insert."' , ";
            }
            
            $sql.= " fecha_hora_documento = now() where cedula_conductor_documento = '".$cedula_verificar."'";
            
            error_log($sql);
        }else{
            $sql="INSERT INTO documentos (cedula_conductor_documento, runt_documento, procuraduria_documento, contraloria_documento, simit_documento, fecha_hora_documento) 
            VALUES ('".$cedula_verificar."','".$file_runt_insert."','".$file_procuraduria_insert."','".$file_contraloria_insert."','".$file_simit_insert."',now());";
        }
        
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
                
                if($condicion == "aprobar"){
                    $sql = "update estados_cargues set estado_cargue = 1 where consecutivo_cargue = '".$id_factura_verificar."'";
                }else if($condicion == "noaprobar"){
                    $sql = "update estados_cargues set estado_cargue = 3 where consecutivo_cargue = '".$id_factura_verificar."'";
                }
               
                //$sql = "update estados_cargues set estado_cargue = 1 where id_factura_cargue = '".$id_factura_verificar."'";

                $query_new_insert = mysqli_query($con,$sql);
			    if ($query_new_insert){
                    $messages[] = "Conductor ha sido verificado satisfactoriamente.";
                    
                    $query=mysqli_query($con, "SELECT concat(con.nombre_conductor,' ',con.apellido_conductor) as nombre_conductor,
                        con_vehi.placa_vehiculo  
                        FROM conductores con 
                        JOIN conductores_vehiculos con_vehi 
                        JOIN cargues car 
                        ON con.cedula_conductor = con_vehi.cedula_conductor 
                        AND con_vehi.id_conductor_vehiculo = car.id_conductor_vehiculo
                        WHERE car.consecutivo_cargue = '".$id_factura_verificar."'");
                    $rw_user=mysqli_fetch_array($query);
                    $count=mysqli_num_rows($query);
                    if ($count>=1){
                        $nombre_conductor = $rw_user['nombre_conductor'];
                        $placa_vehiculo = $rw_user['placa_vehiculo'];

                        include ('../classes/notificacion_verificar.php');
                        if($condicion == "aprobar"){
                            $msg = "El vehículo con placa ".$placa_vehiculo." asignado al conductor ".$nombre_conductor." con número de cédula ".$cedula_verificar." se encuentra pendiente por despachar";
                            enviarNotificacion($msg, "Vehículo Pendiente",$id_factura_verificar, $placa_vehiculo, $cedula_verificar);
                        }else if($condicion == "noaprobar"){
                            $msg = "El vehículo con placa ".$placa_vehiculo." asignado al conductor ".$nombre_conductor." con número de cédula ".$cedula_verificar." no se ha aprobado para el cargue por razones legales.";
                            enviarNotificacion($msg, "Vehículo NO Aprobado",$id_factura_verificar, $placa_vehiculo, $cedula_verificar);
                        }
                        
                    }else{
                        $errors[] = "No se pudo enviar la notificación, si vuelve a ocurrir contacte con el departamento de sistemas";
                    }
                }else{
                    $errors []= "No se pudo modificar el estado del cargue.".mysqli_error($con);    
                }
				
			} else{
                error_log("Error SQL: ".$sql." Cédula: ".$cedula_verificar);
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
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
        
            if (isset($messages_warning)){
				
				?>
				<div class="alert alert-warning" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>¡Advertencia!</strong>
						<?php
							foreach ($messages_warning as $message) {
									echo $message;
								}
							?>
				</div>
				<?php
			}
        
        
}else{
        ?>
				<div class="alert alert-warning" role="alert">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Error! </strong>
				        No se ha podido obtener los valores condicionales para realizar el registro, si sigue ocurriendo contacte con el Departamento de Sistemas
				</div>
				<?php
    }

function registrarArchivoServidor($nombre_archivo, $tmp_archivo, $cedula, $tipo_registro){
    $upload_folder ='../uploads';
    $archivador = $upload_folder . '/' . $cedula . $tipo_registro . ".pdf";

    if (!move_uploaded_file($tmp_archivo, $archivador)) {
        return false;
    }
    return true;
}
?>