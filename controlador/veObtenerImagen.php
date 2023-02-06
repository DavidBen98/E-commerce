<?php
    include ('../inc/conn.php');
    global $db;

    if (isset($_POST['subcategoria'])){
        $subcategoria = $_POST['subcategoria'];
        $sql = "SELECT destination FROM `imagen_subcategorias` WHERE id_subcategoria = '$subcategoria'";

    } else if (isset($_POST['categoria'])){
        $categoria = $_POST['categoria'];
        $sql = "SELECT destination FROM `imagen_categorias` WHERE id_categoria = '$categoria'";
    }

    $rs = $db->query($sql);
    foreach($rs as $r){
        $path = $r['destination'];
    }

    echo "../".$path;
?>