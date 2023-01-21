<?php 
    require 'inc/conn.php';

    global $db;
    
    $nombre = isset($_POST['nombre']) && (trim($_POST['nombre']) != '')? trim($_POST['nombre']): null;
  
    $existImg = ($_FILES["imagen"]["tmp_name"] != '')? getimagesize($_FILES["imagen"]["tmp_name"]) : null;
    
    if($existImg !== null){
        //Comprobar que nombre es diferente de vacío
        if ($nombre !== null){
            //Comprobar que no existe una categoria con ese nombre
            $nombre = ucfirst($nombre);
            
            $sql = "SELECT COUNT(*)
                FROM categoria
                WHERE nombre_categoria = '$nombre'
            ";

            $rs = $db->query($sql);

            if ($rs->fetchColumn() == 0){
                $sql = "INSERT INTO categoria (`nombre_categoria`) 
                        VALUES ('$nombre')
                ";

                $rs = $db->query($sql);

                $id_categoria = $db->lastInsertId();

                $imagen = $_FILES['imagen'];
                $imagen_name = $imagen['name'];
                $imagen_tmp = $imagen["tmp_name"];
                $imagen_error = $imagen['error'];
                $imagen_ext = explode('.',$imagen_name);
                $imagen_ext = strtolower(end($imagen_ext));
                $allowed = array('jpg', 'jpeg', 'png');

                if(in_array($imagen_ext, $allowed)){
                    if($imagen_error === 0){
                        $imagen_name_new = $id_categoria . '.' . $imagen_ext;
                        $imagen_destination = 'images/categorias/' . $imagen_name_new;

                        if(move_uploaded_file($imagen_tmp, $imagen_destination)){
                            header ("location: veCategoriaAlta.php?alta=exito");
                        }else{
                            header ("location: veCategoriaAlta.php?error=1");
                        }
                    }   
                }
            } else {
                header ("location: veCategoriaAlta.php?error=2");
            }
        } else {
            header ("location: veCategoriaAlta.php?error=3");
        }
        
    } else {
        header ("location: veCategoriaAlta.php?error=4");
    }
?>