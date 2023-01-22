<?php 
    require 'inc/conn.php';
    include_once ("funciones.php");

    global $db;
    $id_subcategoria = isset($_POST['subcategoria'])? $_POST['subcategoria']: null;
    $modNombre = isset($_POST['modNombre']) ? $_POST['modNombre'] : null;
    $modImagen = isset($_POST['modImagen']) ? $_POST['modImagen'] : null;

    if ($modNombre == null && $modImagen == null){
        //Debe modificar al menos un campo
        header ("location: vesubcategoriaModif.php?subcategoria=$id_subcategoria&error=1#mensaje");
    }
    
    if ($modNombre != null){
        $nombre = (isset($_POST['nombre']) && trim($_POST['nombre']) != "")? ucfirst(trim($_POST['nombre'])): null;

        if ($nombre == null){
            //Error: falta rellenar el campo nombre
            header ("location: vesubcategoriaModif.php?subcategoria=$id_subcategoria&error=2#mensaje");
        } else {
            $rs = $db->query ("UPDATE `subcategoria` SET `nombre_subcategoria`='$nombre' WHERE `id_subcategoria` = $id_subcategoria");
            
            if ($modImagen == null){
                header ("location: vesubcategoriaModif.php?subcategoria=$id_subcategoria&modif=exito#mensaje");
            }
        }
    }

    if ($modImagen != null){
        $imagen = $_FILES["imagen"];
        $check = ($imagen["tmp_name"] != '')? getimagesize($imagen["tmp_name"]) : false;

        if ($check == false){
            //Error: falta rellenar el campo imagen
            if($modNombre != null){
                header ("location: vesubcategoriaModif.php?subcategoria=$id_subcategoria&nombre=exito&error=3#mensaje");
            } else {
                header ("location: vesubcategoriaModif.php?subcategoria=$id_subcategoria&error=3#mensaje");
            }
        } else {
            $path = 'images/subcategorias/';
            $files = scandir($path);
        
            foreach($files as $file){
                if ($file == $id_subcategoria.".png" || $file == $id_subcategoria.".jpg" || $file == $id_subcategoria.".jpeg"){
                    $path .= $file;
                }
            }
    
            //Si existe una imagen para esa subcategoria
            //Siempre debería entrar aca, ya que al crear una nueva subcategoria es obligatorio que tenga una imagen
            //Sin embargo para hacer mas robusta la aplicación se hace la validación
            if ($path != 'images/subcategorias/'){
                deleteDir($path);
            }
    
            $url = 'vesubcategoriaModif.php';
            $path = 'images/subcategorias/'.$id_subcategoria;
            $error = uploadImage($imagen, $url, $path);
    
            if ($error){
                header ("location: vesubcategoriaModif.php?subcategoria=$id_subcategoria&error=4#mensaje");
            } else {
                header ("location: vesubcategoriaModif.php?subcategoria=$id_subcategoria&modif=exito#mensaje");
            }
        }
    }
?>