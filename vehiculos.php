<?php
	/*-------------------------
	Autor: David Casadiegos
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
    }
    if($_SESSION['user_tipoUsuario'] != null && $_SESSION['user_tipoUsuario'] != 'Administrador' ) {
        header("location: verificar.php");
        exit;
    }
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$active_verificar="";
	$active_cargues="";
	$active_conductores="";
    $active_vehiculos="active";
	$active_usuarios="";
	$title="Vehículos | Coagrotransporte";
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
				<button type='button' class="btn btn-warning" data-toggle="modal" data-target="#nuevoProducto"><span class="glyphicon glyphicon-plus" ></span> Nuevo Vehículo</button>
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Vehículos:</h4>
		</div>
		<div class="panel-body">
		
			<?php
			include("modal/registro_vehiculos.php");
			include("modal/editar_productos.php");
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Placa</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Placa del vehículo" onkeyup='load(1);'>
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
	<script type="text/javascript" src="js/vehiculos.js"></script>
  </body>
</html>
<script>
$( "#guardar_producto" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_vehiculo.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax_productos").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax_productos").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_producto" ).submit(function( event ) {
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_vehiculo.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

function obtener_datos(id){

        var placa_vehiculo = document.getElementById("placa_vehiculo"+id).value;
        var placa_remolque = document.getElementById("placa_remolque"+id).value;
        var cantidad_vehiculo = document.getElementById("cantidad_vehiculo"+id).value;
        var soat_vehiculo = document.getElementById("soat_vehiculo"+id).value;
        var tecnicomecanico_vehiculo = document.getElementById("tecnicomecanico_vehiculo"+id).value;
        var observaciones_vehiculo = document.getElementById("observaciones_vehiculo"+id).value;
    
        $("#mod_id").val(id);
        $("#mod_placa_vehiculo").val(placa_vehiculo);
        $("#mod_placa_remolque").val(placa_remolque);
        $("#mod_cantidad_vehiculo").val(cantidad_vehiculo);
        $("#mod_soat").val(soat_vehiculo);
        $("#mod_tecnicomecanico").val(tecnicomecanico_vehiculo);
        $("#mod_observaciones").val(observaciones_vehiculo);
    }
</script>