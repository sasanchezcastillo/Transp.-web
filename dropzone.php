<?php
if(isset($_POST['id'])){
//delete/unlink file 
    if(is_file("uploads/".$_POST['id'])){
        unlink("uploads/".$_POST['id']);
    }else{
        echo ("<script>alert('Este archivo por alguna razón no se encontraba en el servidor');</script>");
    }
}
?>