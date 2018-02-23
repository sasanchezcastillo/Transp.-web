	<?php
        if(isset($_SESSION['user_tipoUsuario'])){
            $tipoUsuarioSession = $_SESSION['user_tipoUsuario'];
        }

		if (isset($title))
		{
            
	?>
          <style>
              .img-navbar{
                  padding:0px; 
                  width:20px;
                  margin: 0 auto;
              }
          </style>
<nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="cargues.php">Coagrotransporte</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse warning" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
          
        
        
        <?php    
            if(isset($tipoUsuarioSession) && $tipoUsuarioSession == "Administrador")
            { 
          ?>
          <li class="<?php echo $active_cargues;?>"><a href="cargues.php"><img class="img-navbar" src="img/icons8_Fork_Lift_96px.png"/> Cargues</a></li>
          
        <li class="<?php echo $active_conductores;?>"><a href="conductores.php"><img class="img-navbar" src="img/icons8_Driver_96px_1.png"/> Conductores</a></li>
          
          <li class="<?php echo $active_vehiculos;?>"><a href="vehiculos.php"><img class="img-navbar" src="img/icons8_Semi_Truck_96px.png"/> Vehículos</a></li>
          
        <li class="<?php echo $active_verificar;?>"><a href="verificar.php"><img class="img-navbar" src="img/icons8_Check_File_96px.png"/> Verificar<span class="sr-only">(current)</span></a></li>
                    
		<li class="<?php echo $active_usuarios;?>"><a href="usuarios.php"><img class="img-navbar" src="img/icons8_User_Account_96px.png"/> Usuarios</a></li>
            <?php
            }else{
            ?>
        <li class="<?php echo $active_verificar;?>"><a href="verificar.php"><img class="img-navbar" src="img/icons8_Check_File_96px.png"/> Verificar<span class="sr-only">(current)</span></a></li>
          <?php
          }      
          ?>
       </ul>
      <ul class="nav navbar-nav navbar-right">
        <!--<li><a href="#" target='_blank'><i class='glyphicon glyphicon-envelope'></i> Soporte</a></li>-->
		<li><a href="login?logout"><img class="img-navbar" src="img/icons8_Exit_96px_1.png"/> Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
	<?php
		}
	?>