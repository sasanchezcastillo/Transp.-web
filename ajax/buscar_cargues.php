<?php

	/*-------------------------
	Autor: David Casadiegos
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
         $estado =  mysqli_real_escape_string($con,(strip_tags($_REQUEST['estado'], ENT_QUOTES)));
        
        $where_like_estado = "";
        
        if($estado == "Registrado"){
            $where_like_estado = "0";
        }else if($estado == "Verificado"){
            $where_like_estado = "1";
        }else if($estado == "Despachado"){
            $where_like_estado = "2";
        }else if($estado == "No Aprobado"){
            $where_like_estado = "3";
        }else if($estado == "En Despacho"){
            $where_like_estado = "4";
        }else{
            $where_like_estado = "%%";
        }
        
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:3;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		//$row= mysqli_fetch_array($count_query);
		$numrows = "11";
		$total_pages = ceil($numrows/$per_page);
		$reload = './cargues.php';
		//main query to fetch the data
        $sql="SELECT estados_cargues.estado_cargue ,estados_cargues.fecha_hora_cargue , factura_despacho.id_factura_despacho, factura_despacho.tipo_documento, conductores.nombre_conductor , conductores.apellido_conductor ,conductores.cedula_conductor ,vehiculos.placa_vehiculo
from cargues 
join estados_cargues on estados_cargues.consecutivo_cargue = cargues.consecutivo_cargue
join factura_despacho on factura_despacho.consecutivo_cargue = cargues.consecutivo_cargue
join conductores_vehiculos on conductores_vehiculos.id_conductor_vehiculo = cargues.id_conductor_vehiculo
join conductores  on conductores.cedula_conductor = conductores_vehiculos.cedula_conductor
join vehiculos on vehiculos.placa_vehiculo = conductores_vehiculos.placa_vehiculo
where estados_cargues.estado_cargue LIKE '".$where_like_estado."' 
and factura_despacho.id_factura_despacho LIKE '%".$q."%'
xor conductores.cedula_conductor LIKE '%".$q."%'
xor vehiculos.placa_vehiculo LIKE '%".$q."%'
order by estados_cargues.fecha_hora_cargue desc";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
					<th class="text-center"># Factura</th>
					<th class="text-center">Cédula</th>
                    <th class="text-center">Nombre Completo</th>
                    <th class="text-center">Placa</th>
					<th class="text-center">Estado</th>
                    <th class="text-center">Factura-Despacho</th>
                    <th class="text-center">Modificación</th>
					<th class="text-center">Consultar</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
                    
        
						$id_factura_despacho=$row['id_factura_despacho'];
						
                        $cedula_conductor=$row['cedula_conductor'];
                    
                        $nombre_completo_conductor=$row['nombre_conductor']." ".$row['apellido_conductor'];
						$placa_vehiculo=$row['placa_vehiculo'];
					
                    $estado_cargue=$row['estado_cargue'];
                    $tipo_documento=$row['tipo_documento'];
                    
                    $fecha_hora_cargue=date("d/m/Y H:m:s", strtotime($row['fecha_hora_cargue']));
						
					?>
					<tr>
						<td class="text-center"><?php echo $id_factura_despacho; ?></td>
						<td class="text-center"><?php echo $cedula_conductor; ?></td>
						<td class="text-center"><?php echo $nombre_completo_conductor; ?></td>
                        <td class="text-center"><?php echo $placa_vehiculo; ?></td>
                        <td class="text-center">
                            <?php 
                                if($estado_cargue == "0") echo 'Registrado';
                                else if($estado_cargue == "1") echo 'Verificado';
                                else if($estado_cargue == "2") echo 'Despachado';
                                else if($estado_cargue == "3") echo 'No Aprobado';
                                else if($estado_cargue == "4") echo 'En Despacho';
                            ?>
                        </td>
                        <td  class="text-center"> <?php 
                            if($tipo_documento ==='Despacho'){
                                ?><span style="cursor: pointer;"onclick="pushDatos('<?php echo $id_factura_despacho;?>');"data-toggle="modal" data-target="#myModalFactura"class="label label-danger" title="Actualize a Factura"><?php
                                    echo $tipo_documento; ?></span>
                            <?php
                            }else{
                                echo $tipo_documento;
                        }
                            ?>
                        
                       
                    </td>
                    
                            
                        <td class="text-center"><?php echo $fecha_hora_cargue; ?></td>
                        <td class="text-center"><a href="#" class='btn btn-default' title='Descargar PDF' onclick="imprimir_factura();"><i class="glyphicon glyphicon-download"></i></a> </td>
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