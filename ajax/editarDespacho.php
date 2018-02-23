<?php
/* Connect To Database*/
require_once ("../config/db.php");
require_once ("../config/conexion.php");
include('is_logged.php');
    if(!isset($_POST['id_despacho']) && empty($_POST['id_despacho'])){  
        $errors[] = "no existe el despacho ";
        
    }else if(!isset($_POST['id_factura']) && empty($_POST['id_factura'])){ 
        $errors[] = "Factura Vacia";  
    }else{  
                        $target_dir = "../facturas-despachos/";//ruta carpeta
                        $carpeta=$target_dir;
                            
                        $name_file = $_FILES["adjunto"]["name"];
                        $tmp_archivo = $_FILES['adjunto']['tmp_name'];
                        $url = "http://192.168.100.74/facturas-despachos/".$_POST['id_factura'].".html";//url para la bd
        
                        $archivo = $_POST['id_factura'].".html";
                        $sql="update factura_despacho set id_factura_despacho = '".$_POST['id_factura']."',url_documento = '".$url."',tipo_documento = 'Factura' where id_factura_despacho = '".$_POST['id_despacho']."'";
                                $query_new_insert = mysqli_query($con,$sql);
        
                                $target_file = $carpeta . basename($archivo);
                                $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                                if(move_uploaded_file($tmp_archivo,$target_file)) {    
                                    $messages[] = "Se ha registrado exitosamente el archivo de la fila ";
                                }else{
                                    $errors []= "Algo ha salido mal al registrar el archivo de la fila  ";
                                }
                            if ($query_new_insert){
                                $messages[] = "Se ha registrado en la tabla factura_despacho exitosamente. ";
                                
                            } else {
                                $errors[]= "ALgo ha salido mal al registrar en la tabla factura_despacho.".mysqli_error($con);
                            }
                        }
                       
?>