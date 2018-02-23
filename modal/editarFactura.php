	<?php
		if (isset($con))
		{
	?>
	<!-- Modal -->
	<div class="modal fade" id="myModalFactura" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
			<form class="form-horizontal" method="post" id="editar_factura_despacho" name="editar_factura_despacho" enctype="multipart/form-data">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title myModalLabel"><i class='glyphicon glyphicon-edit'></i></h4>
              <input type="hidden" id="id_despacho" value="">
		  </div>
		  <div class="modal-body">
			<div id="resultados_ajax2">
            </div>
                <div class="form-group">
				<label for="mod_cedula" class="col-sm-3 control-label">#Factura</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control " id="id_factura" name="id_factura" required>
                    <input type="hidden" name="mod_id2" id="mod_id2">
                </div>
              </div>
			  <div class="form-group">
				<label for="mod_nombre" class="col-sm-3 control-label">Documento</label>
				<div class="col-sm-8">
				  <input type="file" required class="upperCase" id="adjunto" name="adjunto"  >
				</div>
                </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-warning" id="actualizar_datos2">Actualizar datos</button>
		  </div>
		  </form>
		</div>
	  </div>
	</div>

	<?php
		}
	?>