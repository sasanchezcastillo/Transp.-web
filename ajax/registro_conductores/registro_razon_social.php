<?php
	include('../is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/*Inicia validacion del lado del servidor*/
	if (isset($_POST['nombre_razon_social']) && !empty($_POST['nombre_razon_social'])) {
           
        /* Connect To Database*/
        require_once ("../../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
        require_once ("../../config/conexion.php");//Contiene funcion que conecta a la base de datos
        // escaping, additionally removing everything that could be (html/javascript-) code
        $nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre_razon_social"],ENT_QUOTES)));
        
        if(empty($_POST['correo_razon_social'])){
            $messages_warning []= "Correo electrónico No Aplica. ";
            $correo = "No Aplica";
        }else{
            $correo=mysqli_real_escape_string($con,(strip_tags($_POST["correo_razon_social"],ENT_QUOTES)));    
        }
        
        if(empty($_POST['telefono_razon_social'])){
            $messages_warning []= "Telefono No Aplica. "; 
            $telefono = "No Aplica";
        }else{
            $telefono=mysqli_real_escape_string($con,(strip_tags($_POST["telefono_razon_social"],ENT_QUOTES)));    
        }
        
        $sql="INSERT INTO razon_social (nombre_razon_social, correo_razon_social, telefono_razon_social) VALUES (UPPER('".$nombre."'),UPPER('".$correo."'),UPPER('".$telefono."'))";
        $query_new_insert = mysqli_query($con,$sql);
        if ($query_new_insert){
            $messages[] = "Razón social ha sido ingresada satisfactoriamente.";
        } else{
            $errors []= "Algo ha salido mal al registrar la razón social, intenta nuevamente.".mysqli_error($con);
        }

            
    }else{
        $errors[] = "El nombre de la razón social se encuentra vacío";
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