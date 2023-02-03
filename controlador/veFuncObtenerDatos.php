<?php 
    require '../inc/conn.php';

    global $db;

    $id = $_POST['id'];

    $sql = "SELECT *
            FROM producto
            WHERE id = '$id'
    ";

    $rs = $db -> query ($sql);

    foreach ($rs as $row){
        $categoria = $row['id_categoria'];
        $subcategoria = $row['id_subcategoria'];
        $datos['codigo'] = $row['codigo'];
        $datos['descripcion'] = $row['descripcion'];
        $datos['color'] = $row['color'];
        $datos['marca'] =  $row['marca'] ;
        $datos['stock'] = $row['stock'];
        $datos['caracteristicas'] = $row['caracteristicas'];
        $datos['material'] = $row['material'];
        $datos['precio'] = $row['precio'];
        $datos['descuento'] = $row['descuento'];
    }

    $sql = "SELECT *
            FROM categoria
            WHERE id_categoria = '$categoria'
    ";

    $rs = $db->query($sql);

    foreach ($rs as $row){
        $datos['categoria'] = $row['nombre_categoria'];
    }

    $sql = "SELECT *
            FROM subcategoria
            WHERE id_subcategoria = '$subcategoria'
    ";

    $rs = $db->query($sql);

    foreach ($rs as $row){
        $datos['subcategoria'] = $row['nombre_subcategoria'];
    }

    echo json_encode($datos);
?>