<?php
	/*-------------------------
	Autor: David Casadiegos
	Mail: david.2818@outlook.com
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
	$active_cargues="active";
	$active_conductores="";
    $active_vehiculos="";
	$active_usuarios="";	
	$title="Usuarios | Coagrocostos";
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
      <script>
              // función encargada de la redirección
       /* function redireccion() {
         
            window.location = "ajax/is_logged.php";
        }

        // se llamará a la función que redirecciona después de 10 minutos (600.000 segundos)
        var temp = setTimeout(redireccion, 5000);

        // cuando se pulse en cualquier parte del documento
        document.addEventListener("click", function() {
            // borrar el temporizador que redireccionaba
            clearTimeout(temp);
            // y volver a iniciarlo
            temp = setTimeout(redireccion, 5000);
        })*/
      </script>
    <div class="container">

		<div class="panel panel-success">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
				<!--<button type='button' class="btn btn-warning" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-plus" >-</span> Nuevo Cargue</button>-->
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Cargues:</h4>
		</div>			
			<div class="panel-body">
			<?php
			include("modal/registro_cargues.php");
			include("modal/editar_usuarios.php");
			include("modal/cambiar_password.php");
            include("modal/editarFactura.php")
			?>
			<form class="form-horizontal" role="form" id="datos_cotizacion">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Nombres:</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Digite el # factura, cédula o nombre del conductor" onkeyup='load(1);'>
							</div>
							
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
                            
                            <div class="col-md-2">
								<select class="form-control" onchange="seleccion_estado();" id="estado_cargues" name="consulta_condicion_estado">
                                    <option>Todos</option>
                                    <option>Registrado</option>
                                    <option>Verificado</option>
                                    <option>En Despacho</option>
                                    <option>Despachado</option>
                                    <option>No Aprobado</option>
                                </select>
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
	<script type="text/javascript" src="js/cargues.js"></script>
  </body>
</html>
<script>
$( "#guardar_usuario" ).submit(function( event ) {
  $('#guardar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_usuario.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_usuario" ).submit(function( event ) {
  $('#actualizar_datos2').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_usuario.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos2').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_password" ).submit(function( event ) {
  $('#actualizar_datos3').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_password.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax3").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax3").html(datos);
			$('#actualizar_datos3').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})
	function get_user_id(id){
		$("#user_id_mod").val(id);
	}

	function obtener_datos(id){
			var user_name = $("#user_name"+id).val();
			var tipo_usuario = $("#user_tipo_usuario"+id).val();
			
			$("#mod_id").val(id);
			$("#user_name2").val(user_name);
			$("#user_tipo_usuario2").val(tipo_usuario);
			
		}
</script>