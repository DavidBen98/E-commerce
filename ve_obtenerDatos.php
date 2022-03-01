<?php 
    require 'inc/conn.php';

    global $db;

    $codigo = $_POST['codigo'];

    $sql = "SELECT *
            FROM producto
            WHERE codigo = '$codigo'
    ";

    $rs = $db -> query ($sql);

    foreach ($rs as $row){
        $categoria = $row['id_categoria'];
        $subcategoria = $row['id_subcategoria'];
        $datos['descripcion'] = $row['descripcion'];
        $datos['color'] = $row['color'];
        $datos['marca'] =  $row['marca'] ;
        $datos['stock'] = $row['stock'];
        $datos['caracteristicas'] = $row['caracteristicas'];
        //$datos['imagen'] = $row['imagen'];
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