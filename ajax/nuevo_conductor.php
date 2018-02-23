<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	
    /*Inicia validacion del lado del servidor*/
    
    
    if(!isset($_POST['cedula']) && empty($_POST['cedula'])){
        $errors[] = "Por favor digita un nombre. ";
    }else if(!isset($_POST['nombre']) && empty($_POST['nombre'])){
        $errors[] = "Por favor digita un apellido. ";
    }else if(!isset($_POST['apellido']) && empty($_POST['apellido'])){
        $errors[] = "Por favor digita un nombre. ";
    }else if(!isset($_POST['fecha_ingreso']) && empty($_POST['fecha_ingreso'])){
        $errors[] = "Por favor digita un nombre. ";
    }else if(!isset($_POST['razon_social']) && empty($_POST['razon_social'])){
        $errors[] = "Debes seleccionar un nombre de razón social. ";
    }else if($_POST['razon_social'] == "Seleccionar"){
        $errors[] = "Debes seleccionar una razón social. ";
    }else{
        
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
        $razon_social=mysqli_real_escape_string($con,(strip_tags($_POST["razon_social"],ENT_QUOTES)));
		$cedula=mysqli_real_escape_string($con,(strip_tags($_POST["cedula"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$apellido=mysqli_real_escape_string($con,(strip_tags($_POST["apellido"],ENT_QUOTES)));
		//$licencia=mysqli_real_escape_string($con,(strip_tags($_POST["licencia"],ENT_QUOTES)));
		$fecha_ingreso=mysqli_real_escape_string($con,(strip_tags($_POST["fecha_ingreso"],ENT_QUOTES)));
        
        $query=mysqli_query($con, "select id_razon_social from razon_social where nombre_razon_social ='".$razon_social."'");
        $rw_user=mysqli_fetch_array($query);
        $count=mysqli_num_rows($query);
        if ($count>=1){
            $id_razon_social = $rw_user['id_razon_social'];

            $sql="INSERT INTO conductores (cedula_conductor, id_razon_social, nombre_conductor, apellido_conductor, fecha_ingreso_conductor) VALUES (UPPER('".$cedula."'),UPPER('".$id_razon_social."'),UPPER('".$nombre."'),UPPER('".$apellido."'),UPPER('".$fecha_ingreso."'))";
            $query_new_insert = mysqli_query($con,$sql);

			if ($query_new_insert){
				$messages[] = "Conductor ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}

		}else{
            $errors[] = "No se ha encontrado el nombre de la razón social";
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

?>