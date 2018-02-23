<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
        
        if (empty($_POST['placa_remolque'])) {
           $messages_warning[] = "Placa remolque no se registró";
        }
        if (!isset($_POST['placa_vehiculo'])) {
           $errors[] = "No modifiques el nombre del campo placa vehículo";
        }else if (!isset($_POST['placa_remolque'])) {
           $errors[] = "No modifiques el nombre del campo placa remolque";
        }else if (!isset($_POST['cantidad_vehiculo'])) {
           $errors[] = "No modifiques el nombre del campo cantidad vehículo";
        }else if (!isset($_POST['soat_vehiculo'])) {
           $errors[] = "No modifiques el nombre del campo SOAT vehículo";
        }else if (!isset($_POST['tecnicomecanico_vehiculo'])) {
           $errors[] = "No modifiques el nombre del campo tecnicomecánico";
        }else if (!isset($_POST['observaciones_vehiculo'])) {
           $errors[] = "No modifiques el nombre del campo observaciones";
            
        }else if (empty($_POST['placa_vehiculo'])) {
           $errors[] = "Placa vehículo vacía";
        }else if (empty($_POST['placa_remolque'])) {
           $errors[] = "Placa remolque vacía";
        }else if (empty($_POST['cantidad_vehiculo'])) {
           $errors[] = "Capacidad vehículo vacía";
        }else if (empty($_POST['soat_vehiculo'])) {
           $errors[] = "SOAT vacío";
        }else if (empty($_POST['tecnicomecanico_vehiculo'])) {
           $errors[] = "Tecnicomecánico vacío";
        } else if (
			!empty($_POST['placa_vehiculo']) &&
            !empty($_POST['placa_remolque']) &&
            !empty($_POST['soat_vehiculo']) &&
			!empty($_POST['tecnicomecanico_vehiculo'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$placa_vehiculo=mysqli_real_escape_string($con,(strip_tags($_POST["placa_vehiculo"],ENT_QUOTES)));
        $placa_remolque=mysqli_real_escape_string($con,(strip_tags($_POST["placa_remolque"],ENT_QUOTES)));
        $cantidad_vehiculo=mysqli_real_escape_string($con,(strip_tags($_POST["cantidad_vehiculo"],ENT_QUOTES)));
        $soat=mysqli_real_escape_string($con,(strip_tags($_POST["soat_vehiculo"],ENT_QUOTES)));
        $tecnicomecanico=mysqli_real_escape_string($con,(strip_tags($_POST["tecnicomecanico_vehiculo"],ENT_QUOTES)));
        $observaciones=mysqli_real_escape_string($con,(strip_tags($_POST["observaciones_vehiculo"],ENT_QUOTES)));
		$sql="INSERT INTO vehiculos (placa_vehiculo, placa_remolque, cantidad_vehiculo, soat_vehiculo,tecnicomecanico_vehiculo,observaciones_vehiculo,fecha_creacion_vehiculo) VALUES (UPPER('$placa_vehiculo'),UPPER('$placa_remolque'),UPPER('$cantidad_vehiculo'),UPPER('$soat'),UPPER('$tecnicomecanico'),UPPER('$observaciones'),now())";
		$query_new_insert = mysqli_query($con,$sql);
			if ($query_new_insert){
				$messages[] = "Vehiculo ha sido ingresado satisfactoriamente.";
			} else{
				$errors []= "Lo siento algo ha salido mal intenta nuevamente.".mysqli_error($con);
			}
		} else {
			$errors []= "Error desconocido.";
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