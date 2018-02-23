<?php
include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
// checking for minimum PHP version
if (version_compare(PHP_VERSION, '5.3.7', '<')) {
    exit("Sorry, Simple PHP Login does not run on a PHP version smaller than 5.3.7 !");
} else if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    // if you are using PHP 5.3 or PHP 5.4 you have to include the password_api_compatibility_library.php
    // (this library adds the PHP 5.5 password hashing functions to older versions of PHP)
    require_once("../libraries/password_compatibility_library.php");
}		

        if(empty($_POST['user_name']))
        {
            $errors[] = "Nombre de usuario vacío";
            
        }elseif($_POST['user_tipo_usuario'] !== "Administrador" && $_POST['user_tipo_usuario'] !== "Usuario"){
         
            $errors[] = "El tipo de usuario seleccionado no es correcto";
            
        }elseif(empty($_POST['user_password_new']))
        {
            $errors[] = "Contraseña Vacía";
            
        }elseif(empty($_POST['user_password_repeat']))
        {
            $errors[] = "Confirmación de contraseña vacía";
            
        }elseif(strlen($_POST['user_password_new']) < 6){
            
            $errors[] = "La contraseña debe tener como mínimo 6 caracteres";
            
        }elseif(strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2){
            
            $errors[] = "Nombre de usuario no puede ser inferior a 2 o más de 64 caracteres";
            
        }elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            
            $errors[] = "Nombre de usuario no encaja en el esquema de nombre: Sólo aZ y los números están permitidos , de 2 a 64 caracteres";
            
        }elseif($_POST['user_password_new'] !== $_POST['user_password_repeat']){
            $errors[] = "Las contraseñas no coinciden";
        } elseif (
			!empty($_POST['user_name'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && ($_POST['user_tipo_usuario'] === "Administrador" || $_POST['user_tipo_usuario'] === "Usuario")
            && !empty($_POST['user_password_new'])
            && !empty($_POST['user_password_repeat'])
            && ($_POST['user_password_new'] === $_POST['user_password_repeat'])
        ) {
            require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
			require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
			
				// escaping, additionally removing everything that could be (html/javascript-) code
                $user_name = mysqli_real_escape_string($con,(strip_tags($_POST["user_name"],ENT_QUOTES)));
				$user_tipo_usuario = mysqli_real_escape_string($con,(strip_tags($_POST["user_tipo_usuario"],ENT_QUOTES)));
				$user_password = $_POST['user_password_new'];
                // crypt the user's password with PHP 5.5's password_hash() function, results in a 60 character
                // hash string. the PASSWORD_DEFAULT constant is defined by the PHP 5.5, or if you are using
                // PHP 5.3/5.4, by the password hashing compatibility library
				$user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);
					
                // check if user or email address already exists
                $sql = "SELECT * FROM usuarios WHERE nombre_usuario = '" . $user_name . "';";
                $query_check_user_name = mysqli_query($con,$sql);
				$query_check_user=mysqli_num_rows($query_check_user_name);
                if ($query_check_user == 1) {
                    $errors[] = "Lo sentimos , el nombre de usuario ya está en uso.";
                } else {
					// write new user's data into database
                    $sql = "INSERT INTO usuarios (nombre_usuario, contrasena_usuario, tipo_usuario, fecha_creacion_usuario)
                            VALUES('".$user_name."','".$user_password_hash."','" . $user_tipo_usuario . "', now());";
                    $query_new_user_insert = mysqli_query($con,$sql);

                    // if user has been added successfully
                    if ($query_new_user_insert) {
                        $messages[] = "La cuenta ha sido creada con éxito.";
                    } else {
                        $errors[] = "Lo sentimos , el registro falló. Por favor, regrese y vuelva a intentarlo. ".mysqli_error($con).".";
                    }
                }
            
        } else {
            $errors[] = "Un error desconocido ocurrió.";
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