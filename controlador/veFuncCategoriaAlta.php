<?php 
    require "../inc/conn.php";
    include_once "funciones.php";

    global $db;

    if (isset($_GET['reactivacion'])){
        $categoria = isset($_POST["catInactivas"]) ? $_POST["catInactivas"] : null;

        if ($categoria !== null){
            $sql = "UPDATE categoria SET activo = '1' WHERE id_categoria = '$categoria'";
            $rs = $db->query($sql);
            header ("location: ../vistas/veCategoriaAlta.php?reactivacion=exito");
            exit;
        } else {
            header ("location: ../vistas/veCategoriaAlta.php?error=7");
            exit;
        }
    } else {
        $nombre = isset($_POST["nombre"]) && (trim($_POST["nombre"]) != "")? trim($_POST["nombre"]): null;
        $existe_imagen = ($_FILES["imagen"]["tmp_name"] != "")? getimagesize($_FILES["imagen"]["tmp_name"]) : null;
        
        if($existe_imagen !== null){
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

                    $imagen = $_FILES["imagen"];
                    $destino_imagen = "../images/categorias/" . $id_categoria;
                    $result = subir_imagen($imagen, "veCategoriaAlta.php", $destino_imagen);

                    if(!$result){
                        //inconveniente al subir imagen
                        $sql = "DELETE FROM categoria WHERE id_categoria = '$id_categoria'";
                        $rs = $db->query($sql);

                        header ("location: ../vistas/veCategoriaAlta.php?error=1");
                        exit;
                    } else {
                        $sql = "INSERT INTO `imagen_categorias`(`id_categoria`, `destination`) 
                                VALUES ('$id_categoria','$result')
                        ";
                        $rs = $db->query($sql);
                        //exitoso
                        header ("location: ../vistas/veCategoriaAlta.php?alta=exito");
                        exit;
                    }  
                } else {
                    //El nombre ya existe
                    header ("location: ../vistas/veCategoriaAlta.php?error=2");
                    exit;
                }

            } else {
                //nombre vacio
                header ("location: ../vistas/veCategoriaAlta.php?error=3");    
                exit; 
            } 
        } else {
            //imagen vacia
            header ("location: ../vistas/veCategoriaAlta.php?error=4");
            exit;
        }
    }
?>