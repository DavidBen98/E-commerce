<?php 
    require '../inc/conn.php';
    include_once ("funciones.php");

    global $db;
    $idSubcategoria = isset($_POST['subcategoria'])? $_POST['subcategoria']: null;
    $modNombre = isset($_POST['modNombre']) ? $_POST['modNombre'] : null;
    $modImagen = isset($_POST['modImagen']) ? $_POST['modImagen'] : null;

    if ($modNombre == null && $modImagen == null){
        //Debe modificar al menos un campo
        header ("location: ../vesubcategoriaModif.php?subcategoria=$idSubcategoria&error=1#mensaje");
    }
    
    if ($modNombre != null){
        $nombre = (isset($_POST['nombre']) && trim($_POST['nombre']) != "")? ucfirst(trim($_POST['nombre'])): null;

        if ($nombre == null){
            //Error: falta rellenar el campo nombre
            header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$idSubcategoria&error=2#mensaje");
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
                $rs = $db->query ("UPDATE `subcategoria` SET `nombre_subcategoria`='$nombre' WHERE `id_subcategoria` = $idSubcategoria");
                
                if ($modImagen == null){
                    header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$idSubcategoria&modif=exito#mensaje");
                }
            } else {
                header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$idSubcategoria&error=5#mensaje");
            }
        }
    }

    if ($modImagen != null){
        $imagen = $_FILES["imagen"];
        $check = ($imagen["tmp_name"] != '')? getimagesize($imagen["tmp_name"]) : false;

        if ($check == false){
            //Error: falta rellenar el campo imagen
            if($modNombre != null){
                header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$idSubcategoria&nombre=exito&error=3#mensaje");
            } else {
                header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$idSubcategoria&error=3#mensaje");
            }
        } else {
            $path = '../images/subcategorias/';
            $files = scandir($path);
        
            foreach($files as $file){
                if ($file == $idSubcategoria.".png" || $file == $idSubcategoria.".jpg" || $file == $idSubcategoria.".jpeg"){
                    $path .= $file;
                }
            }
    
            //Si existe una imagen para esa subcategoria
            //Siempre debería entrar aca, ya que al crear una nueva subcategoria es obligatorio que tenga una imagen
            //Sin embargo para hacer mas robusta la aplicación se hace la validación
            if ($path != '../images/subcategorias/'){
                deleteDir($path);
            }
    
            $url = 'veSubcategoriaModif.php';
            $path = '../images/subcategorias/'.$idSubcategoria;
            $path = subirImagen($imagen, $url, $path);
    
            if (!$path){
                header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$idSubcategoria&error=4#mensaje");
            } else {
                $sql = "UPDATE imagen_subcategorias SET destination = '$path'
                    WHERE id_subcategoria = '$idSubcategoria'
                ";

                $rs = $db->query($sql);
                header ("location: ../vistas/veSubcategoriaModif.php?subcategoria=$idSubcategoria&modif=exito#mensaje");
            }
        }
    }
?>