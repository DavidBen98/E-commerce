<!DOCTYPE html>
<?php 
    include ('inc/conn.php');

    global $db;

    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];
    $id = $_POST['id'];

    $sql = "UPDATE producto SET id_categoria = '$categoria', id_subcategoria = '$subcategoria'
            WHERE id = '$id'
    ";

    $rs = $db->query($sql);

    $sql = "SELECT destination
            FROM imagen
            WHERE id_producto = '$id' AND portada='1'
    ";

    $rs = $db->query($sql);

    $ruta_destino = 'images/'.$categoria.'/'.$subcategoria.'/'.$id;
    
    foreach ($rs as $row){
        $ruta_origen = $row['destination'];

        //Si existe el directorio, solo mover la imagen
        if (is_dir($ruta_destino)){
            $ruta_destino .= substr($row['destination'],strrpos($row['destination'],'/'), strlen($row['destination'])-1);
            rename($ruta_origen, $ruta_destino);
        } else {
            //Si no existe el directorio, entonces crearlo y luego mover la imagen
            mkdir($ruta_destino);
            $ruta_destino .= substr($row['destination'],strrpos($row['destination'],'/'), strlen($row['destination'])-1);
            rename($ruta_origen, $ruta_destino);
        }

        $sql = "UPDATE imagen SET destination = '$ruta_destino'
            WHERE id_producto = '$id'
        ";

        $rs = $db->query($sql);
    }
    
    header("location: veProductoModif.php?modUbi=exito&id=$id");
?>