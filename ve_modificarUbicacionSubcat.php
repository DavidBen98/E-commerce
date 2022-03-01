<?php 
    include ('inc/conn.php');

    global $db;

    $id_subcategoria = isset($_POST['subcategoria'])? $_POST['subcategoria']: null;
    $nombre_subcategoria = isset($_POST['nombre'])? $_POST['nombre']: null;

    if ($id_subcategoria !== null && $nombre_subcategoria !== null){
        $sql = "UPDATE subcategoria SET nombre_subcategoria = '$nombre_subcategoria'
                WHERE id_subcategoria = '$id_subcategoria'
        ";

        $rs = $db->query($sql);
    }
    else{
        header ("location: veSubcategoriaModif.php?error=data");
    }
?>