<?php 
    require '../inc/conn.php';
    include ('funciones.php');

    global $db;
    
    $nombre = isset($_POST['nombre']) && (trim($_POST['nombre']) != '')? trim($_POST['nombre']): null;
    $categoria = (isset($_POST['categoria']) && $_POST['categoria'] !== -1)? $_POST['categoria']: null;
    $existImg = ($_FILES["imagen"]["tmp_name"] != '')? getimagesize($_FILES["imagen"]["tmp_name"]) : null;

    if($existImg !== null){
        //Comprobar que nombre es diferente de vacío
        if ($nombre !== null){
            //Comprobar que se seleccionó una categoría
            if ($categoria !== null){
                $sql = "SELECT id_categoria FROM `categoria` WHERE id_categoria = $categoria";
                $rs = $db->query($sql);

                //Comprobar que se seleccionó una categoría que existe en nuestra BD
                //porque se podría pasar como valor un id que no exista
                if ($rs->fetchColumn()> 0) {
                    $nombre = ucfirst($nombre);
                    
                    $sql = "SELECT COUNT(*)
                            FROM subcategoria
                            WHERE nombre_subcategoria = '$nombre'
                    ";
        
                    $rs = $db->query($sql);
        
                    if ($rs->fetchColumn() == 0){
                        $sql = "INSERT INTO subcategoria (`nombre_subcategoria`, `id_categoria`) 
                                VALUES ('$nombre',$categoria)
                        ";
        
                        $rs = $db->query($sql);
        
                        $idSubcategoria = $db->lastInsertId();
        
                        $imagen = $_FILES['imagen'];
                        $imagenDestino = 'images/subcategorias/' . $idSubcategoria;
                        $result = subirImagen($imagen, 'veSubcategoriaAlta.php', $imagenDestino);
        
                        if(!$result){
                            //inconveniente al subir imagen
                            $sql = "DELETE FROM subcategoria WHERE id_subcategoria = '$idSubcategoria'";
                            $rs = $db->query($sql);
                            header ("location: ../veSubcategoriaAlta.php?error=1");
                        }else{
                            $sql = "INSERT INTO `imagen_subcategorias`(`id_subcategoria`, `destination`) 
                                    VALUES ('$idSubcategoria','$result')
                            ";
                            $rs=$db->query($sql);

                            //exitoso
                            header ("location: ../veSubcategoriaAlta.php?alta=exito");
                        }  
                    } else {
                        //El nombre ya existe
                        header ("location: ../veSubcategoriaAlta.php?error=2");
                    }
                } else {
                    //categoria no existente en bd
                    header ("location: ../veSubcategoriaAlta.php?error=5");
                }
            } else {
                //categoria vacia
                header ("location: ../veSubcategoriaAlta.php?error=6");
            }
        } else {
            //nombre vacio
            header ("location: ../veSubategoriaAlta.php?error=3");     
        } 
    } else {
        //imagen vacia
        header ("location: ../veSubcategoriaAlta.php?error=4");
    }
?>