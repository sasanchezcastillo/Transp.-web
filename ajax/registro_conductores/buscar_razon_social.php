<?php

	/*-------------------------
	Autor: David Casadiegos
	---------------------------*/
	include('../is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code

		//Count the total number of row in your table*/
		$reload = '././conductores.php';
		//main query to fetch the data
        $sql="SELECT * FROM razon_social order by nombre_razon_social";
		//loop through fetched data
        $query = mysqli_query($con, $sql);
        $numrows=mysqli_num_rows($query);
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			
                <option value="Seleccionar">Seleccionar</option>
				<?php
				while ($row=mysqli_fetch_array($query)){
						
				    $nombre_razon_social=$row['nombre_razon_social'];
						
				?>
                    <option value="<?php echo $nombre_razon_social?>"><?php echo $nombre_razon_social?></option>
					<?php
				}
            ?>
            <?php
		}
	}
?>