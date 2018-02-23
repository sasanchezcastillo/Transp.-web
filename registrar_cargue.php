<?php
	/*-------------------------
	Autor: David Casadiegos 
	Web: transporte.com.co
	---------------------------*/
	session_start();
	if (!isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] != 1) {
        header("location: login.php");
		exit;
        }
	$active_facturas="";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";
        
	$title="Registrar Cargue | Coagrotransporte";
	
	/* Connect To Database*/
	require_once ("config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("config/conexion.php");//Contiene funcion que conecta a la base de datos
	

		$campos="razo.nombre_razon_social, con.nombre_conductor, con.apellido_conductor";
		$sql_conductor=mysqli_query($con,"select $campos from conductores con join razon_social razo on con.id_razon_social = razo.id_razon_social  where con.cedula_conductor = '".$_GET['cedula']."'");
		$count=mysqli_num_rows($sql_conductor);
		if ($count==1)
		{
				$rw_conductor=mysqli_fetch_array($sql_conductor);
                $cedula_conductor=$_GET['cedula'];
				$nombre_conductor=$rw_conductor['nombre_conductor'];
				$apellido_conductor=$rw_conductor['apellido_conductor'];
                $nombre_completo_conductor=$nombre_conductor." ".$apellido_conductor;
				$razon_social=$rw_conductor['nombre_razon_social'];
				
		}	
		else
		{
			header("location: conductores.php");
			exit;	
		}
	 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("head.php");?>
  </head>
  <body>
	<?php
	include("navbar.php");
	?>  

          <script>
         
          let contadorFilas = 0;

          function agregarFilaTabla() {
              contadorFilas ++;
              var fila_nueva = "<br> <div class='col-sm-2  col-sm-offset-1 col-md-offset-1'>"+
                          "<input type='text' class='form-control input-sm' id='id_factura"+contadorFilas+"' name='id_factura"+contadorFilas+"' placeholder='Factura o Despacho'>"+
                   "</div>"+
                        "<div class='col-lg-4 col-sm-3 col-11'>"+
                            "<div class='form-group'>"+
                                "<input type='file' class='form-control-file' id='adjunto"+contadorFilas+"' name='adjunto"+contadorFilas+"' aria-describedby='fileHelp'>"+
                            "</div>"+
                        "</div>"+
                    "<div class='col-lg-4 col-5 col-sm-2'>"+
                      "<label style='cursor:pointer;  margin-right:5px;'>"+
                                 "<input type='radio' checked id='check_factura"+contadorFilas+"' name='check_factura"+contadorFilas+"' value='Factura'>  Factura"+
                      "</label>"+
                      "<label style='cursor:pointer;'>"+
                                 "<input type='radio' id='check_factura"+contadorFilas+"' name='check_factura"+contadorFilas+"' value='Despacho'> Despacho"+
                      "</label>"+
                    "</div><br>";
              
              $('#cont_factura').append(fila_nueva);
            
              
            }
          </script>

      <input type="hidden" id="valor_cedula_conductores_vehiculos" name="valor_cedula_conductores_vehiculos" value="<?php echo $_GET['cedula']?>"/>
      <form class="" role="form" id="datos_factura" method="post" >
    <div class="container">
         <div id="resultado_registro_cargue"></div><!-- Carga el resultado del registro -->
        <div class="form-group row">
        <div class="col-md-12">
            <button type="button" id="btn_registrar_cargue1" class="btn btn-warning pull-right" >
                <span class="glyphicon glyphicon-ok" ></span> Registrar Cargue</button>
        </div>
    </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <h4><img class="img-navbar" src="img/icons8_Bill_100px.png"/> Información Factura o Despacho</h4>
            </div>
            <div class="panel-body" role="toolbar">
                <div class="form-group row">
                    <label for="q" style="margin-top:5px;" class="col-md-1 control-label">Destino</label>
                                <div class="col-md-5">
                                    <input style="text-transform: uppercase;" type="text" class="form-control"  id="destino_cargue" name="destino_cargue" placeholder="Destino del cargue">
                                </div>
                </div>
                
                      <!--<label for="nombre_cliente" class="col-md-1 control-label">Número </label>-->
                    <input type="hidden" class="form-control"  id="cedula" name="cedula" value="<?php echo $_GET['cedula'] ?>">
                    <div class="form-inline" id="cont_factura">
                     <div class="col-sm-1">
                          <a data-toggle="modal" onclick="agregarFilaTabla()" style="cursor: pointer; color: black;"><img  class="img-icon" src="../img/icons8_Add_New_104px_1.png"/></a>
                     </div>
                    
                        <div class="col-sm-2">
                              <input type="text" class="form-control input-sm" id="id_factura0" name="id_factura0" placeholder="Factura o Despacho">
                        </div>
                        <div class="col-lg-4 col-sm-3 col-11">
                            <div class="form-group">
                                <input type="file" required class="form-control-file" id="adjunto0" name="adjunto0" aria-describedby="fileHelp">
                            </div>
                        </div>
                        <div class="col-lg-4 col-5 col-sm-2">
                            <label style="cursor:pointer;" >
                                <input type="radio" checked  id="check_factura0" name="check_factura0" value="Factura"> Factura
                            </label>
                            <label style="cursor:pointer;" >
                                <input type="radio" id="check_factura0" name="check_factura0" value="Despacho"> Despacho
                            </label>
                        </div>
                        <br>
                    </div>


            

           </div>	
            
            

        <div class="panel-heading">
                <h4><img class="img-navbar" src="img/icons8_Driver_96px_2.png"/> Información Conductor</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" id="datos_factura">
                    <div class="form-group row">
                        <div class="table-responsive">
                          <table class="table">
                              <tr  class="">
                                <th class="text-center"># Cédula</th>
                                <th class="text-center">Nombre Completo</th>
                                <th class="text-center">Razón Social</th>
                              </tr>
                              <input type="hidden" id="cedula_cliente" name="cedula_cliente" value="<?php echo $cedula_conductor;?>">
                              <tr>
                                  <td class="text-center"><?php echo $cedula_conductor ?></td>
                                  <td class="text-center"><?php echo $nombre_completo_conductor ?></td>
                                  <td class="text-center"><?php echo $razon_social ?></td>
                              </tr>
                            </table>
                        </div>
                     </div>
                </form>	
            </div>

             <div class="panel-heading">
                <h4><img class="img-navbar" src="img/icons8_Semi_Truck_100px.png"/> Información Vehículo</h4>
            </div>
            <div class="panel-body">
                    <div class="form-group row">

                        <p class="padding-10">Si no encuentra el vehículo en la tabla, digite el número de placa y de clic en vincular. Esta acción vinculará este vehículo con el conductor seleccionado, haciendo referencia a que este vehículo será conducido por el transportador detallado en la tabla anterior.</p>

                        <div class="form-group row">
                            <form class="form-horizontal" role="form" id="formulario_vinculacion_cargue">

                                <label for="q" class="col-md-1 control-label">Placa</label>
                                <div class="col-md-5">
                                    <input type="hidden" id="cedula" name="cedula" value="<?php echo $cedula_conductor;?>">
                                    <input type="text" class="form-control"  id="placa" name="placa" placeholder="Placa del vehículo">
                                </div>
                                <div class="col-md-5">
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-default"id="guardar_cargue" onclick=''>
                                        <span class="glyphicon glyphicon-resize-small" ></span> Vincular</button>
                                    <span id="loader"></span>
                                </div> 

                            </form>
                        </div>

                        <div id="resultados"></div><!-- Carga los datos ajax -->
                        <div class='outer_div'></div><!-- Carga los datos ajax --> 
                     </div>
           </div>
            <div class="col-md-12 padding-15">
                <button id="btn_registrar_cargue2" type="button" class="btn btn-warning pull-right" >
                    <span class="glyphicon glyphicon-ok" ></span> Registrar Cargue
                </button>
            </div>
        </div>
        <br><br>
        <br><br>
        <br><br>
        
    </div>
 </form>	
      
     
	<?php
	include("footer.php");
	?>
    <script type="text/javascript" src="js/carguesvehiculosconductores.js"></script>    
    <script type="text/javascript" src="js/VentanaCentrada.js"></script>
    <script type="text/javascript" src="js/inputFile.js"></script>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  </body>
</html>