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

    $i = 0;
    foreach ($rs as $row){
        $i++;
    }

    $i = $i + 1; //posicion del nuevo producto

    echo $i;
?>