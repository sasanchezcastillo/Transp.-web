<?php
	
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
    }else if(isset($_SESSION['user_tipoUsuario']) && $_SESSION['user_tipoUsuario'] != "Administrador"){
        header("location: verificar");
		exit;
    }
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_verificar="";
	$active_cargues="";
	$active_conductores="active";
    $active_vehiculos="";
	$active_usuarios="";	
	$title="Conductores | Coagrotransporte";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>
	
    <div class="container">
	<div class="panel panel-success">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<button type='button' class="btn btn-warning" data-toggle="modal" data-target="#nuevoCliente"><span class="glyphicon glyphicon-plus" ></span> Nuevo Conductor</button>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Conductores</h4>
		</div>
		<div class="panel-body">
		
			<?php
				include("modal/registro_conductores.php");
				include("modal/editar_clientes.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Conductor</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Digite el nombre o # de cédula del transportador" onkeyup='load(1);'>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
  </div>
</div>
		 
	</div>
	<hr>
	<?php
	include("footer.php");
	?>
	<script type="text/javascript" src="js/conductores.js"></script>
  </body>
</html>
