$(document).ready(function(){
    loadVehiculosCargues(1);

});

let placa_vehiculo_seleccionada;
let idTRGlobal;

function seleccionarFilaVehiculos(idTR,acumulador,placa){
    
    idTRGlobal = idTR;
    placa_vehiculo_seleccionada = placa;
    for (let i = 1; i <= acumulador; i++ ){
        var elemento = document.getElementById('tr'+i);
        elemento.className -= " success";
    }
    var elemento = document.getElementById(idTR);
    elemento.className += " success";
    document.getElementById('placa_vehiculo_tabla').innerHTML = placa;
    
    
}

function loadVehiculosCargues(page){
        let valor_cedula = document.getElementById('valor_cedula_conductores_vehiculos').value;
        $("#loader").fadeIn('slow');
        $.ajax({
            url:'./ajax/buscar_conductores_vehiculos.php?action=ajax&page='+page+'&cedula='+valor_cedula,
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


$( "#formulario_vinculacion_cargue" ).submit(function( event ) {
  $('#guardar_cargue').attr("disabled", true);
  
    var accion = confirm('¿Realmente deseas vincular este vehículo?, esta acción no se podrá revertir.');
    if(accion){
     var parametros = $(this).serialize();
         $.ajax({
                type: "POST",
                url: "ajax/buscar_conductores_vehiculos.php",
                data: parametros,
                 beforeSend: function(objeto){
                    $("#resultados").html("Mensaje: Cargando...");
                  },
                success: function(datos){
                $("#resultados").html(datos);
                $('#guardar_cargue').attr("disabled", false);
                loadVehiculosCargues(1);
              }
        });
      event.preventDefault();
    }
})

$("#btn_registrar_cargue1").click(function(){
    upload_document();
})

$("#btn_registrar_cargue2").click(function(){
    upload_document();
})
 

function upload_document(){//Funcion encargada de enviar el archivo via AJAX
   
    var data = new FormData();
    for(var i = 0; i <= contadorFilas; i++){
        
        if($("#destino_cargue").val() !=''){
            let destino = document.getElementById("destino_cargue").value;
            data.append('destino',destino);
        }else{
            alert('El destino del cargue se encuentra vacío');
            return;
        }
        
        if($("#cedula").val() !=''){
            let cedula = document.getElementById("cedula").value;
            data.append('cedula',cedula);
        }else{
            alert('La cédula se encuentra vacía');
            return;
        }
        
        if(typeof placa_vehiculo_seleccionada === 'undefined'){
            alert('No has seleccionado una placa');
            return;
        }else{
            data.append('placa',placa_vehiculo_seleccionada);
        }
        
        if($("#id_factura"+i).val() !=''){
            let id_factura = document.getElementById("id_factura"+i).value;
            data.append('id_factura'+i,id_factura);
        }else{
            alert('No has digitado el número de factura en la fila '+(i+1));
            return;
        }
        
        
        if($("#adjunto"+i).val() !=''){
            var inputFileImage = document.getElementById("adjunto"+i);
            var file = inputFileImage.files[0];
            data.append('adjunto'+i,file);
        }else{
            alert('No has seleccionado un archivo en la fila '+(i+1));
            return;
        }
           
        
       var valorChecked = $("input:radio[name=check_factura"+i+"]:checked").val() 
        if(valorChecked === "Factura"){
            data.append('checked_factura'+i,"Factura");
        }else if(valorChecked === "Despacho"){
            data.append('checked_factura'+i,"Despacho");
        }else{
            alert("El tipo de cargue debe ser 'Factura' o 'Despacho', por favor no modifiques estos valores");
            return;
        }
        
        
        
    }
    
    $.ajax({
        url: "ajax/registrar_documentos_cargue.php?cantidad="+contadorFilas,        // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        beforeSend: function(){
        $("#resultado_registro_cargue").html("Mensaje: Cargando...");
        $('#btn_registrar_cargue1').attr("disabled", true);
        $('#btn_registrar_cargue2').attr("disabled", true);

        },
        success: function(datos){
                $("#resultado_registro_cargue").html(datos);
                $('#btn_registrar_cargue1').attr("disabled", false);
                $('#btn_registrar_cargue2').attr("disabled", false);
               // if(idTRGlobal != null && idTRGlobal != ""){
                //    seleccionarFilaVehiculos(idTRGlobal);
               // }
              }
        /*success: function(data)   // A function to be called if request succeeds
        {
           $("#resultado_registro_cargue").html(data);
        }*/
    });
    
}


