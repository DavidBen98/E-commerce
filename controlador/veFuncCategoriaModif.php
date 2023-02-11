<?php 
    require "../inc/conn.php";
    include_once "funciones.php";

    global $db;
    $id_categoria = isset($_POST["categoria"])? $_POST["categoria"]: null;
    $nombre_modificado = isset($_POST["modNombre"]) ? $_POST["modNombre"] : null;
    $imagen_modificada = isset($_POST["modImagen"]) ? $_POST["modImagen"] : null;

    if ($nombre_modificado == null && $imagen_modificada == null){
        //Debe modificar al menos un campo
        header ("location: ../vistas/veCategoriaModif.php?categoria=$id_categoria&error=1#mensaje");
        exit;
    }
    
    if ($nombre_modificado != null){
        $nombre = (isset($_POST["nombre"]) && trim($_POST["nombre"]) != "")? ucfirst(trim($_POST["nombre"])): null;

        if ($nombre == null){
            //Error: falta rellenar el campo nombre
            header ("location: ../vistas/veCategoriaModif.php?categoria=$id_categoria&error=2#mensaje");
            exit;
        } else {
            $sql = "SELECT COUNT(*)
                    FROM categoria
                    WHERE nombre_categoria = '$nombre'
            ";

            $rs = $db->query($sql);

            if ($rs->fetchColumn() == 0){
                $rs = $db->query ("UPDATE `categoria` SET `nombre_categoria`='$nombre' WHERE `id_categoria` = $id_categoria");
                
                if ($imagen_modificada == null){
                    header ("location: ../vistas/veCategoriaModif.php?categoria=$id_categoria&modif=exito#mensaje");
                    exit;
                }
            } else{
                header ("location: ../vistas/veCategoriaModif.php?categoria=$id_categoria&error=5#mensaje");
                exit;
            }
        }
    }

    if ($imagen_modificada != null){
        $imagen = $_FILES["imagen"];
        $check = ($imagen["tmp_name"] != "")? getimagesize($imagen["tmp_name"]) : false;

        if ($check == false){
            //Error: falta rellenar el campo imagen
            if($nombre_modificado != null){
                header ("location: ../vistas/veCategoriaModif.php?categoria=$id_categoria&nombre=exito&error=3#mensaje");
                exit;
            } else {
                header ("location: ../vistas/veCategoriaModif.php?categoria=$id_categoria&error=3#mensaje");
                exit;
            }
        } else {
            $path = "../images/categorias/";
            $files = scandir($path);
        
            foreach($files as $file){
                if ($file == $id_categoria.".png" || $file == $id_categoria.".jpg" || $file == $id_categoria.".jpeg"){
                    $path .= $file;
                }
            }
    
            //Si existe una imagen para esa categoria
            //Siempre debería entrar aca, ya que al crear una nueva categoria es obligatorio que tenga una imagen
            //Sin embargo para hacer mas robusta la aplicación se hace la validación
            if ($path != "../images/categorias/"){
                eliminar_direccion($path);
            }
    
            $url = "veCategoriaModif.php";
            $path = "images/categorias/".$id_categoria;
            $error = subir_imagen($imagen, $url, $path);
    
            if ($error){
                header ("location: ../vistas/veCategoriaModif.php?categoria=$id_categoria&error=4#mensaje");
                exit;
            } else {
                header ("location: ../vistas/veCategoriaModif.php?categoria=$id_categoria&modif=exito#mensaje");
                exit;
            }
        }
    }
?>