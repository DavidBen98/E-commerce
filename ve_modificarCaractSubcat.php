<?php 
    include ('inc/conn.php');

    global $db;

    $id_subcategoria = isset($_POST['subcategoria'])? $_POST['subcategoria']: null;
    $id_categoria = isset($_POST['categoria'])? $_POST['categoria']: null;

    if ($id_subcategoria !== null && $id_categoria !== null){
        $sql = "UPDATE subcategoria SET id_categoria = '$id_categoria'
                WHERE id_subcategoria = '$id_subcategoria'
        ";

        $rs = $db->query($sql);
    }
    else{
        header ("location: ve_prod_mod.php?error=data");
    }
?>