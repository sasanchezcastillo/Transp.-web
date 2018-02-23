<?php

	/*-------------------------
	Autor: David Casadiegos
	---------------------------*/
	include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';

    if (isset($_POST['cedula']) && isset($_POST['placa'])){
            
            if(!empty($_POST['cedula'])){
                if(!empty($_POST['placa'])){
                    $cedula_conductor = mysqli_real_escape_string($con,(strip_tags($_POST['cedula'], ENT_QUOTES)));
                    $placa_vehiculo = mysqli_real_escape_string($con,(strip_tags($_POST['placa'], ENT_QUOTES)));

                    $query=mysqli_query($con, "select * from conductores where cedula_conductor ='".$cedula_conductor."'");
                    $rw_user=mysqli_fetch_array($query);
                    $count=$count=mysqli_num_rows($query);
                    if ($count>=1){
                        $query=mysqli_query($con, "select * from vehiculos where placa_vehiculo ='".$placa_vehiculo."'");
                        $rw_user=mysqli_fetch_array($query);
                        $count=$count=mysqli_num_rows($query);

                        if ($count>=1){

                            $query=mysqli_query($con, "select * from conductores_vehiculos where cedula_conductor ='".$cedula_conductor."' and placa_vehiculo ='".$placa_vehiculo."'");
                            $rw_user=mysqli_fetch_array($query);
                            $count=$count=mysqli_num_rows($query);
                            if ($count==0){

                                if ($delete1=mysqli_query($con,"INSERT INTO conductores_vehiculos(cedula_conductor, placa_vehiculo) values ('$cedula_conductor','$placa_vehiculo')")){
                                    ?>
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <strong>Aviso!</strong> Se ha vinculado en vehículo exitosamente.
                                    </div>
                                    <?php 
                                }else {
                                    ?>
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                      <strong>Error!</strong> No se ha podido vincular el vehiculo
                                    </div>
                                    <?php
                                }
                            } else {
                            ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <strong>Error!</strong> Este vehículo ya se encuentra vinculado 
                            </div>
                            <?php
                        }
                        } else {
                            ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <strong>Error!</strong> La placa no se encuentra registrada 
                            </div>
                            <?php
                        }

                    } else {
                        ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <strong>Error!</strong> La cédula no se encuentra registrada 
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <strong>Error!</strong> Por favor, digita una placa 
                    </div>
                    <?php
                }
            }else {
                ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong>Error!</strong> La cédula se encuentra vacía 
                </div>
                <?php
            }
        }else{
        error_log("------cedula y placa vacios");
    }

    if($action == 'delete'){
        if (isset($_POST['cedula']) && isset($_POST['placa'])){
            
            
        }
    }

	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
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
		$reload = './registrar_cargues.php';
		//main query to fetch the data
		$sql="select con_vehi.id_conductor_vehiculo, vehi.*,TIMESTAMPDIFF(YEAR, soat_vehiculo, CURDATE()) as estado_soat,TIMESTAMPDIFF(YEAR, tecnicomecanico_vehiculo, CURDATE()) as estado_tecnicomecanico from vehiculos vehi join conductores_vehiculos con_vehi on vehi.placa_vehiculo=con_vehi.placa_vehiculo where con_vehi.cedula_conductor= '".$_GET['cedula']."' order by placa_vehiculo";
		$query = mysqli_query($con, $sql);
        $filas = $query->num_rows;
		//loop through fetched data
		if ($numrows>0){
			echo mysqli_error($con);
			?>
			<div class="table-responsive">
			  <table class="table table-hover">
				<thead>
                    <tr class="">
                        <th class="text-center">Placa Vehículo</th>
                        <th class="text-center">Placa Remolque</th>
                        <th class="text-center">Capacidad (Kg)</th>
                        <th class="text-center">SOAT</th>
                        <th class="text-center">Tecnicomecánico</th>
                        <th class="text-center">Observaciones</th>
                    </tr>
                </thead>
              <input type="hidden" id="placa_vehiculo_tabla" name="placa_vehiculo_tabla" value=""> <!--boton para acumular la cédula al seleccionar desde el js para realizar el registro-->
                <tbody>
				<?php
                $acumulador = 0;
				while ($row=mysqli_fetch_array($query)){
                    $acumulador += 1;
					$placa_vehiculo = $row['placa_vehiculo'];
                    $placa_remolque = $row['placa_remolque'];
                    $capacidad_vehiculo = $row['cantidad_vehiculo'];
                    $soat_vehiculo = $row['soat_vehiculo'];
                    $tecnicomecanico_vehiculo = $row['tecnicomecanico_vehiculo'];
                    $observaciones_vehiculo = $row['observaciones_vehiculo'];
                    $estado_soat=$row['estado_soat'];
                    $estado_tecnicomecanico=$row['estado_tecnicomecanico'];

                    ?>
                    <tr class="" style="cursor:pointer;" id="tr<?php echo $acumulador; ?>" onclick="seleccionarFilaVehiculos('tr<?php echo $acumulador; ?>',<?php echo $filas?>,'<?php echo $placa_vehiculo; ?>');">
                        <td class="text-center"><?php echo $placa_vehiculo ?></td>
                        <td class="text-center"><?php echo $placa_remolque ?></td>
                        <td class="text-center"><?php echo $capacidad_vehiculo ?></td>
                        <td class="text-center">
                            <?php 
                                if(intval($estado_soat)>=1){
                                    ?><span class="label label-danger" title="Este vehículo tiene el SOAT vencido"><?php echo $soat_vehiculo;?></span>       
                                    <?php
                                }else{
                                    echo $soat_vehiculo;    
                                }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php        
                            if(intval($estado_tecnicomecanico)>=1){
                                ?><span class="label label-danger" title="Este vehículo tiene el Tecnicomecánico vencido"><?php echo $tecnicomecanico_vehiculo;?></span>       
                                <?php
                            }else{
                                echo $tecnicomecanico_vehiculo;    
                            }
                            ?>
                        </td>
                        <td class="text-center"><?php echo $observaciones_vehiculo ?></td>
                    </tr>
					<?php
				}
				?>
                  </tbody>
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