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
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar Conductor</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_cliente" name="editar_cliente">
			<div id="resultados_ajax2"></div>
                
                <div class="form-group">
				<label for="mod_cedula" class="col-sm-3 control-label">Cedula</label>
                <div class="col-sm-8">
                  <input type="number" class="form-control " id="mod_cedula" name="mod_cedula" required>
                    <input type="hidden" name="mod_id" id="mod_id">
                </div>
              </div>
                
			  <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
				<div class="col-sm-8">
				  <input type="text"  class="form-control upperCase" id="mod_nombre" name="mod_nombre"  required>
				</div>
			  </div>
                
                <div class="form-group">
				<label for="mod_apellido" class="col-sm-3 control-label">Apellido</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control upperCase" id="mod_apellido" name="mod_apellido"  required>
				</div>
			  </div>
                
			   <div class="form-group">
				<label for="mod_licencia" class="col-sm-3 control-label">Razón social</label>
				<div class="col-sm-8 ajax_razon_social">
                    <input type="text" class="form-control" id="mod_razon_social" name="razon_social" disabled required>
                    <!--<select class="form-control" id="razon_social" name="razon_social">
                    </select>-->
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_fecha_ingreso" class="col-sm-3 control-label">Fecha Ingreso</label>
				<div class="col-sm-8">
				 <input type="date" class="form-control" id="mod_fecha_ingreso" name="mod_fecha_ingreso">
				</div>
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
	<?php
		}
	?>