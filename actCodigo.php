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

    $ultimoProducto = 0;
    foreach ($rs as $row){
        $ultimoProducto = $row['codigo'];
    }

    $ultimoProducto = intval(substr($ultimoProducto,3));

    $ultimoProducto = $ultimoProducto + 1; //posicion del nuevo producto

    echo $ultimoProducto;
?>