<?php
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_placa_vehiculo'])) {
           $errors[] = "Placa vehículo vacía";
        }else if (empty($_POST['mod_placa_remolque'])) {
           $errors[] = "Placa remolque vacía";
        }else if (empty($_POST['mod_cantidad_vehiculo'])) {
           $errors[] = "Capacidad vehículo vacía si";
        }else if (empty($_POST['mod_soat'])) {
           $errors[] = "SOAT vacío";
        }else if (empty($_POST['mod_tecnicomecanico'])) {
           $errors[] = "Tecnicomecánico vacío";
        } else if (
			!empty($_POST['mod_id']) &&
            !empty($_POST['mod_placa_vehiculo']) &&
            !empty($_POST['mod_placa_remolque']) &&
            !empty($_POST['mod_cantidad_vehiculo']) &&
            !empty($_POST['mod_soat']) && 
            !empty($_POST['mod_tecnicomecanico']) 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
		$placa_vehiculo=mysqli_real_escape_string($con,(strip_tags($_POST["mod_placa_vehiculo"],ENT_QUOTES)));
        $placa_remolque=mysqli_real_escape_string($con,(strip_tags($_POST["mod_placa_remolque"],ENT_QUOTES)));
        $cantidad_vehiculo=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cantidad_vehiculo"],ENT_QUOTES)));
        $soat=mysqli_real_escape_string($con,(strip_tags($_POST["mod_soat"],ENT_QUOTES)));
        $tecnicomecanico=mysqli_real_escape_string($con,(strip_tags($_POST["mod_tecnicomecanico"],ENT_QUOTES)));
        $observaciones=mysqli_real_escape_string($con,(strip_tags($_POST["mod_observaciones"],ENT_QUOTES)));
        
		$id_vehiculo=$_POST['mod_id'];
        
		$sql="UPDATE vehiculos SET 
        placa_remolque=UPPER('".$placa_remolque."'), 
        cantidad_vehiculo=UPPER('".$cantidad_vehiculo."'), 
        soat_vehiculo=UPPER('".$soat."'), 
        tecnicomecanico_vehiculo=UPPER('".$tecnicomecanico."'), 
        observaciones_vehiculo=UPPER('".$observaciones."') 
        WHERE placa_vehiculo='".$id_vehiculo."'";
		$query_update = mysqli_query($con,$sql);
			if ($query_update){
				$messages[] = "Vehículo ha sido actualizado satisfactoriamente.";
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

?>