<?php

/*
|//////////////////\\\\\\\\\\\\\\\\\\|
|||||||Autor: David Casadiegos||||||||
|\\\\\\\\\\\\\\\\\\//////////////////|
*/	

		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo conductor</h4>
		  </div>
            <form class="form-horizontal" method="post" id="guardar_cliente" name="guardar_cliente">
		  <div class="modal-body">
			
			<div id="resultados_ajax"></div>
			  <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Cédula</label>
				<div class="col-sm-8">
				  <input type="number" class="form-control" id="cedula" name="cedula" required>
				</div>
			  </div>
                <div class="form-group">
				<label for="nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control upperCase" placeholder="Nombre Conductor" id="nombre" name="nombre" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="apellido" class="col-sm-3 control-label">Apellido</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control upperCase" placeholder="Apellido Conductor" id="apellido" name="apellido" >
				</div>
			  </div>
			  
              <!--
			  <div class="form-group">
				<label for="licencia" class="col-sm-3 control-label">Número Licencia</label>
				<div class="col-sm-8">
					<input type="text" class="form-control upperCase" id="licencia" name="licencia" >
				  
				</div>
			  </div>
			  -->
              
			  <div class="form-group">
				<label for="fecha_ingreso" class="col-sm-3 control-label">Fecha Ingreso</label>
				<div class="col-sm-8">
					<input type="date" class="form-control" id="fecha_ingreso" value="<?php echo date("Y-m-d");?>" name="fecha_ingreso" >
				</div>
			  </div>
                <div class="form-group">
				<label for="razon_social" class="col-sm-3 control-label">Razón Social</label>
				<div class="col-sm-8 ajax_razon_social">
					<select class="form-control" id="razon_social" name="razon_social">
                    </select>
				</div>
                    <a data-toggle="modal" data-target="#modalRazonSocial" style="cursor: pointer; color: black;"><img class="img-icon" src="../img/icons8_Add_New_104px_1.png"/></a>
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-warning" id="guardar_datos_registro">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>

      <div class="modal fade" id="modalRazonSocial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo razón social</h4>
		  </div>
            <form class="form-horizontal" method="post" id="guardar_razon_social" name="guardar_razon_social">
		  <div class="modal-body">
			  <div class="form-group">
				<label for="nombre_razon_social" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control upperCase" placeholder="Nombre razón social" id="nombre_razon_social" name="nombre_razon_social" required>
				</div>
			  </div>
              <div class="form-group">
                <label for="correo_razon_social" class="col-sm-3 control-label">Correo electrónico</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control upperCase" placeholder="Correo electrónico razón social" id="correo_razon_social" name="correo_razon_social">
                </div>
			  </div>
			  <div class="form-group">
				<label for="telefono_razon_social" class="col-sm-3 control-label">Telefono</label>
				<div class="col-sm-8">
				  <input type="number" class="form-control upperCase" placeholder="Telefono razón social" id="telefono_razon_social" name="telefono_razon_social" >
				</div>
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" id="cerrar_modal_razon_social" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-warning" id="guardar_datos_registro_razon">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>

	<?php
		}
	?>