<?php
    //Recibimos los datos de la imagen
    $nombre_imagen=$_FILES['imagen']['name'];
    
    $tipo_imagen=$_FILES['imagen']['type'];
    
    $tamagno_imagen=$_FILES['imagen']['size'];
    
    //Condicional para el tamaño de la imagen
    if($tamagno_imagen <= 1000000){
        if($tipo_imagen=="image/jpeg" || $tipo_imagen=="image/jpg" || $tipo_imagen=="image/png")
        {
            
    //Carpeta de destino de servidor
    $carpeta_destino=$_SERVER['DOCUMENT_ROOT'] . '/crud2/uploads/';
    
    //Movemos la imagen del directorio temporal al directorio escogido
    
    move_uploaded_file($_FILES['imagen']['tmp_name'], $carpeta_destino.$nombre_imagen);
        }else {
            echo "Solo se puede subir imagenes .jpeg/.jpg/.png";
        }
    
    }else{
        echo "El tamaño es demasiado grande";
    }
    
        
    
    
    

?>