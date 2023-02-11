<?php 
    require '../inc/conn.php';
    include_once ("funciones.php");

    global $db;
    $id_subcategoria = isset($_POST['subcategoria'])? $_POST['subcategoria']: null;
    $nombre_modificado = isset($_POST['modificar-nombre']) ? $_POST['modificar-nombre'] : null;
    $imagen_modificada = isset($_POST['modificar-imagen']) ? $_POST['modificar-imagen'] : null;

    if ($nombre_modificado == null && $imagen_modificada == null){
        //Debe modificar al menos un campo
        header ("location: ../vesubcategoriaModif.php?subcategoria=$id_subcategoria&error=1#mensaje");
        exit;
    }
    
    if ($nombre_modificado != null){
        $nombre = (isset($_POST['nombre']) && trim($_POST['nombre']) != "")? ucfirst(trim($_POST['nombre'])): null;

        if ($nombre == null){
            //Error: falta rellenar el campo nombre
            header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$id_subcategoria&error=2#mensaje");
            exit;
        } else {
            $sql = "SELECT * 
                    FROM subcategoria
                    WHERE nombre_subcategoria='$nombre'
            ";

            $rs = $db->query($sql);
            $existe = 0;
            foreach ($rs as $row) {
                $existe++;
            }

            if ($existe == 0) {
                $rs = $db->query ("UPDATE `subcategoria` SET `nombre_subcategoria`='$nombre' WHERE `id_subcategoria` = $id_subcategoria");
                
                if ($imagen_modificada == null){
                    header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$id_subcategoria&modif=exito#mensaje");
                    exit;
                }
            } else {
                header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$id_subcategoria&error=5#mensaje");
                exit;
            }
        }
    }

    if ($imagen_modificada != null){
        $imagen = $_FILES["imagen"];
        $check = ($imagen["tmp_name"] != '')? getimagesize($imagen["tmp_name"]) : false;

        if ($check == false){
            //Error: falta rellenar el campo imagen
            if($nombre_modificado != null){
                header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$id_subcategoria&nombre=exito&error=3#mensaje");
                exit;
            } else {
                header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$id_subcategoria&error=3#mensaje");
                exit;
            }
        } else {
            $path = '../images/subcategorias/';
            $files = scandir($path);
        
            foreach($files as $file){
                if ($file == $id_subcategoria.".png" || $file == $id_subcategoria.".jpg" || $file == $id_subcategoria.".jpeg"){
                    $path .= $file;
                }
            }
    
            //Si existe una imagen para esa subcategoria
            //Siempre debería entrar aca, ya que al crear una nueva subcategoria es obligatorio que tenga una imagen
            //Sin embargo para hacer mas robusta la aplicación se hace la validación
            if ($path != '../images/subcategorias/'){
                eliminar_direccion($path);
            }
    
            $url = 'veSubcategoriaModif.php';
            $path = '../images/subcategorias/'.$id_subcategoria;
            $path = subir_imagen($imagen, $url, $path);
    
            if (!$path){
                header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$id_subcategoria&error=4#mensaje");
                exit;
            } else {
                $sql = "UPDATE imagen_subcategorias SET destination = '$path'
                    WHERE id_subcategoria = '$id_subcategoria'
                ";

                $rs = $db->query($sql);
                header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$id_subcategoria&modif=exito#mensaje");
                exit;
            }
        }
    }
?>