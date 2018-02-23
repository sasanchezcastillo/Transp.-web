	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="nuevoProducto" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Agregar nuevo vehículo</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
			<div id="resultados_ajax_productos"></div>
                
			  <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Placa Vehículo</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control upperCase" placeholder="Placa del vehículo" id="placa_vehiculo" name="placa_vehiculo"  required>
				</div>
			  </div>
            
                <div class="form-group">
                    <label for="codigo" class="col-sm-3 control-label">Placa Remolque</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control upperCase" placeholder="Placa del Remolque (si aplica)" id="placa_remolque" name="placa_remolque" >
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="codigo" class="col-sm-3 control-label">Capacidad</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control upperCase" placeholder="Capacidad del vehículo (Kg)" id="cantidad_vehiculo" name="cantidad_vehiculo"  required>
                    </div>
                </div>
                
                <!--
                <div class="form-group">
				<label for="codigo" class="col-sm-3 control-label">Marca</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control upperCase" id="marca_vehiculo" name="marca_vehiculo" placeholder="Marca del vehículo" required>
				</div>
			  </div>
                
                <div class="form-group">
				<label for="modelo_vehiculo" class="col-sm-3 control-label">Modelo</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control upperCase" id="modelo_vehiculo" name="modelo_vehiculo" placeholder="Modelo del vehículo" required>
				</div>
			  </div>
                
                <div class="form-group">
				<label for="tipo_vehiculo" class="col-sm-3 control-label">Tipo</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control upperCase" id="tipo_vehiculo" name="tipo_vehiculo" placeholder="Tipo del vehículo" required>
				</div>
			  </div>
                -->

                
                <div class="form-group">
				<label for="soat_vehiculo" class="col-sm-3 control-label">SOAT</label>
				<div class="col-sm-8">
				  <input type="date" class="form-control upperCase" id="soat_vehiculo" value="<?php echo date("Y-m-d");?>" name="soat_vehiculo" required>
				</div>
			  </div>
                
                <div class="form-group">
				<label for="tecnicomecanico_vehiculo" class="col-sm-3 control-label">Tecnicomecánico</label>
				<div class="col-sm-8">
				  <input type="date" class="form-control" id="tecnicomencanico_vehiculo" value="<?php echo date("Y-m-d");?>"name="tecnicomecanico_vehiculo">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="observaciones_vehiculo" class="col-sm-3 control-label">Observaciones</label>
				<div class="col-sm-8">
					<textarea class="form-control upperCase" id="observaciones_vehiculo" name="observaciones_vehiculo" placeholder="Observaciones del vehículo" maxlength="255" ></textarea>
				</div>
			  </div>	 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-warning" id="guardar_datos">Guardar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>
	<?php
		}
	?>