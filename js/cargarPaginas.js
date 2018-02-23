
function abrirPestanas() {
        window.open("https://consulta.simit.org.co/Simit/verificar/contenido_verificar_pago_linea.jsp","ventana1");
        window.open("https://www.runt.com.co/consultaCiudadana/#/consultaPersona","ventana2");
        window.open("https://www.procuraduria.gov.co/CertWEB/Certificado.aspx?tpo=2","ventana3");
        window.open("http://cfiscal.contraloria.gov.co/siborinternet/certificados/certificadosPersonaNatural.asp","ventana4");
    return false;
}

fileList = new Array();
$("#fm-dropzone").dropzone({
  url: 'transporte.com.co', 
  addRemoveLinks: true, 
  dictRemoveFileConfirmation: "Está seguro que quieres eliminar este archivo?",     
  success: function(file, serverFileName) {
             fileList[file.name] = {"fid" : serverFileName };
           },
  removedfile: function(file) {
    
            /*$.post(siteurl + "/removeFile", fid:fileList[file.name].fid}).done(function() {
                    file.previewElement.remove();
                }); */
           }
});