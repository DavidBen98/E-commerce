<?php 
    require "../inc/conn.php";
    include_once "funciones.php";

    global $db;
    $idCategoria = isset($_POST["categoria"])? $_POST["categoria"]: null;
    $modNombre = isset($_POST["modNombre"]) ? $_POST["modNombre"] : null;
    $modImagen = isset($_POST["modImagen"]) ? $_POST["modImagen"] : null;

    if ($modNombre == null && $modImagen == null){
        //Debe modificar al menos un campo
        header ("location: ../vistas/veCategoriaModif.php?categoria=$idCategoria&error=1#mensaje");
    }
    
    if ($modNombre != null){
        $nombre = (isset($_POST["nombre"]) && trim($_POST["nombre"]) != "")? ucfirst(trim($_POST["nombre"])): null;

        if ($nombre == null){
            //Error: falta rellenar el campo nombre
            header ("location: ../vistas/veCategoriaModif.php?categoria=$idCategoria&error=2#mensaje");
        } else {
            $sql = "SELECT COUNT(*)
                    FROM categoria
                    WHERE nombre_categoria = '$nombre'
            ";

            $rs = $db->query($sql);

            if ($rs->fetchColumn() == 0){
                $rs = $db->query ("UPDATE `categoria` SET `nombre_categoria`='$nombre' WHERE `id_categoria` = $idCategoria");
                
                if ($modImagen == null){
                    header ("location: ../vistas/veCategoriaModif.php?categoria=$idCategoria&modif=exito#mensaje");
                }
            } else{
                header ("location: ../vistas/veCategoriaModif.php?categoria=$idCategoria&error=5#mensaje");
            }
        }
    }

    if ($modImagen != null){
        $imagen = $_FILES["imagen"];
        $check = ($imagen["tmp_name"] != "")? getimagesize($imagen["tmp_name"]) : false;

        if ($check == false){
            //Error: falta rellenar el campo imagen
            if($modNombre != null){
                header ("location: ../vistas/veCategoriaModif.php?categoria=$idCategoria&nombre=exito&error=3#mensaje");
            } else {
                header ("location: ../vistas/veCategoriaModif.php?categoria=$idCategoria&error=3#mensaje");
            }
        } else {
            $path = "../images/categorias/";
            $files = scandir($path);
        
            foreach($files as $file){
                if ($file == $idCategoria.".png" || $file == $idCategoria.".jpg" || $file == $idCategoria.".jpeg"){
                    $path .= $file;
                }
            }
    
            //Si existe una imagen para esa categoria
            //Siempre debería entrar aca, ya que al crear una nueva categoria es obligatorio que tenga una imagen
            //Sin embargo para hacer mas robusta la aplicación se hace la validación
            if ($path != "../images/categorias/"){
                deleteDir($path);
            }
    
            $url = "veCategoriaModif.php";
            $path = "images/categorias/".$idCategoria;
            $error = subirImagen($imagen, $url, $path);
    
            if ($error){
                header ("location: ../vistas/veCategoriaModif.php?categoria=$idCategoria&error=4#mensaje");
            } else {
                header ("location: ../vistas/veCategoriaModif.php?categoria=$idCategoria&modif=exito#mensaje");
            }
        }
    }
?>