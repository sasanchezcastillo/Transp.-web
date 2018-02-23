 <?php

	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$numero_factura=intval($_GET['id']);
		$del1="delete from facturas where numero_factura='".$numero_factura."'";
		$del2="delete from detalle_factura where numero_factura='".$numero_factura."'";
		if ($delete1=mysqli_query($con,$del1) and $delete2=mysqli_query($con,$del2)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se puedo eliminar los datos
			</div>
			<?php
			
		}
	}

	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		  $sTable = " conductores
          join conductores_vehiculos on conductores.cedula_conductor = conductores_vehiculos.cedula_conductor
          join cargues on cargues.id_conductor_vehiculo = conductores_vehiculos.id_conductor_vehiculo 
          join estados_cargues on estados_cargues.consecutivo_cargue = cargues.consecutivo_cargue ";
		 $sWhere = "";
       
		
		$sWhere.= " where estados_cargues.estado_cargue like '0' 
                    AND conductores.cedula_conductor like '%".$q."%' ";
		
        
		$sWhere.=" order by estados_cargues.fecha_hora_cargue desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:3;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(conductores.cedula_conductor) as numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './verificar.php';
		//main query to fetch the data
		$sql="SELECT cargues.consecutivo_cargue, conductores.*,conductores_vehiculos.placa_vehiculo FROM $sTable $sWhere";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
                    <th class="text-center"># consecutivo</th>
					<th class="text-center">Cédula</th>
					<th class="text-center">Transportador</th>
                    <!--<th class="text-center">Razón Social</th>-->
                    <th class="text-center">Fecha Ingreso</th>
					<th class="text-center">Placa Vehículo</th>
					<th class="text-center">Consultar</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
                        $consecutivo_cargue=$row['consecutivo_cargue'];
						$cedula_conductor=$row['cedula_conductor'];
						$nombre_conductor=$row['nombre_conductor']." ".$row['apellido_conductor'];
						$licencia_conductor=$row['licencia_conductor'];
						$fecha_ingreso_conductor=date("d/m/Y", strtotime($row['fecha_ingreso_conductor']));
						$placa_conductor=$row['placa_vehiculo'];
                    
						/*if ($estado_factura==1){$text_estado="Pagada";$label_class='label-success';}
						else{$text_estado="Pendiente";$label_class='label-warning';}
						$total_venta=$row['total_venta'];*/
					?>
					<tr>
                        <td class="text-center"><?php echo $consecutivo_cargue; ?></td>
						<td class="text-center"><?php echo $cedula_conductor; ?></td>
						<td class="text-center"><?php echo $nombre_conductor; ?></td>
						<!--<td class="text-center"><?php echo $licencia_conductor; ?></td>-->
                        <td class="text-center"><?php echo $fecha_ingreso_conductor; ?></td>
                        <td class="text-center"><?php echo $placa_conductor; ?></td>
                        
                        <!--<td><a href="#" data-toggle="tooltip" data-placement="top" title="<i class='glyphicon glyphicon-phone'></i> <?php /*echo $telefono_cliente;*/?> <br><i class='glyphicon glyphicon-envelope'></i>  <?php /*echo $email_cliente;*/?>" ><?php /*echo $nombre_cliente;*/?></a></td>-->
						
						<!--<td><span class="label <?php /*echo $label_class;*/?>"><?php /*echo $text_estado; */?></span></td>-->
						<!--<td class='text-right'><?php /*echo number_format ($total_venta,2); */?></td>-->					
					<td class="text-center">
                        <button type="button" class="btn btn-warning" onclick="abrirPestanas();asigarCedulaIdFacturaCampo('<?php echo $cedula_conductor ?>','<?php echo $consecutivo_cargue?>');" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-search" ></span></button>
					</td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right"><?
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>