    $(document).ready(function(){
        load(1);
        load_razon_social('registrar');
        $("#cedula").keypress(function(){
            soloNumeros($("#cedula").val());
	   });
    });

function load(page){
    var q= $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url:'./ajax/buscar_conductores.php?action=ajax&page='+page+'&q='+q,
         beforeSend: function(objeto){
         $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
      },
        success:function(data){
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');

        }
    })
}



function eliminar (id)
{
    var q= $("#q").val();
if (confirm("Realmente deseas eliminar el conductor")){	
$.ajax({
type: "GET",
url: "./ajax/buscar_conductores.php",
data: "id="+id,"q":q,
 beforeSend: function(objeto){
    $("#resultados").html("Mensaje: Cargando...");
  },
success: function(datos){
$("#resultados").html(datos);
load(1);
}
    });
}

}

$( "#guardar_cliente" ).submit(function( event ) {
  $('#guardar_datos_registro').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/nuevo_conductor.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos_registro').attr("disabled", false);
			load(1);
		  }
	});
  event.preventDefault();
})

$( "#editar_cliente" ).submit(function( event ) {
  $('#mod_razon_social').attr("disabled", false);
  $('#actualizar_datos').attr("disabled", true);
  
 var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/editar_conductor.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax2").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax2").html(datos);
			$('#actualizar_datos').attr("disabled", false);
            $('#mod_razon_social').attr("disabled", true);
			load(1);
		  }
	});
  event.preventDefault();
})

	function obtener_datos(id){
            //load_razon_social('editar');
			var nombre_conductor = $("#nombre_conductor"+id).val();
			var apellido_conductor = $("#apellido_conductor"+id).val();
			var razon_social = $("#nombre_razon_social"+id).val();
			var fecha_ingreso_conductor_str = $("#fecha_ingreso_conductor"+id).val();
            var parts = fecha_ingreso_conductor_str.split('/');
        
            var mydate = new Date(parts[2],parts[0]-1,parts[1]);
			$("#mod_nombre").val(nombre_conductor);
			$("#mod_apellido").val(apellido_conductor);
            //document.getElementById("razon_social").value = 'COAGRONORTE';
			$("#mod_razon_social").val(razon_social);
            
			$("#mod_fecha_ingreso").val(parts[2]+'-'+parts[1]+'-'+parts[0]);
			$("#mod_cedula").val(id);
            $("#mod_id").val(id);
		
		}
	
function soloNumeros(e) 
{ 
    var key = window.Event ? e.which : e.keyCode 
    return ((key >= 48 && key <= 57) || (key==8)) 
}
		
function load_razon_social(id){
    $("#loader").fadeIn('');
    $.ajax({
        type: "GET",
        url:'./ajax/registro_conductores/buscar_razon_social.php?action=ajax',
        success:function(data){
            $(".ajax_razon_social select").html(data).fadeIn('');
        }
    })
}

$( "#guardar_razon_social" ).submit(function( event ) {
    $('#guardar_datos_registro_razon').attr("disabled", true);
    var parametros = $(this).serialize();
	 $.ajax({
			type: "POST",
			url: "ajax/registro_conductores/registro_razon_social.php",
			data: parametros,
			 beforeSend: function(objeto){
				$("#resultados_ajax").html("Mensaje: Cargando...");
			  },
			success: function(datos){
			$("#resultados_ajax").html(datos);
			$('#guardar_datos_registro_razon').attr("disabled", false);
			$('#cerrar_modal_razon_social').click();    
            $("#nombre_razon_social").val('');
            $("#correo_razon_social").val('');
            $("#telefono_razon_social").val('');
            load_razon_social('registrar');
		  }
	});
  event.preventDefault();
});
        
$("#nuevoCliente").on('hidden.bs.modal', function () {
    limpiar_campos_registro();
});

$("#myModal2").on('hidden.bs.modal', function () {
    document.getElementById("resultados_ajax2").innerHTML = "";
});

//  limpia el formulario de la ventana modal razon social
$("#modalRazonSocial").on('hidden.bs.modal', function () {
    document.getElementById("guardar_razon_social").reset();
});

$("#modalRazonSocial").on('hidden.bs.modal', function () {
    //limpiar_campos_razon_social();
    document.getElementById("guardar_razon_social").reset();
});

function limpiar_campos_registro(){
    document.getElementById("guardar_cliente").reset();
}



