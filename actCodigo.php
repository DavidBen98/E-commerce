<?php 
    require 'inc/conn.php';

    global $db;
    
    $categoria = $_POST['categoria'];
    $subcategoria = $_POST['subcategoria'];

    $sql = "SELECT id
            FROM producto
            WHERE id_categoria = '$categoria' AND id_subcategoria= '$subcategoria'
    ";

    $rs = $db -> query($sql);

    $nuevoProducto = 0;
    foreach ($rs as $row){
        $nuevoProducto++;
    }

    $nuevoProducto = $nuevoProducto + 1; //posicion del nuevo producto

    echo $nuevoProducto;
?>