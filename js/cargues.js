		$(document).ready(function(){
			load(1);
			
		});

		function load(page){
			var q= $("#q").val();
            var estado= $("#estado_cargues").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/buscar_cargues.php?action=ajax&page='+page+'&q='+q+'&estado='+estado,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					$('[data-toggle="tooltip"]').tooltip({html:true}); 
					
				}
			})
		}

	
		
function eliminar (id){
    var q= $("#q").val();
    if (confirm("Realmente deseas eliminar la factura")){	
        $.ajax({
            type: "GET",
            url: "./ajax/buscar_cargues.php",
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

function pushDatos(id){
            //load_razon_social('editar');
			var despacho = $("#despacho"+id).val();
            $("#id_despacho").val(id);
            //$("#").val();
            $('h4.myModalLabel').text('Despacho: '+id);
    
			//var newFactura = $("#apellido_conductor"+id).val();
			//var razon_social = $("#nombre_razon_social"+id).val();
			//var fecha_ingreso_conductor_str = $("#fecha_ingreso_conductor"+id).val();
            //var parts = fecha_ingreso_conductor_str.split('/');
        
            //var mydate = new Date(parts[2],parts[0]-1,parts[1]);
			//$("#mod_nombre").val(nombre_conductor);
			//$("#mod_apellido").val(apellido_conductor);
            //document.getElementById("razon_social").value = 'COAGRONORTE';
			//$("#mod_razon_social").val(razon_social);
            
			//$("#mod_fecha_ingreso").val(parts[2]+'-'+parts[1]+'-'+parts[0])
		
}
function updateDespacho(despacho,url_documento){
    
    
}

$( "#editar_factura_despacho" ).submit(function( event ) {
    updateDespacho();
})


function updateDespacho(){//Funcion encargada de enviar el archivo via AJAX
   
    var data = new FormData();
    
    if($("#id_despacho").val() !=''){
            let despacho = document.getElementById("id_despacho").value;
            data.append('id_despacho',despacho);
    }else{
            alert('El despacho se  encuentra vacío');
            return;
        }
        if($("#id_factura").val() !=''){
            let factura = document.getElementById("id_factura").value;
            data.append('id_factura',factura);
        }else{
            alert('El destino del cargue se encuentra vacío');
            return;
        }
        if($("#adjunto").val() !=''){
            var inputFileImage = document.getElementById("adjunto");
            //var file = inputFileImage.files[0];
            data.append('adjunto',inputFileImage);
        }else{
            alert('No has seleccionado un archivo en la fila ');//
            return;// 
        }
    $.ajax({
        url: "ajax/editarDespacho.php",        // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        beforeSend: function(){
       // $("#donde está la ventana modal ?").html("Mensaje: Cargando...");
        //$('#btn_registrar_cargue2').attr("disabled", true);
        },
        success: function(datos){
                $("#resultados").html(datos);
        
                //$('#btn_registrar_cargue2').attr("disabled", false);
               // if(idTRGlobal != null && idTRGlobal != ""){
                //    seleccionarFilaVehiculos(idTRGlobal);
               // }
              }
    });
    
}

		
function imprimir_factura(id_factura){
    VentanaCentrada('./pdf/documentos/ver_factura.php?id_factura='+id_factura,'Factura','','1024','768','true');
}

function seleccion_estado(){
    load(1);
}


