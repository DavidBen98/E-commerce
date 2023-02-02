<?php 
    include ('../inc/conn.php');

    global $db;

    $idSubcategoria = isset($_POST['subcategoria'])? $_POST['subcategoria']: null;
    $idCategoria = isset($_POST['categoria'])? $_POST['categoria']: null;

    if ($idSubcategoria !== null && $idCategoria !== null){
        //obtengo la categoria anterior para usarla luego para mover los archivos
        $sql = "SELECT id_categoria FROM subcategoria WHERE id_subcategoria='$idSubcategoria'";
        $rs = $db->query($sql);
        
        foreach ($rs as $row){
            $rutaAntigua = "images/".$row['id_categoria'].'/'.$idSubcategoria;
        }
        
        //Actualizo el id de la categoria en la tabla subcategoria
        $sql = "UPDATE subcategoria SET id_categoria = '$idCategoria'
                WHERE id_subcategoria = '$idSubcategoria'
        ";

        $rs = $db->query($sql);

        //actualizo el id de la categoria en la tabla producto
        $sql = "UPDATE producto SET id_categoria = '$idCategoria'
                WHERE id_subcategoria = '$idSubcategoria'
        ";

        $rs = $db->query($sql);

        //selecciono todos los productos de esa subcategoria
        $sql = "SELECT id
                FROM `producto`
                WHERE id_subcategoria = $idSubcategoria
        ";

        $rs = $db->query($sql);

        foreach ($rs as $row){
            $idProducto = $row['id'];
            //selecciono el path anterior a la actualizacion
            $sql = "SELECT destination 
                    FROM `imagen_productos`
                    WHERE (id_producto = '$idProducto' AND portada='1')
            ";

            $result = $db->query($sql);

            foreach ($result as $r){
                $ext = substr($r['destination'], -4);
            }

            if ($ext[0] === '.'){
                $ext = substr($ext, 1, strlen($ext)-1);
            }

            $path = 'images/'.$idCategoria.'/'.$idSubcategoria.'/'.$idProducto.'/portada.'. $ext;
            $sql = "UPDATE `imagen_productos` SET destination= '$path' WHERE id_producto = '$idProducto'";

            $r = $db->query($sql);
        }

        //Mover todos los archivos de subcategoria a otra carpeta de categorias
        rename($rutaAntigua, "images/".$idCategoria.'/'.$idSubcategoria);

        header ("location: ../veSubcategoriaModif.php?modifU=exito");
    }
    else{
        header ("location: ../veSubcategoriaModif.php?errorU=data");
    }
?>