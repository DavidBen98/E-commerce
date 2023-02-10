<?php 
    include ('../inc/conn.php');

    global $db;

    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];
    $id = $_POST['id'];

    $sql = "UPDATE producto SET id_categoria = '$categoria', id_subcategoria = '$subcategoria'
            WHERE id = '$id'
    ";

    $rs = $db->query($sql);

    $sql = "SELECT destination
            FROM imagen_productos
            WHERE id_producto = '$id' AND portada='1'
    ";

    $rs = $db->query($sql);

    $ruta_destino = '../images/'.$categoria.'/'.$subcategoria.'/'.$id;
    
    foreach ($rs as $row){
        $ruta_origen = $row['destination'];

        //Si no existe el directorio, entonces crearlo y luego mover la imagen
        if (!is_dir($ruta_destino)){
            mkdir($ruta_destino);
        }

        $ruta_destino .= substr($row['destination'],strrpos($row['destination'],'/'), strlen($row['destination'])-1);
        
        if (rename("../".$ruta_origen, $ruta_destino)){
            $a = 1;
        } else {
            $a = 0;
        }

        $sql = "UPDATE imagen_productos SET destination = '$ruta_destino'
            WHERE id_producto = '$id'
        ";

        $rs = $db->query($sql);
    }
    
    header("location: ../vistas/veProductoModif.php?modUbi=exito&id=$id");
    exit;
?>