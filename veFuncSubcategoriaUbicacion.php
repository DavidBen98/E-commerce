<?php 
    include ('inc/conn.php');

    global $db;

    $id_subcategoria = isset($_POST['subcategoria'])? $_POST['subcategoria']: null;
    $id_categoria = isset($_POST['categoria'])? $_POST['categoria']: null;

    if ($id_subcategoria !== null && $id_categoria !== null){
        //obtengo la categoria anterior para usarla luego para mover los archivos
        $sql = "SELECT id_categoria FROM subcategoria WHERE id_subcategoria='$id_subcategoria'";
        $rs = $db->query($sql);
        
        foreach ($rs as $row){
            $ruta_antigua = "images/".$row['id_categoria'].'/'.$id_subcategoria;
        }
        
        //Actualizo el id de la categoria en la tabla subcategoria
        $sql = "UPDATE subcategoria SET id_categoria = '$id_categoria'
                WHERE id_subcategoria = '$id_subcategoria'
        ";

        $rs = $db->query($sql);

        //actualizo el id de la categoria en la tabla producto
        $sql = "UPDATE producto SET id_categoria = '$id_categoria'
                WHERE id_subcategoria = '$id_subcategoria'
        ";

        $rs = $db->query($sql);

        //selecciono todos los productos de esa subcategoria
        $sql = "SELECT id
                FROM `producto`
                WHERE id_subcategoria = $id_subcategoria
        ";

        $rs = $db->query($sql);

        foreach ($rs as $row){
            $id_producto = $row['id'];
            //selecciono el path anterior a la actualizacion
            $sql = "SELECT destination 
                    FROM `imagen_productos`
                    WHERE (id_producto = '$id_producto' AND portada='1')
            ";

            $result = $db->query($sql);

            foreach ($result as $r){
                $ext = substr($r['destination'], -4);
            }

            if ($ext[0] === '.'){
                $ext = substr($ext, 1, strlen($ext)-1);
            }

            $path = 'images/'.$id_categoria.'/'.$id_subcategoria.'/'.$id_producto.'/portada.'. $ext;
            $sql = "UPDATE `imagen_productos` SET destination= '$path' WHERE id_producto = '$id_producto'";

            $r = $db->query($sql);
        }

        //Mover todos los archivos de subcategoria a otra carpeta de categorias
        rename($ruta_antigua, "images/".$id_categoria.'/'.$id_subcategoria);

        header ("location: veSubcategoriaModif.php?modifU=exito");
    }
    else{
        header ("location: veSubcategoriaModif.php?errorU=data");
    }
?>