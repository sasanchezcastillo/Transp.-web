<?php

	/*-------------------------
	Autor: David Casadiegos
	Mail: david.2818@outlook.com
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

	if (isset($_GET['id'])){
		$id_conductor=$_GET['id'];
		$query=mysqli_query($con, "select * from conductores where cedula_conductor='".$id_conductor."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
             
			if ($delete1=mysqli_query($con,"DELETE FROM conductores WHERE cedula_conductor='".$id_conductor."'")){
           
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
			  <strong>Error!</strong> No se pudo eliminar éste  conductor porque tiene cargues registrados o vehículos vinculados. 
			</div>
			<?php
		}
	}

	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('con.cedula_conductor');//Columnas de busqueda
		 $sTable = "conductores con join razon_social razo on con.id_razon_social = razo.id_razon_social";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
            $sWhere .= " concat(con.nombre_conductor, ' ', con.apellido_conductor) like '%".$q."%' OR";
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by con.nombre_conductor";
        
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './clientes.php';
		//main query to fetch the data
		$sql="SELECT con.*, razo.nombre_razon_social FROM  $sTable $sWhere";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="success">
					<th class="text-center"># Cedula</th>
					<th class="text-center">Nombre Completo</th>
					<th class="text-center">Razón Social</th>
					<th class="text-center">Fecha Ingreso</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$cedula_conductor=$row['cedula_conductor'];
						
                    $nombre_conductor = $row['nombre_conductor'];
                        $apellido_conductor = $row['apellido_conductor'];
                        $nombre_completo_conductor=$row['nombre_conductor'].' '.$row['apellido_conductor'];
						$nombre_razon_social=$row['nombre_razon_social'];
                        $fecha_ingreso_conductor=date("d/m/Y", strtotime($row['fecha_ingreso_conductor']));
						/*tatus_cliente=$row['status_cliente'];
						if ($status_cliente==1){$estado="Activo";}
						else {$estado="Inactivo";}*/
						
					?>
					
					<input type="hidden" value="<?php echo $cedula_conductor;?>" id="cedula_conductor<?php echo $cedula_conductor;?>">
					<input type="hidden" value="<?php echo $nombre_conductor;?>" id="nombre_conductor<?php echo $cedula_conductor;?>">
                    <input type="hidden" value="<?php echo $apellido_conductor;?>" id="apellido_conductor<?php echo $cedula_conductor;?>">
					<input type="hidden" value="<?php echo $nombre_razon_social;?>" id="nombre_razon_social<?php echo $cedula_conductor;?>">
					<input type="hidden" value="<?php echo $fecha_ingreso_conductor;?>" id="fecha_ingreso_conductor<?php echo $cedula_conductor;?>">
					<tr>
						
						<td class="text-center"><?php echo $cedula_conductor; ?></td>
						<td class="text-center"><?php echo $nombre_completo_conductor; ?></td>
						<td class="text-center"><?php echo $nombre_razon_social;?></td>
						<td class="text-center"><?php echo $fecha_ingreso_conductor;?></td>
						
					<td>
                        <span class="pull-right">
                        <a href="../registrar_cargue.php?cedula=<?php echo $cedula_conductor?>" class='btn btn-warning' title='Asignar cargue'>
                            <i class="glyphicon glyphicon-plus"></i> Cargues
                        </a> 
                        <a href="#" class='btn btn-default' title='Editar cliente' onclick="obtener_datos('<?php echo $cedula_conductor;?>');" data-toggle="modal" data-target="#myModal2">
                            <i class="glyphicon glyphicon-edit"></i>
                        </a> 
                        <!--<a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $cedula_conductor; ?>')">
                            <i class="glyphicon glyphicon-trash"></i> 
                        </a>-->
                        </span>
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