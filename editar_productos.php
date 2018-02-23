	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar vehículo</h4>
		  </div>
		  <div class="modal-body">
            <form class="form-horizontal" method="post" id="editar_producto" name="editar_producto">
                <div id="resultados_ajax2"></div>

                <div class="form-group">
                    <label for="mod_placa" class="col-sm-3 control-label">Placa Vehículo</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control upperCase" id="mod_placa_vehiculo" name="mod_placa_vehiculo" placeholder="Placa del vehículo" required>
                        <input type="hidden" name="mod_id" id="mod_id">
                    </div>
                </div>

                <div class="form-group">
                    <label for="mod_soat" class="col-sm-3 control-label">Placa Remolque</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control upperCase" id="mod_placa_remolque" name="mod_placa_remolque" placeholder="Placa del remolque"  required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mod_soat" class="col-sm-3 control-label">Capacidad</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control upperCase" id="mod_cantidad_vehiculo" name="mod_cantidad_vehiculo" placeholder="Capacidad del vehículo" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mod_soat" class="col-sm-3 control-label">Soat</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="mod_soat" name="mod_soat"  required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mod_tecnicomecanico" class="col-sm-3 control-label">Tecnicomecánico</label>
                    <div class="col-sm-8">
                        <input type="date" class="form-control" id="mod_tecnicomecanico" name="mod_tecnicomecanico" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="mod_observaciones" class="col-sm-3 control-label">Observaciones</label>
                    <div class="col-sm-8">
                        <textarea class="form-control upperCase" id="mod_observaciones" name="mod_observaciones" placeholder="Observaciones del vehículo"></textarea>
                    </div>
                </div>


                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-warning" id="actualizar_datos">Actualizar datos</button>
                </div>
            </form>
        </div>
		</div>
	  </div>
	</div>
	<?php
		}
	?>