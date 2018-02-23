$(document).ready(function(){
    load(1);
});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_vehiculos.php?action=ajax&page='+page+'&q='+q,
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
    if (confirm("Realmente deseas eliminar el vehículo")){	
        $.ajax({
            type: "GET",
            url: "./ajax/buscar_vehiculos.php",
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

$("#nuevoProducto").on('hidden.bs.modal', function(){
    limpiar_campos();
});

function limpiar_campos(){
    document.getElementById("guardar_producto").reset();
}

$("#myModal2").on('hidden.bs.modal', function(){
    document.getElementById("resultados_ajax2").innerHTML = "";
});
		

		
		
		

