<?php 
    require 'inc/conn.php';
    include_once ("funciones.php");

    global $db;
    $id_categoria = isset($_POST['categoria'])? $_POST['categoria']: null;
    $modNombre = isset($_POST['modNombre']) ? $_POST['modNombre'] : null;
    $modImagen = isset($_POST['modImagen']) ? $_POST['modImagen'] : null;

    if ($modNombre === null && $modImagen === null){
        //Debe modificar al menos un campo
        header ("location: veCategoriaModif.php?error=1");
    }
    
    if ($modNombre !== null){
        $nombre = isset($_POST['nombre']) && $_POST['nombre'] !== ""? $_POST['nombre']: null;

        if ($nombre === null){
            //Error: falta rellenar el campo nombre
            header ("location: veCategoriaModif.php?error=2");
        } else {
            $rs = $db->query ("UPDATE `categoria` SET `nombre_categoria`='$nombre' WHERE `id_categoria` = $id_categoria");
        }
    }

    if ($modImagen != null){
        $imagen = $_FILES["imagen"];
        $check = ($imagen["tmp_name"] != '')? getimagesize($imagen["tmp_name"]) : false;

        if ($check == false){
            //Error: falta rellenar el campo imagen
            header ("location: veCategoriaModif.php?error=3");
        }

        $path = 'images/categorias/';
        $files = scandir($path);
    
        foreach($files as $file){
            if ($file == $categoria.".png" || $file == $categoria.".jpg" || $file == $categoria.".jpeg"){
                $path .= $file;
            }
        }

        if ($path !== 'images/categorias/'){
            echo $path;
            // deleteDir($path);
            // $url = 'veCategoriaModif.php';
            // $path = 'images/categorias/'.$id_categoria;
            // $error = uploadImage($imagen, $url, $path);

            // if ($error){
            //     header ("location: veCategoriaModif.php?error=4");
            // }

        } else { 
            //Error imagen no encontrada
            header ("location: veCategoriaModif.php?error=5");
        }
    }
?>