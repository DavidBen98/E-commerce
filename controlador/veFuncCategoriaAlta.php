<?php 
    require '../inc/conn.php';
    include_once('funciones.php');

    global $db;

    $categoria = isset($_POST['catInactivas']) ? $_POST['catInactivas'] : null;

    if ($categoria !== null){
        $sql = "UPDATE categoria SET activo = '1' WHERE id_categoria = '$categoria'";
        $rs = $db->query($sql);
        header ("location: ../veCategoriaAlta.php?reactivacion=exito");
    } else {
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
                    $imagenDestino = '../images/categorias/' . $id_categoria;
                    $result = subirImagen($imagen, 'veCategoriaAlta.php', $imagenDestino);

                    if(!$result){
                        //inconveniente al subir imagen
                        $sql = "DELETE FROM categoria WHERE id_categoria = '$id_categoria'";
                        $rs = $db->query($sql);

                        header ("location: ../veCategoriaAlta.php?error=1");
                    } else {
                        $sql = "INSERT INTO `imagen_categorias`(`id_categoria`, `destination`) 
                                VALUES ('$id_categoria','$result')
                        ";
                        $rs = $db->query($sql);
                        //exitoso
                        header ("location: ../veCategoriaAlta.php?alta=exito");
                    }  
                } else {
                    //El nombre ya existe
                    header ("location: ../veCategoriaAlta.php?error=2");
                }

            } else {
                //nombre vacio
                header ("location: ../veCategoriaAlta.php?error=3");     
            } 
        } else {
            //imagen vacia
            header ("location: ../veCategoriaAlta.php?error=4");
        }
    }
?>