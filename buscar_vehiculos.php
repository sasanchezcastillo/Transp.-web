<?php

	/*-------------------------
	Autor: Obed Alvarado
	Web: obedalvarado.pw
	Mail: info@obedalvarado.pw
    DavidCasadiegos.worker1 
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_vehiculo=$_GET['id'];
        $sql = "select * from vehiculos where placa_vehiculo='".$id_vehiculo."'";
		$query=mysqli_query($con, $sql);
		$count=mysqli_num_rows($query);
		if ($count==1){
            $sqlDelete = "DELETE FROM vehiculos WHERE placa_vehiculo='".$id_vehiculo."'";
            error_log($sqlDelete);
			if ($delete1=mysqli_query($con, $sqlDelete)){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  vehículo. Existen cargues vinculados a éste vehículo. 
			</div>
			<?php
		}
				
	}
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('placa_vehiculo');//Columnas de busqueda
		 $sTable = "vehiculos";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by placa_vehiculo desc";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './vehiculos.php';
		//main query to fetch the data
		$sql="SELECT placa_vehiculo, placa_remolque, cantidad_vehiculo,soat_vehiculo,tecnicomecanico_vehiculo,observaciones_vehiculo, fecha_creacion_vehiculo,TIMESTAMPDIFF(YEAR, soat_vehiculo, CURDATE()) as estado_soat,TIMESTAMPDIFF(YEAR, tecnicomecanico_vehiculo, CURDATE()) as estado_tecnicomecanico FROM  $sTable $sWhere";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table" >
				<tr  class="success text-center">
					<th class="text-center">Placa Vehículo</th>
					<th class="text-center">Placa Remolque</th>
					<th class="text-center">Capacidad</th>
                    <th class="text-center">SOAT</th>
                    <th class="text-center">Tecnicomecánico</th>
                    <th class="text-center">observaciones</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$placa_vehiculo=$row['placa_vehiculo'];
                        $placa_remolque=$row['placa_remolque'];
                        $cantidad_vehiculo=$row['cantidad_vehiculo'];
                        $soat_vehiculo=$row['soat_vehiculo'];
                        $tecnicomecanico_vehiculo=$row['tecnicomecanico_vehiculo'];
                        $observaciones_vehiculo=$row['observaciones_vehiculo'];
                       
                        $estado_soat=$row['estado_soat'];
                        $estado_tecnicomecanico=$row['estado_tecnicomecanico'];
					?>
					
					<input type="hidden" value="<?php echo $placa_vehiculo;?>" id="placa_vehiculo<?php echo $placa_vehiculo;?>">
                    <input type="hidden" value="<?php echo $placa_remolque;?>" id="placa_remolque<?php echo $placa_vehiculo;?>">
                    <input type="hidden" value="<?php echo $cantidad_vehiculo;?>" id="cantidad_vehiculo<?php echo $placa_vehiculo;?>">
                    <input type="hidden" value="<?php echo $soat_vehiculo;?>" id="soat_vehiculo<?php echo $placa_vehiculo;?>">
                    <input type="hidden" value="<?php echo $tecnicomecanico_vehiculo;?>" id="tecnicomecanico_vehiculo<?php echo $placa_vehiculo;?>">
                    <input type="hidden" value="<?php echo $observaciones_vehiculo;?>" id="observaciones_vehiculo<?php echo $placa_vehiculo;?>">
                  
					<input type="hidden" value="<?php echo $placa_vehiculo;?>" id="mod_id">
					<tr class="<?php  $class; ?> text-center" >
						<td><?php echo $placa_vehiculo; ?></td>
                        <td><?php echo $placa_remolque; ?></td>
                        <td><?php echo $cantidad_vehiculo; ?> Kg</td>
                        <td><?php 
                    if(intval($estado_soat)>=1){
                        ?><span class="label label-danger" title="Este vehículo tiene el SOAT vencido"><?php echo $soat_vehiculo;?></span>       
                        <?php
                    }else{
                        echo $soat_vehiculo;    
                    }
                    ?>
                    </td>
                    <td>
                    <?php        
                    if(intval($estado_tecnicomecanico)>=1){
                        ?><span class="label label-danger" title="Este vehículo tiene el Tecnicomecánico vencido"><?php echo $tecnicomecanico_vehiculo;?></span>       
                        <?php
                    }else{
                        echo $tecnicomecanico_vehiculo;    
                    }
                    ?></td>
                        <td ><?php echo $observaciones_vehiculo; ?></td>
					<td ><span class="pull-right">
					<a href="#" class='btn btn-default' title='Editar vehículo' onclick="obtener_datos('<?php echo $placa_vehiculo;?>');" data-toggle="modal" data-target="#myModal2"><i class="glyphicon glyphicon-edit"></i></a> 
					<a href="#" class='btn btn-default' title='Eliminar vehículo' onclick="eliminar('<?php echo $placa_vehiculo; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td>
						
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=6><span class="pull-right"><?
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>