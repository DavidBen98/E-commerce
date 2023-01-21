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
                $imagen_destination = 'images/categorias/' . $id_categoria . '.';
                $error = uploadImage($imagen, 'veCategoriaAlta.php', $imagen_destination);

                if($error){
                    //inconveniente al subir imagen
                    $sql = "DELETE FROM categoria WHERE id_categoria = '$id_categoria'";
                    $rs = $db->query($sql);

                    header ("location: veCategoriaAlta.php?error=1");
                }else{
                    //exitoso
                    header ("location: veCategoriaAlta.php?alta=exito");
                }  
            } else {
                //El nombre ya existe
                header ("location: veCategoriaAlta.php?error=2");
            }

        } else {
            //nombre vacio
            header ("location: veCategoriaAlta.php?error=3");     
        } 
    } else {
        //imagen vacia
        header ("location: veCategoriaAlta.php?error=4");
    }
?>