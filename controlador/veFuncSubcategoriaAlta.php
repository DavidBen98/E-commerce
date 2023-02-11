<?php 
    require '../inc/conn.php';
    include ('funciones.php');

    global $db;

    $subcategoria = isset($_POST['subInactivas']) ? $_POST['subInactivas'] : null;

    if ($subcategoria !== null){
        $sql = "UPDATE subcategoria SET activo = '1' WHERE id_subcategoria = '$subcategoria'";
        $rs = $db->query($sql);
        header ("location: ../vistas/veSubcategoriaAlta.php?reactivacion=exito");
        exit;
    } else {
        $nombre = isset($_POST['nombre']) && (trim($_POST['nombre']) != '')? trim($_POST['nombre']): null;
        $categoria = (isset($_POST['categoria']) && $_POST['categoria'] !== -1)? $_POST['categoria']: null;
        $existe_imagen = ($_FILES["imagen"]["tmp_name"] != '')? getimagesize($_FILES["imagen"]["tmp_name"]) : null;
    
        if($existe_imagen !== null){
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
                        $imagen = $_FILES['imagen'];
                        $destino_imagen = '../images/subcategorias/';
                        // $result = subir_imagen($imagen, 'veSubcategoriaAlta.php', $destino_imagen);
    
                        if ($rs->fetchColumn() == 0){
                            $sql = "INSERT INTO subcategoria (`nombre_subcategoria`, `id_categoria`) 
                                    VALUES ('$nombre',$categoria)
                            ";
            
                            $rs = $db->query($sql);
            
                            $id_subcategoria = $db->lastInsertId();
            
                            $imagen = $_FILES['imagen'];
                            $destino_imagen = '../images/subcategorias/' . $id_subcategoria;
                            $result = subir_imagen($imagen, 'veSubcategoriaAlta.php', $destino_imagen);
            
                            if(!$result){
                                //inconveniente al subir imagen
                                $sql = "DELETE FROM subcategoria WHERE id_subcategoria = '$id_subcategoria'";
                                $rs = $db->query($sql);
                                header ("location: ../vistas/veSubcategoriaAlta.php?error=1");
                                exit;
                            }else{
                                $sql = "INSERT INTO `imagen_subcategorias`(`id_subcategoria`, `destination`) 
                                        VALUES ('$id_subcategoria','$result')
                                ";
                                $rs=$db->query($sql);
    
                                //exitoso
                                header ("location: ../vistas/veSubcategoriaAlta.php?alta=exito");
                                exit;
                            }  
                        } else {
                            //El nombre ya existe
                            header ("location: ../vistas/veSubcategoriaAlta.php?error=2");
                            exit;
                        }
                    } else {
                        //categoria no existente en bd
                        header ("location: ../vistas/veSubcategoriaAlta.php?error=5");
                        exit;
                    }
                } else {
                    //categoria vacia
                    header ("location: ../vistas/veSubcategoriaAlta.php?error=6");
                    exit;
                }
            } else {
                //nombre vacio
                header ("location: ../vistas/veSubategoriaAlta.php?error=3");
                exit;     
            } 
        } else {
            //imagen vacia
            header ("location: ../vistas/veSubcategoriaAlta.php?error=4");
            exit;
        }
    }
?>