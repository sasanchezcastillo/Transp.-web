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
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar usuario</h4>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="editar_usuario" name="editar_usuario">
                <div id="resultados_ajax2"></div>
                  <div class="form-group">
                    <label for="user_name2" class="col-sm-3 control-label">Usuario</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="user_name2" name="user_name2" placeholder="Usuario" pattern="[a-zA-Z0-9]{2,64}" title="Nombre de usuario ( sólo letras y números, 2-64 caracteres)"required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="user_tipo_usuario2" class="col-sm-3 control-label">Tipo Usuario</label>
                    <div class="col-sm-8">
                        <select id="user_tipo_usuario2" name="user_tipo_usuario2" class="form-control">
                            <option>Usuario</option>
                            <option>Administrador</option>
                        </select>
                    </div>
                  </div>
                <input type="hidden" class="form-control" id="mod_id" name="mod_id" >
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